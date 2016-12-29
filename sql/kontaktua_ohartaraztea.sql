SET foreign_key_checks = 0;

SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

TRUNCATE TABLE kontaktua_ohartaraztea;
INSERT INTO `kontaktua_ohartaraztea` (`id`, `ordena`) VALUES
  (0, 0),
  (1, NULL),
  (2, NULL),
  (3, NULL);

TRUNCATE TABLE kontaktua_ohartaraztea_translation;
INSERT INTO `kontaktua_ohartaraztea_translation` (`id`, `modua`, `lang`) VALUES
  (0, 'No', 'es'),
  (0, 'Ez', 'eu'),
  (1, 'Correo electrónico', 'es'),
  (1, 'E-posta bidez', 'eu'),
  (2, 'Por teléfono', 'es'),
  (2, 'Telefonoz', 'eu'),
  (3, 'Por escrito', 'es'),
  (3, 'Idatziz', 'eu');

SET foreign_key_checks = 1;
