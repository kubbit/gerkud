SET foreign_key_checks = 0;

TRUNCATE TABLE eraikina;
INSERT INTO `eraikina` (`id`, `izena`, `barrutia_id`, `longitudea`, `latitudea`) VALUES
  (1, 'Casa Consistorial', 5, -1.898714, 43.312602),
  (2, 'Casa Kapitanenea', 5, -1.898644, 43.312903),
  (3, 'Merkatuzar', 5, -1.899449, 43.31211),
  (4, 'Errenteria Musikal', 5, -1.900755, 43.314378),
  (5, 'Kulturgunea', 5, -1.900624, 43.314519),
  (6, 'Euskaltegi', 11, -1.904357, 43.311197),
  (7, 'Residencia de Ancianos', 6, -1.893001, 43.310608),
  (8, 'Biblioteca Adultos', 5, -1.900538, 43.311724),
  (9, 'Biblioteca Infantil', 5, -1.90043, 43.311939),
  (10, 'Polideportivo Galtzaraborda', 7, -1.906208, 43.31268),
  (11, 'Polideportivo Fanderia', 6, -1.891311, 43.308582),
  (12, 'Policia Local', 12, -1.903032, 43.305865),
  (13, 'Mantenimiento Urbano', 12, -1.902764, 43.305619),
  (14, 'Juzgado', 5, -1.90146, 43.313383),
  (15, 'Servicio Médico', 5, -1.901841, 43.312345),
  (16, 'Torrekua', 5, -1.898097, 43.311818),
  (17, 'Servicios Sociales', 5, -1.896466, 43.31172);

SET foreign_key_checks = 1;
