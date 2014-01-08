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
