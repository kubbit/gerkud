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
  (1, 'Onartu gabe', 'eu'),
  (1, 'Sin aceptar', 'es'),
  (2, 'Esleitua', 'eu'),
  (2, 'Asignada', 'es'),
  (3, 'Planifikatua', 'eu'),
  (3, 'Planificada', 'es'),
  (4, 'Prozesuan', 'eu'),
  (4, 'En proceso', 'es'),
  (5, 'Eginda', 'eu'),
  (5, 'Terminada', 'es'),
  (6, 'Baztertua', 'eu'),
  (6, 'Descartada', 'es'),
  (7, 'Zain', 'eu'),  
  (7, 'En espera', 'es'),
  (8, 'Baliabiderik ez', 'eu'),
  (8, 'Sin recursos', 'es'); 

SET foreign_key_checks = 1;
