INSERT INTO berria.sf_guard_user
SELECT *
 FROM zaharra.sf_guard_user;

INSERT INTO berria.gertakaria (id, laburpena, klasea_id, mota_id, azpimota_id, abisuanork, egoera_id, saila_id, langilea_id, barrutia_id, kalea_id, kale_zbkia, deskribapena, ixte_data, hasiera_aurreikusia, amaiera_aurreikusia, lehentasuna_id, jatorrizkosaila_id, eraikina_id, created_at, updated_at)
SELECT id, laburpena, klasea_id, mota_id, azpimota_id,  concat(abisuanork, ' ', harremanetarako), egoera_id, saila_id, langilea_id, barrutia_id, kalea_id, kale_zbkia, deskribapena, ixte_data, hasiera_adieraz, amaiera_adieraz, lehentasuna_id, jatorrizkosaila_id, eraikina_id, created_at, updated_at
 FROM zaharra.gertakaria;

INSERT INTO berria.iruzkina
SELECT *
 FROM zaharra.iruzkina;

INSERT INTO berria.fitxategia
SELECT *
 FROM zaharra.fitxategia;
