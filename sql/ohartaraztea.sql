SET foreign_key_checks = 0;

TRUNCATE TABLE ohartaraztea;
INSERT INTO `ohartaraztea` (`id`) VALUES
  (1),
  (2),
  (3);

TRUNCATE TABLE ohartaraztea_translation;
INSERT INTO `ohartaraztea_translation` (`id`, `mota`, `lang`) VALUES
  (1, 'Nunca', 'es'),
  (1, 'Inoiz ez', 'eu'),
  (2, 'Sólo con cambios de situación', 'es'),
  (2, 'Egoera aldaketa dagoenean soilik', 'eu'),
  (3, 'Al producirse cualquier cambio', 'es'),
  (3, 'Edozein aldaketa dagoenean', 'eu');

SET foreign_key_checks = 1;
