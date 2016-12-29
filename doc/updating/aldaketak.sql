/* v1.2 */
ALTER TABLE gertakaria
 CHANGE COLUMN hasiera_adieraz DATE NULL DEFAULT NULL,
 CHANGE COLUMN amaiera_adieraz DATE NULL DEFAULT NULL;



/* v1.4 */
UPDATE zaharra.gertakaria SET
  abisuanork = concat(abisuanork, ' ', harremanetarako);

ALTER TABLE zaharra.gertakaria
 DROP COLUMN harremanetarako,
 CHANGE COLUMN hasiera_adieraz hasiera_aurreikusia DATE NULL DEFAULT NULL,
 CHANGE COLUMN amaiera_adieraz amaiera_aurreikusia DATE NULL DEFAULT NULL;

CREATE TABLE saila_mota
(
	id BIGINT(20) NOT NULL AUTO_INCREMENT,
	saila_id BIGINT(20) NOT NULL,
	mota_id BIGINT(20) NOT NULL,
	PRIMARY KEY (id),
	INDEX saila_id_idx (saila_id),
	INDEX mota_id_idx (mota_id),
	CONSTRAINT saila_mota_mota_id_mota_id FOREIGN KEY (mota_id) REFERENCES mota (id) ON DELETE CASCADE,
	CONSTRAINT saila_mota_saila_id_sf_guard_group_id FOREIGN KEY (saila_id) REFERENCES sf_guard_group (id) ON DELETE CASCADE
);

ALTER TABLE gertakaria
 CHANGE COLUMN azpimota_id azpimota_id BIGINT NULL DEFAULT NULL;



/* v1.14 */
ALTER TABLE gertakaria
 CHANGE COLUMN lehentasuna_id lehentasuna_id BIGINT NULL DEFAULT NULL,
 CHANGE COLUMN mota_id mota_id BIGINT NULL DEFAULT NULL;

CREATE TABLE auzoa
(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	barrutia_id bigint(20) NULL DEFAULT NULL,
	izena varchar(255) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY izena (izena),
	CONSTRAINT auzoa_barrutia_id_barrutia_id FOREIGN KEY(barrutia_id) REFERENCES barrutia(id) ON DELETE SET NULL
);

ALTER TABLE gertakaria
 CHANGE COLUMN barrutia_id barrutia_id BIGINT NULL DEFAULT NULL,
 ADD auzoa_id BIGINT NULL DEFAULT NULL AFTER barrutia_id,
 ADD CONSTRAINT gertakaria_auzoa_id_auzoa_id FOREIGN KEY(auzoa_id) REFERENCES auzoa(id) ON DELETE SET NULL;

ALTER TABLE eraikina
 CHANGE COLUMN barrutia_id barrutia_id BIGINT NULL DEFAULT NULL,
 ADD auzoa_id BIGINT NULL DEFAULT NULL AFTER barrutia_id,
 ADD CONSTRAINT eraikina_auzoa_id_auzoa_id FOREIGN KEY(auzoa_id) REFERENCES auzoa(id) ON DELETE SET NULL;

ALTER TABLE kalea
 CHANGE COLUMN barrutia_id barrutia_id BIGINT NULL DEFAULT NULL,
 ADD auzoa_id BIGINT NULL DEFAULT NULL AFTER barrutia_id,
 ADD CONSTRAINT kalea_auzoa_id_auzoa_id FOREIGN KEY(auzoa_id) REFERENCES auzoa(id) ON DELETE SET NULL;



/* v1.16 */
CREATE TABLE IF NOT EXISTS kontaktua
(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	izena varchar(255) DEFAULT NULL,
	posta varchar(100) DEFAULT NULL,
	telefonoa varchar(30) DEFAULT NULL,
	ohartarazi tinyint(1) DEFAULT NULL,
	hizkuntza varchar(2) DEFAULT NULL,
	PRIMARY KEY (id)
);

ALTER TABLE gertakaria
 ADD herritarrena TINYINT DEFAULT NULL,
 ADD kontaktua_id BIGINT DEFAULT NULL,
 ADD CONSTRAINT gertakaria_kontaktua_id_kontaktua_id FOREIGN KEY (kontaktua_id) REFERENCES kontaktua(id);

ALTER TABLE geo
 ADD COLUMN zehaztasuna DOUBLE NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS erlazio_mota
