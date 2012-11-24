CREATE OR REPLACE VIEW denborak AS
SELECT
  id,
  created_at,
  (SELECT created_at FROM iruzkina i WHERE g.id = i.gertakaria_id AND ekintza_id = 2 ORDER BY created_at LIMIT 1) AS esleitua,
  hasiera_adieraz,
  ixte_data,
  amaiera_adieraz,
  saila_id,
  egoera_id
 FROM gertakaria g;

DROP PROCEDURE IF EXISTS estatistikak;

DELIMITER //
/*
 * pInicio: filtro de fecha inicial
 * pFin: filtro de fecha final
 * pTaula: tabla estadística a obtener
 *         1: por periodos de fechas
 *         2: por departamento
 *         3: por rangos de dias
 * pTartea: periodos (sólo válido para el tipo de tabla 1)
 *          1: por año
 *          2: por mes
 *          3: por dia
 *          4: por semana
 * pSaila: filtro de departamento (no válido para el tipo de tabla 2)
 */
CREATE PROCEDURE estatistikak(IN pInicio DATE, IN pFin DATE, IN pTaula INTEGER, IN pTartea INTEGER, IN pSaila INTEGER, IN pHizkuntza CHAR(2))
BEGIN
	DECLARE minimo DATE;
	DECLARE maximo DATE;
	DECLARE agno INT;
	DECLARE primerAgno INT;
	DECLARE ultimoAgno INT;
	DECLARE mes INT;
	DECLARE primerMes INT;
	DECLARE ultimoMes INT;
	DECLARE dia INT;
	DECLARE primerDia INT;
	DECLARE ultimoDia INT;
	DECLARE semana INT;
	DECLARE primeraSemana INT;
	DECLARE ultimaSemana INT;
	DECLARE semanaIni DATE;
	DECLARE semanaFin DATE;
	DECLARE fecha DATE;
	
	SELECT min(created_at) FROM gertakaria INTO minimo;
	SELECT max(updated_at) FROM gertakaria INTO maximo;

	# obtener las fechas de inicio y fin si no se han especificado
	SELECT coalesce(pInicio, minimo) INTO pInicio;
	SELECT coalesce(pFin, maximo) INTO pFin;

	# no devolver datos de fechas de las que no hay registros
	IF minimo > pInicio THEN
		SET pInicio = minimo;
	END IF;

	IF maximo < pFin THEN
		SET pFin = maximo;
	END IF;

	CASE pTaula
		# Datos por periodos
		WHEN 1 THEN
		BEGIN
			# generar tabla con los intervalos de fechas
			START TRANSACTION;
			DROP TABLE IF EXISTS tarteak;
			CREATE TEMPORARY TABLE tarteak
			(
				hasiera DATE,
				amaiera DATE
			);
		
			SELECT year(pInicio) INTO primerAgno;
			SELECT year(pFin) INTO ultimoAgno;
			SET agno = primerAgno;
			WHILE agno <= ultimoAgno DO
				SELECT 1 INTO primerMes;
				SELECT 12 INTO ultimoMes;
		
				IF agno = primerAgno THEN
					SELECT day(pInicio) INTO primerDia;
					SELECT month(pInicio) INTO primerMes;
					SELECT week(pInicio) INTO primeraSemana;
				END IF;
		
				IF agno = ultimoAgno THEN
					SELECT day(pFin) INTO ultimoDia;
					SELECT month(pFin) INTO ultimoMes;
					SELECT week(pFin) INTO ultimaSemana;
				END IF;
				
				IF pTartea = 1 THEN
					INSERT INTO tarteak (hasiera, amaiera) VALUES (concat(agno, '/', primerMes, '/', primerDia), concat(agno, '/', ultimoMes, '/', ultimoDia));
				END IF;

				IF pTartea = 2 OR pTartea = 3 THEN		
					SET mes = primerMes;
					WHILE mes <= ultimoMes DO
						SELECT cast(concat(agno, '/', mes, '/', 1) AS DATE) INTO fecha;
		
						SET primerDia = 1;
						SELECT day(last_day(fecha)) INTO ultimoDia;
		
						IF mes = primerMes AND agno = primerAgno THEN
							SELECT day(pInicio) INTO primerDia;
						END IF;
		
						IF agno = ultimoAgno AND mes = ultimoMes THEN
							SELECT day(pFin) INTO ultimoDia;
						END IF;
		
						IF pTartea = 2 THEN
							INSERT INTO tarteak (hasiera, amaiera) VALUES (concat(agno, '/', mes, '/', primerDia), concat(agno, '/', mes, '/', ultimoDia));
						END IF;
					
						IF pTartea = 3 THEN
							SET dia = primerDia;
							WHILE dia <= ultimoDia DO
								INSERT INTO tarteak (hasiera, amaiera) VALUES (concat(agno, '/', mes, '/', dia), concat(agno, '/', mes, '/', dia));
							
								SET dia = dia + 1;
							END WHILE;
						END IF;
		
						SET mes = mes + 1;
					END WHILE;
				END IF;
				
				IF pTartea = 4 THEN
					SET semana = primeraSemana;
					WHILE semana <= ultimaSemana DO
						SET fecha = adddate(concat(agno, '/01/01'), INTERVAL 7 * semana DAY);
						SELECT subdate(fecha, INTERVAL weekday(fecha) DAY) INTO semanaIni;
						SELECT adddate(fecha, INTERVAL 6 - weekday(fecha) DAY) INTO semanaFin;

						# si es la semana de inicio o fin del filtro, coger las fechas indicadas
						SET fecha = semanaIni;
						IF pInicio >= semanaIni AND pInicio <= semanaFin THEN
							SET semanaIni = pInicio;
						END IF;

						IF pFin >= fecha AND pFin <= semanaFin THEN
							SET semanaFin = pFin;
						END IF;

						INSERT INTO tarteak (hasiera, amaiera) VALUES (semanaIni, semanaFin);

						SET semana = semana + 1;
					END WHILE;
				END IF;
		
				SET agno = agno + 1;
			END WHILE;

			# obtener datos cruzando con la tabla recien creada
			SELECT *
			 FROM
			(
			SELECT
			  CASE
			   WHEN pTartea = 1 THEN date_format(i.hasiera, '%Y')
			   WHEN pTartea = 2 THEN date_format(i.hasiera, '%Y - %m')
			   WHEN pTartea = 3 THEN date_format(i.hasiera, '%Y-%m-%d')
			   WHEN pTartea = 4 THEN date_format(i.hasiera, '%Y - %v')
			  END AS datatartea,
			  # nuevas incidencias creadas durante el intervalo
			  (SELECT count(*) FROM gertakaria WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND CAST(created_at AS DATE) BETWEEN i.hasiera AND i.amaiera) AS berriak,
			  # incidencias que había abiertas durante el intervalo
			  (SELECT count(*) FROM gertakaria WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND CAST(created_at AS DATE) BETWEEN pInicio AND i.amaiera AND ((egoera_id <> 5 AND egoera_id <> 6) OR CAST(ixte_data AS DATE) > i.amaiera)) AS irekiak,
			  # incidencias que han sido rechazadas durante el intervalo
			  (SELECT count(*) FROM gertakaria WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND egoera_id = 6 AND CAST(ixte_data AS DATE) BETWEEN i.hasiera AND i.amaiera) AS baztertuak,
			  # incidencias que han sido resueltas durante el intervalo
			  (SELECT count(*) FROM gertakaria WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND egoera_id = 5 AND CAST(ixte_data AS DATE) BETWEEN i.hasiera AND i.amaiera) AS ebatziak,
			  # tiempos medios de resolución para las resueltas durante el intervalo
			  (SELECT avg(datediff(ixte_data, esleitua)) FROM denborak WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND egoera_id = 5 AND CAST(ixte_data AS DATE) BETWEEN i.hasiera AND i.amaiera) AS 'ebatzien egun batazbestekoa'
			 FROM tarteak i
			 ORDER BY i.hasiera
			 ) datuak
			UNION ALL
			SELECT
			  NULL,
			  (SELECT count(*) FROM gertakaria WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND CAST(created_at AS DATE) BETWEEN pInicio AND pFin),
			  (SELECT count(*) FROM gertakaria WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND CAST(created_at AS DATE) BETWEEN pInicio AND pFin AND ((egoera_id <> 5 AND egoera_id <> 6) OR CAST(ixte_data AS DATE) > pFin)),
			  (SELECT count(*) FROM gertakaria WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND egoera_id = 6 AND CAST(ixte_data AS DATE) BETWEEN pInicio AND pFin),
			  (SELECT count(*) FROM gertakaria WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND egoera_id = 5 AND CAST(ixte_data AS DATE) BETWEEN pInicio AND pFin),
			  (SELECT avg(datediff(ixte_data, esleitua)) FROM denborak WHERE if(pSaila IS NULL, 1 = 1, saila_id = pSaila) AND egoera_id = 5 AND CAST(ixte_data AS DATE) BETWEEN pInicio AND pFin);


			DROP TABLE IF EXISTS tarteak;

			# Commit deberia de ser mas rapido, aunque el resultado en este caso es el mismo
			#ROLLBACK;
			COMMIT;
		END;

		# Por departamentos
		WHEN 2 THEN
		BEGIN
		    SELECT *
		     FROM
		    (
			SELECT
			  s.name AS saila,
			  # nuevas incidencias creadas durante el intervalo
			  (SELECT count(*) FROM denborak t WHERE s.id = t.saila_id AND CAST(t.created_at AS DATE) BETWEEN pInicio AND pFin) AS irekiak,
			  # incidencias que han sido resueltas durante el intervalo
			  (SELECT count(*) FROM denborak t WHERE s.id = t.saila_id AND t.egoera_id = 5 AND CAST(t.ixte_data AS DATE) BETWEEN pInicio AND pFin) AS ebatziak,
			  # tiempos medios de resolución para las resueltas durante el intervalo
			  (SELECT avg(datediff(ixte_data, esleitua)) FROM denborak t WHERE s.id = t.saila_id AND t.egoera_id = 5 AND CAST(t.ixte_data AS DATE) BETWEEN pInicio AND pFin) AS 'ebatzien egun batazbestekoa'
			 FROM sf_guard_group_translation s
			 WHERE lang = pHizkuntza
			 ORDER BY saila
			 ) datuak
			UNION ALL
			SELECT
			  NULL,
			  (SELECT count(*) FROM denborak t WHERE CAST(t.created_at AS DATE) BETWEEN pInicio AND pFin),
			  (SELECT count(*) FROM denborak t WHERE t.egoera_id = 5 AND CAST(t.ixte_data AS DATE) BETWEEN pInicio AND pFin),
			  (SELECT avg(datediff(ixte_data, esleitua)) FROM denborak t WHERE t.egoera_id = 5 AND CAST(t.ixte_data AS DATE) BETWEEN pInicio AND pFin);
		END;

		# Por margenes de tiempo
		WHEN 3 THEN
		BEGIN
			SELECT *
			 FROM
			(
			SELECT
			  CASE
			   WHEN r.minimoa = -99999 THEN concat('< ', r.maximoa + 1)
			   WHEN r.maximoa = 99999 THEN concat('> ', r.minimoa - 1)
			   ELSE concat(r.minimoa, ' ─ ', r.maximoa)
			  END AS egunak,
			  sum(if(datediff(ixte_data, esleitua) BETWEEN r.minimoa AND r.maximoa, 1, 0)) AS 'iraupenekoa',
			  100 * sum(if(datediff(ixte_data, esleitua) BETWEEN r.minimoa AND r.maximoa, 1, 0)) / count(datediff(ixte_data, esleitua)) AS 'iraupenekoa (%)',
			  sum(if(datediff(hasiera_adieraz, esleitua) BETWEEN r.minimoa AND r.maximoa, 1, 0)) AS 'hasierakoa',
			  100 * sum(if(datediff(hasiera_adieraz, esleitua) BETWEEN r.minimoa AND r.maximoa, 1, 0)) / count(datediff(hasiera_adieraz, esleitua)) AS 'hasierakoa (%)',
			  sum(if(datediff(amaiera_adieraz, ixte_data) BETWEEN r.minimoa AND r.maximoa, 1, 0)) AS 'ebazterakoa',
			  100 * sum(if(datediff(amaiera_adieraz, ixte_data) BETWEEN r.minimoa AND r.maximoa, 1, 0)) / count(datediff(amaiera_adieraz, ixte_data)) AS 'ebazterakoa (%)'
			 FROM denborak t,
			  egun_tarteak r
			 WHERE egoera_id = 5
			  AND if(pSaila IS NULL, 1 = 1, saila_id = pSaila)
			 GROUP BY minimoa, maximoa
			 ORDER BY minimoa, maximoa
			 ) datuak
			UNION ALL
			SELECT
			  NULL,
			  sum(if(datediff(ixte_data, esleitua) BETWEEN -99999 AND 99999, 1, 0)),
			  100 * sum(if(datediff(ixte_data, esleitua) BETWEEN -99999 AND 99999, 1, 0)) / count(datediff(ixte_data, esleitua)),
			  sum(if(datediff(hasiera_adieraz, esleitua) BETWEEN -99999 AND 99999, 1, 0)),
			  100 * sum(if(datediff(hasiera_adieraz, esleitua) BETWEEN -99999 AND 99999, 1, 0)) / count(datediff(hasiera_adieraz, esleitua)),
			  sum(if(datediff(amaiera_adieraz, ixte_data) BETWEEN -99999 AND 99999, 1, 0)),
			  100 * sum(if(datediff(amaiera_adieraz, ixte_data) BETWEEN -99999 AND 99999, 1, 0)) / count(datediff(amaiera_adieraz, ixte_data))
			 FROM denborak t
			 WHERE egoera_id = 5
			  AND if(pSaila IS NULL, 1 = 1, saila_id = pSaila);
		END;
	END CASE;
END//

DELIMITER ;


/*
CALL estatistikak('2012/07/01', '2012/11/30', 2, 2, null, 'eu');
*/
