SET foreign_key_checks = 0;

TRUNCATE TABLE erlazio_mota;
INSERT INTO `erlazio_mota` (`id`) VALUES
	(1),
	(2);

TRUNCATE TABLE erlazio_mota_translation;
INSERT INTO `erlazio_mota_translation` (`id`, `izena`, `lang`) VALUES
	(1, 'Duplicada', 'es'),
	(1, 'Errepikatuta', 'eu'),
	(2, 'Relacionada', 'es'),
	(2, 'Erlazionatuta', 'eu');

SET foreign_key_checks = 1;
