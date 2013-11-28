SET foreign_key_checks = 0;

TRUNCATE TABLE saila_mota;
INSERT INTO `saila_mota` (`id`, `saila_id`, `mota_id`) VALUES
  (1, 2, 5),
  (2, 3, 5),
  (3, 4, 5),
  (4, 5, 5),
  (5, 6, 5),
  (6, 7, 5),
  (7, 8, 5),
  (8, 9, 5),
  (9, 10, 5),
  (10, 11, 5),
  (11, 12, 5),
  (12, 13, 5),
  (13, 14, 5),
  (14, 1, 7),
  (15, 15, 9),
  (16, 16, 5),
  (17, 17, 5),
  (18, 18, 5);

SET foreign_key_checks = 1;