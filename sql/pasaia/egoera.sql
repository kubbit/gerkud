SET foreign_key_checks = 0;

TRUNCATE TABLE egoera;
INSERT INTO `egoera` (`id`, `kolorea`) VALUES
  (1, '#FFFFFF'),
  (2, '#55ff00'),
  (3, '#A17FFF'),
  (4, '#FF8002'),
  (5, '#ff0000'),
  (6, '#00FFFF'),
  (7, '#A54200'),
  (8, '#808080');

TRUNCATE TABLE egoera_translation;
INSERT INTO `egoera_translation` (`id`, `izena`, `lang`) VALUES
  (2, 'Aceptada y asignada', 'es'),
  (6, 'Baztertua', 'eu'),
  (6, 'Descartada', 'es'),
  (5, 'Eginda', 'eu'),
  (7, 'En espera', 'es'),
  (4, 'En proceso', 'es'),
  (5, 'Terminada', 'es'),
  (1, 'Onartu gabe', 'eu'),
  (2, 'Onartua eta esleitua', 'eu'),
  (3, 'Planificada', 'es'),
  (3, 'Planifikatua', 'eu'),
  (4, 'Prozesuan', 'eu'),
  (1, 'Sin aceptar', 'es'),
  (7, 'Zain', 'eu'),
  (8, 'Sin recursos', 'ez')
  (8, 'Baliabiderik ez', 'eu');

SET foreign_key_checks = 1;
