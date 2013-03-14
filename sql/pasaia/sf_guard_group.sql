SET foreign_key_checks = 0;

TRUNCATE TABLE sf_guard_group;
INSERT INTO `sf_guard_group` (`id`, `description`, `created_at`, `updated_at`) VALUES
  (1, NULL, NULL, NULL),
  (2, NULL, NULL, NULL),
  (3, NULL, NULL, NULL),
  (4, NULL, NULL, NULL),
  (5, NULL, NULL, NULL),
  (6, NULL, NULL, NULL),
  (7, NULL, NULL, NULL),
  (8, NULL, NULL, NULL),
  (9, NULL, NULL, NULL),
  (10, NULL, NULL, NULL),
  (11, NULL, NULL, NULL),
  (12, NULL, NULL, NULL),
  (13, NULL, NULL, NULL),
  (14, NULL, NULL, NULL),
  (15, NULL, NULL, NULL),
  (16, NULL, NULL, NULL);

TRUNCATE TABLE sf_guard_group_translation;
INSERT INTO `sf_guard_group_translation` (`id`, `name`, `lang`) VALUES
  (1, 'Electricista', 'es'),
  (1, 'Elektrizitatea', 'eu'),
  (2, 'Pintor', 'es'),
  (2, 'Margolaria', 'eu'),
  (3, 'Carpintero', 'es'),
  (3, 'Arotza-erramintaria', 'eu'),
  (4, 'Responsable Aguas', 'es'),
  (4, 'Ur Arduraduna', 'eu'),
  (5, 'Servicios - FCC', 'es'),
  (5, 'FCC-Zerbitzu', 'eu'),
  (6, 'Inspector', 'es'),
  (6, 'Inspektorea', 'eu'),
  (7, 'Técnico de mantenimiento', 'es'),
  (7, 'Mantentze lanetako teknikaria', 'eu'),
  (8, 'Jefe de departamento', 'es'),
  (8, 'Sail-burua', 'eu'),
  (9, 'Responsable de Servicios', 'es'),
  (9, 'Zerbitzuetako arduraduna', 'eu'),
  (10, 'Jardinero', 'es'),
  (10, 'Lorezaina', 'eu'),
  (11, 'Responsable de Salud', 'es'),
  (11, 'Osasun arduraduna', 'eu'),
  (12, 'Albañil', 'es'),
  (12, 'Igeltseroa', 'eu'),
  (13, 'Concejal', 'es'),
  (13, 'Zinegotzia', 'eu'),
  (14, 'Oiarso', 'es'),
  (14, 'Oiarso', 'eu'),
  (15, 'Gremios Varios', 'es'),
  (15, 'Gremio anitz', 'eu'),
  (16, 'Trabajos de mantenimiento de la U.E.', 'es'),
  (16, 'U.E. mantentze lanetako langileak', 'eu');

SET foreign_key_checks = 1;