(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS erlazio_mota_translation
(
	id bigint(20) NOT NULL DEFAULT '0',
	izena varchar(255) NOT NULL,
	lang char(2) NOT NULL DEFAULT '',
	PRIMARY KEY (id, lang),
	CONSTRAINT erlazio_mota_translation_id_erlazio_mota_id FOREIGN KEY (id) REFERENCES erlazio_mota (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS erlazioak
(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	hasiera_id bigint(20) NOT NULL,
	amaiera_id bigint(20) NOT NULL,
	erlazio_mota_id bigint(20) DEFAULT NULL,
	PRIMARY KEY (id),
	KEY erlazio_mota_id_idx (erlazio_mota_id),
	KEY amaiera_id_idx (amaiera_id),
	KEY hasiera_id_idx (hasiera_id),
	CONSTRAINT erlazioak_amaiera_id_gertakaria_id FOREIGN KEY (amaiera_id) REFERENCES gertakaria (id) ON DELETE CASCADE,
	CONSTRAINT erlazioak_erlazio_mota_id_erlazio_mota_id FOREIGN KEY (erlazio_mota_id) REFERENCES erlazio_mota (id) ON DELETE SET NULL,
	CONSTRAINT erlazioak_hasiera_id_gertakaria_id FOREIGN KEY (hasiera_id) REFERENCES gertakaria (id) ON DELETE CASCADE
);



/* v1.16.2 */
UPDATE gertakaria SET ixte_data = NULL WHERE year(ixte_data) = 0;



/* v1.18 */
ALTER TABLE `auzoa` DROP FOREIGN KEY `auzoa_barrutia_id_barrutia_id`;
ALTER TABLE `auzoa` ADD CONSTRAINT `auzoa_barrutia_id_barrutia_id` FOREIGN KEY (`barrutia_id`) REFERENCES `barrutia`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `azpimota` DROP FOREIGN KEY `azpimota_mota_id_mota_id`;
ALTER TABLE `azpimota` ADD CONSTRAINT `azpimota_mota_id_mota_id` FOREIGN KEY (`mota_id`) REFERENCES `mota`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `eraikina` DROP FOREIGN KEY `eraikina_auzoa_id_auzoa_id`;
ALTER TABLE `eraikina` ADD CONSTRAINT `eraikina_auzoa_id_auzoa_id` FOREIGN KEY (`auzoa_id`) REFERENCES `auzoa`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `eraikina` DROP FOREIGN KEY `eraikina_barrutia_id_barrutia_id`;
ALTER TABLE `eraikina` ADD CONSTRAINT `eraikina_barrutia_id_barrutia_id` FOREIGN KEY (`barrutia_id`) REFERENCES `barrutia`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `erlazioak` DROP FOREIGN KEY `erlazioak_amaiera_id_gertakaria_id`;
ALTER TABLE `erlazioak` ADD CONSTRAINT `erlazioak_amaiera_id_gertakaria_id` FOREIGN KEY (`amaiera_id`) REFERENCES `gertakaria`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `erlazioak` DROP FOREIGN KEY `erlazioak_hasiera_id_gertakaria_id`;
ALTER TABLE `erlazioak` ADD CONSTRAINT `erlazioak_hasiera_id_gertakaria_id` FOREIGN KEY (`hasiera_id`) REFERENCES `gertakaria`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `erlazioak` DROP FOREIGN KEY `erlazioak_erlazio_mota_id_erlazio_mota_id`;
ALTER TABLE `erlazioak` ADD CONSTRAINT `erlazioak_erlazio_mota_id_erlazio_mota_id` FOREIGN KEY (`erlazio_mota_id`) REFERENCES `erlazio_mota`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `fitxategia` DROP FOREIGN KEY `fitxategia_gertakaria_id_gertakaria_id`;
ALTER TABLE `fitxategia` ADD CONSTRAINT `fitxategia_gertakaria_id_gertakaria_id` FOREIGN KEY (`gertakaria_id`) REFERENCES `gertakaria`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `fitxategia` DROP FOREIGN KEY `fitxategia_langilea_id_sf_guard_user_id`;
ALTER TABLE `fitxategia` ADD CONSTRAINT `fitxategia_langilea_id_sf_guard_user_id` FOREIGN KEY (`langilea_id`) REFERENCES `sf_guard_user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `geo` DROP FOREIGN KEY `geo_geometria_id_geometria_id`;
ALTER TABLE `geo` ADD CONSTRAINT `geo_geometria_id_geometria_id` FOREIGN KEY (`geometria_id`) REFERENCES `geometria`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `geo` DROP FOREIGN KEY `geo_gertakaria_id_gertakaria_id`;
ALTER TABLE `geo` ADD CONSTRAINT `geo_gertakaria_id_gertakaria_id` FOREIGN KEY (`gertakaria_id`) REFERENCES `gertakaria`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_auzoa_id_auzoa_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_auzoa_id_auzoa_id` FOREIGN KEY (`auzoa_id`) REFERENCES `auzoa`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_azpimota_id_azpimota_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_azpimota_id_azpimota_id` FOREIGN KEY (`azpimota_id`) REFERENCES `azpimota`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_barrutia_id_barrutia_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_barrutia_id_barrutia_id` FOREIGN KEY (`barrutia_id`) REFERENCES `barrutia`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_egoera_id_egoera_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_egoera_id_egoera_id` FOREIGN KEY (`egoera_id`) REFERENCES `egoera`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_eraikina_id_eraikina_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_eraikina_id_eraikina_id` FOREIGN KEY (`eraikina_id`) REFERENCES `eraikina`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_jatorrizkosaila_id_jatorrizko_saila_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_jatorrizkosaila_id_jatorrizko_saila_id` FOREIGN KEY (`jatorrizkosaila_id`) REFERENCES `jatorrizko_saila`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_kalea_id_kalea_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_kalea_id_kalea_id` FOREIGN KEY (`kalea_id`) REFERENCES `kalea`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_klasea_id_klasea_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_klasea_id_klasea_id` FOREIGN KEY (`klasea_id`) REFERENCES `klasea`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_langilea_id_sf_guard_user_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_langilea_id_sf_guard_user_id` FOREIGN KEY (`langilea_id`) REFERENCES `sf_guard_user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_lehentasuna_id_lehentasuna_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_lehentasuna_id_lehentasuna_id` FOREIGN KEY (`lehentasuna_id`) REFERENCES `lehentasuna`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_mota_id_mota_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_mota_id_mota_id` FOREIGN KEY (`mota_id`) REFERENCES `mota`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_saila_id_sf_guard_group_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_saila_id_sf_guard_group_id` FOREIGN KEY (`saila_id`) REFERENCES `sf_guard_group`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `gertakaria` DROP FOREIGN KEY `gertakaria_kontaktua_id_kontaktua_id`;
ALTER TABLE `gertakaria` ADD CONSTRAINT `gertakaria_kontaktua_id_kontaktua_id` FOREIGN KEY (`kontaktua_id`) REFERENCES `kontaktua`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `iruzkina` DROP FOREIGN KEY `iruzkina_ekintza_id_ekintza_id`;
ALTER TABLE `iruzkina` ADD CONSTRAINT `iruzkina_ekintza_id_ekintza_id` FOREIGN KEY (`ekintza_id`) REFERENCES `ekintza`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `iruzkina` DROP FOREIGN KEY `iruzkina_gertakaria_id_gertakaria_id`;
ALTER TABLE `iruzkina` ADD CONSTRAINT `iruzkina_gertakaria_id_gertakaria_id` FOREIGN KEY (`gertakaria_id`) REFERENCES `gertakaria`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `iruzkina` DROP FOREIGN KEY `iruzkina_langilea_id_sf_guard_user_id`;
ALTER TABLE `iruzkina` ADD CONSTRAINT `iruzkina_langilea_id_sf_guard_user_id` FOREIGN KEY (`langilea_id`) REFERENCES `sf_guard_user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `kalea` DROP FOREIGN KEY `kalea_auzoa_id_auzoa_id`;
ALTER TABLE `kalea` ADD CONSTRAINT `kalea_auzoa_id_auzoa_id` FOREIGN KEY (`auzoa_id`) REFERENCES `auzoa`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `kalea` DROP FOREIGN KEY `kalea_barrutia_id_barrutia_id`;
ALTER TABLE `kalea` ADD CONSTRAINT `kalea_barrutia_id_barrutia_id` FOREIGN KEY (`barrutia_id`) REFERENCES `barrutia`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `planifikazioa` DROP FOREIGN KEY `planifikazioa_gertakaria_id_gertakaria_id`;
ALTER TABLE `planifikazioa` ADD CONSTRAINT `planifikazioa_gertakaria_id_gertakaria_id` FOREIGN KEY (`gertakaria_id`) REFERENCES `gertakaria`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `planifikazioa` DROP FOREIGN KEY `planifikazioa_langilea_id_sf_guard_user_id`;
ALTER TABLE `planifikazioa` ADD CONSTRAINT `planifikazioa_langilea_id_sf_guard_user_id` FOREIGN KEY (`langilea_id`) REFERENCES `sf_guard_user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `saila_mota` DROP FOREIGN KEY `saila_mota_mota_id_mota_id`;
ALTER TABLE `saila_mota` ADD CONSTRAINT `saila_mota_mota_id_mota_id` FOREIGN KEY (`mota_id`) REFERENCES `mota`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `saila_mota` DROP FOREIGN KEY `saila_mota_saila_id_sf_guard_group_id`;
ALTER TABLE `saila_mota` ADD CONSTRAINT `saila_mota_saila_id_sf_guard_group_id` FOREIGN KEY (`saila_id`) REFERENCES `sf_guard_group`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


/* v2.08 */
ALTER TABLE gertakaria ADD
 espedientea VARCHAR(12) NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS kontaktua_ohartaraztea
(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	ordena bigint(20) DEFAULT NULL,
	PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS kontaktua_ohartaraztea_translation
(
	id bigint(20) NOT NULL DEFAULT '0',
	modua varchar(100) NOT NULL,
	lang char(2) NOT NULL DEFAULT '',
	PRIMARY KEY (id,lang),
	CONSTRAINT kontaktua_ohartaraztea_translation_id_kontaktua_ohartaraztea_id FOREIGN KEY (id) REFERENCES kontaktua_ohartaraztea (id) ON DELETE CASCADE ON UPDATE CASCADE
);
ALTER TABLE kontaktua
 ADD abizenak VARCHAR(255) NULL,
 ADD nan VARCHAR(9) NULL,
 CHANGE COLUMN ohartarazi ohartarazi BIGINT NULL DEFAULT NULL,
 ADD CONSTRAINT kontaktua_ohartarazi_kontaktua_ohartaraztea_id FOREIGN KEY (ohartarazi) REFERENCES kontaktua_ohartaraztea (id);
