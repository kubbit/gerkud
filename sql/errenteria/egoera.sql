SET foreign_key_checks = 0;

TRUNCATE TABLE egoera;
INSERT INTO `egoera` (`id`, `kolorea`) VALUES
  (1, '#FFFFFF'),
  (2, '#55ff00'),
  (4, '#FF8002'),
  (5, '#ff0000'),
  (6, '#00FFFF');

TRUNCATE TABLE egoera_translation;
INSERT INTO `egoera_translation` (`id`, `izena`, `lang`) VALUES
  (2, 'Asignada', 'es'),
  (6, 'Baztertua', 'eu'),
  (6, 'Descartada', 'es'),
  (5, 'Eginda', 'eu'),
  (4, 'En proceso', 'es'),
  (5, 'Terminada', 'es'),
  (1, 'Onartu gabe', 'eu'),
  (2, 'Esleitua', 'eu'),
  (4, 'Prozesuan', 'eu'),
  (1, 'Sin aceptar', 'es');

SET foreign_key_checks = 1;
