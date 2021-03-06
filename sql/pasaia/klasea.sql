SET foreign_key_checks = 0;

TRUNCATE TABLE klasea;
INSERT INTO `klasea` (`id`) VALUES
	(4),
	(5),
	(6),
	(7),
	(8),
	(9),
	(10),
	(11),
	(12),
	(99);

TRUNCATE TABLE klasea_translation;
INSERT INTO `klasea_translation` (`id`, `izena`, `lang`) VALUES
	(4, 'Trabajos de mantenimiento', 'es'),
	(4, 'Mantentze lanak', 'eu'),
	(5, 'Nuevas solicitudes', 'es'),
	(5, 'Eskaera berriak', 'eu'),
	(6, 'Quejas y reclamaciones', 'es'),
	(6, 'Zerbitzuetako kexa', 'eu'),
	(7, 'Acción propia', 'es'),
	(7, 'Ekintza propioa', 'eu'),
	(8, 'Solicitado por un departamento', 'es'),
	(8, 'Departamentu batek eskatuta', 'eu'),
	(9, 'Otros', 'es'),
	(9, 'Besteak', 'eu'),
	(10, 'Gestión Administrativa', 'es'),
	(10, 'Kudeaketa administratiboa', 'eu'),
	(11, 'Evento', 'es'),
	(11, 'Ekitaldia', 'eu'),
	(12, 'Vandalismo-robos', 'es'),
	(12, 'Bandalismoa-lapurketak', 'eu'),
	(99, 'Ciudadanos', 'es'),
	(99, 'Herritarrena', 'eu');

SET foreign_key_checks = 1;
