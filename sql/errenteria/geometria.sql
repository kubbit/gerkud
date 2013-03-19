SET foreign_key_checks = 0;

TRUNCATE TABLE geometria;
INSERT INTO `geometria` (`id`, `mota`) VALUES
  (1, 'Puntua'),
  (2, 'Lerroa');

SET foreign_key_checks = 1;
