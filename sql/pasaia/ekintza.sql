SET foreign_key_checks = 0;

TRUNCATE TABLE ekintza;
INSERT INTO `ekintza` (`id`) VALUES
  (1),
  (2),
  (3),
  (4),
  (5),
  (6);

TRUNCATE TABLE ekintza_translation;
INSERT INTO `ekintza_translation` (`id`, `mota`, `lang`) VALUES
  (1, 'Comentario', 'es'),
  (1, 'Iruzkina', 'eu'),
  (2, 'Asignación', 'es'),
  (2, 'Esleipena', 'eu'),
  (3, 'Reapertura', 'es'),
  (3, 'Berrirekiera', 'eu'),
  (4, 'Fichero', 'es'),
  (4, 'Fitxategia', 'eu'),
  (5, 'Cambio de situación', 'es'),
  (5, 'Egoera aldatzea', 'eu'),
  (6, 'Cerrada', 'es'),
  (6, 'Ixtea', 'eu');

SET foreign_key_checks = 1;
