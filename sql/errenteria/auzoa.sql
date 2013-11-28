SET foreign_key_checks = 0;

TRUNCATE TABLE auzoa;
INSERT INTO `auzoa` (`id`, `barrutia_id`, `izena`) VALUES
	(1, NULL, 'Agustinak'),
	(2, NULL, 'Alaberga'),
	(3, NULL, 'Beraun'),
	(5, NULL, 'Centro'),
	(6, NULL, 'Fanderia - Gabierrota - Larzabal'),
	(7, NULL, 'Galtzaraborda'),
	(8, NULL, 'Gaztaño'),
	(9, NULL, 'Iztieta'),
	(4, NULL, 'Kaputxinoak'),
	(10, NULL, 'Olibet - casas nuevas'),
	(12, NULL, 'Otros'),
	(11, NULL, 'Pontika'),
	(14, NULL, 'Zona Rural'),
	(15, NULL, 'ZZ_Colegios'),
	(17, NULL, 'ZZ_Edificios y Locales'),
	(18, NULL, 'ZZ_Genérico'),
	(16, NULL, 'ZZ_Servicios Sociales');

SET foreign_key_checks = 1;
