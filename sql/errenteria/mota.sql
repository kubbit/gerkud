SET foreign_key_checks = 0;

TRUNCATE TABLE mota;
INSERT INTO `mota` (`id`) VALUES
	(1),
	(2),
	(3),
	(4),
	(5),
	(6),
	(7),
	(8),
	(9),
	(10),
	(99);

TRUNCATE TABLE mota_translation;
INSERT INTO `mota_translation` (`id`, `izena`, `lang`) VALUES
	(1, 'Alcaldía', 'es'),
	(1, 'Alkatetza', 'eu'),
	(2, 'Archivo', 'es'),
	(2, 'Artxiboa', 'eu'),
	(3, 'Servicios Sociales', 'es'),
	(3, 'Gizarte Zerbitzuak', 'eu'),
	(4, 'Educación y Juventud', 'es'),
	(4, 'Heziketa eta Gazteria', 'eu'),
	(5, 'Mantenimiento Urbano', 'es'),
	(5, 'Hiri Mantenimendua', 'eu'),
	(6, 'Urbanismo', 'es'),
	(6, 'Hirigintza', 'eu'),
	(7, 'Informática', 'es'),
	(7, 'Informatika', 'eu'),
	(8, 'Cultura', 'es'),
	(8, 'Kultura', 'eu'),
	(9, 'Policía Local', 'es'),
	(9, 'Udaltzaingoa', 'eu'),
	(10, 'Euskara', 'es'),
	(10, 'Euskara', 'eu'),
	(99, 'Ciudadanos', 'es'),
	(99, 'Herritarrena', 'eu');

TRUNCATE TABLE azpimota;
INSERT INTO `azpimota` (`id`, `mota_id`) VALUES
	(901, 9),
	(902, 9),
	(903, 9),
	(904, 9),
	(905, 9),
	(906, 9),
	(907, 9),
	(908, 9),
	(909, 9),
	(910, 9);

TRUNCATE TABLE azpimota_translation;
INSERT INTO `azpimota_translation` (`id`, `izena`, `lang`) VALUES
	(901, 'Asfaltado', 'es'),
	(901, 'Asfaltatzea', 'eu'),
	(902, 'Garajes, Vados, Reservados', 'es'),
	(902, 'Garajeak, Pasabideak, Erreserbatuak', 'eu'),
	(903, 'Hitos Hidráulicos', 'es'),
	(903, 'Hito Hidraulikoak', 'eu'),
	(904, 'Marquesinas Bus', 'es'),
	(904, 'Autobus geltokiak', 'eu'),
	(905, 'Pivotes, Bolardos', 'es'),
	(905, 'Piboteak, Paperontziak', 'eu'),
	(906, 'Semáforos', 'es'),
	(906, 'Semaforoak', 'eu'),
	(907, 'Señalización horizontal', 'es'),
	(907, 'Seinalizazio horizontala', 'eu'),
	(908, 'Señalización vertical', 'es'),
	(908, 'Seinalizazio bertikala', 'eu'),
	(909, 'Tráfico y Transportes-otros', 'es'),
	(909, 'Trafikoa eta garraioak - besteak', 'eu'),
	(910, 'Veladores', 'es'),
	(910, 'Terrazak', 'eu');

SET foreign_key_checks = 1;
