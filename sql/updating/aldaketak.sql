UPDATE zaharra.gertakaria SET
  abisuanork = concat(abisuanork, ' ', harremanetarako);

ALTER TABLE zaharra.gertakaria
 DROP COLUMN harremanetarako,
 CHANGE COLUMN hasiera_adieraz hasiera_aurreikusia DATE NULL DEFAULT NULL,
 CHANGE COLUMN amaiera_adieraz amaiera_aurreikusia DATE NULL DEFAULT NULL;
