SET foreign_key_checks = 0;

TRUNCATE TABLE barrutia;
INSERT INTO `barrutia` (`id`, `izena`) VALUES
  (3, 'Antxo'),
  (1, 'Donibane'),
  (5, 'Kaia'),
  (2, 'San Pedro'),
  (4, 'Trintxerpe');

SET foreign_key_checks = 1;
