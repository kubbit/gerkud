SET foreign_key_checks = 0;

TRUNCATE TABLE lehentasuna;
INSERT INTO `lehentasuna` (`id`, `kolorea`) VALUES
  (1, '#55ff00'),
  (2, '#FF8002'),
  (3, '#ff0000');

TRUNCATE TABLE lehentasuna_translation;
INSERT INTO `lehentasuna_translation` (`id`, `izena`, `lang`) VALUES
  (1, 'Arrunta', 'eu'),
  (3, 'Muy Urgente', 'es'),
  (1, 'Normal', 'es'),
  (3, 'Premia larrikoa', 'eu'),
  (2, 'Presazkoa', 'eu'),
  (2, 'Urgente', 'es');

SET foreign_key_checks = 1;
