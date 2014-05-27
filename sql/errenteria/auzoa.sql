SET foreign_key_checks = 0;

TRUNCATE TABLE auzoa;
INSERT INTO `auzoa` (`id`, `barrutia_id`, `izena`) VALUES
	(1, NULL, 'Agustinak'),
	(2, NULL, 'Alaberga'),
	(3, NULL, 'Beraun'),
	(4, NULL, 'Kaputxinoak'),
	(5, NULL, 'Centro'),
	(6, NULL, 'Fanderia - Gabierrota - Larzabal'),
	(7, NULL, 'Galtzaraborda'),
	(8, NULL, 'Gaztaño'),
	(9, NULL, 'Iztieta'),
	(10, NULL, 'Olibet - casas nuevas'),
	(11, NULL, 'Pontika'),
	(12, NULL, 'Otros'),
	(14, NULL, 'Zona Rural'),
	(15, NULL, 'ZZ_Colegios'),
	(16, NULL, 'ZZ_Servicios Sociales'),
	(17, NULL, 'ZZ_Edificios y Locales'),
	(18, NULL, 'ZZ_Genérico'),
	(19, NULL, 'ZZ_Errenteria Garatuz');

SET foreign_key_checks = 1;
