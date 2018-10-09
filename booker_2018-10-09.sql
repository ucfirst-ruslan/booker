# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 127.0.0.1 (MySQL 5.6.35)
# Схема: booker
# Время создания: 2018-10-09 00:40:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы bk_events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bk_events`;

CREATE TABLE `bk_events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_rec` int(11) DEFAULT NULL,
  `notes` varchar(256) NOT NULL DEFAULT '',
  `id_user` int(11) NOT NULL,
  `id_from_user` int(11) NOT NULL,
  `id_room` int(11) NOT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `bk_events` WRITE;
/*!40000 ALTER TABLE `bk_events` DISABLE KEYS */;

INSERT INTO `bk_events` (`id`, `id_rec`, `notes`, `id_user`, `id_from_user`, `id_room`, `start_time`, `end_time`, `create_time`)
VALUES
	(1,NULL,'Test',1,1,2,1537865928,1540457993,'2018-09-25 12:00:29'),
	(2,NULL,'Test 2',1,2,2,1540457993,1540461593,'2018-09-25 12:01:06'),
	(3,NULL,'Event3',1,1,3,1538118808,1538128708,'2018-09-28 11:33:12'),
	(4,NULL,'Event4',2,1,1,1538952777,1538954577,'2018-09-28 11:33:22');

/*!40000 ALTER TABLE `bk_events` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы bk_rooms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bk_rooms`;

CREATE TABLE `bk_rooms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `bk_rooms` WRITE;
/*!40000 ALTER TABLE `bk_rooms` DISABLE KEYS */;

INSERT INTO `bk_rooms` (`id`, `name`)
VALUES
	(1,'Room 1'),
	(2,'Room 2'),
	(3,'Room 3');

/*!40000 ALTER TABLE `bk_rooms` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы bk_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bk_tokens`;

CREATE TABLE `bk_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `bk_tokens` WRITE;
/*!40000 ALTER TABLE `bk_tokens` DISABLE KEYS */;

INSERT INTO `bk_tokens` (`id`, `id_user`, `token`, `expires`)
VALUES
	(1,2,'$1$QZXApEeM$qLS2GdyEEplxAZCf3K0it1',1538413751),
	(2,1,'$1$QZXApEeM$qLS2GdyEEplxAZCf377777',1538390300),
	(3,2,'$1$QZXApEeM$qLS2GdyEEplxAZCf3K0it1',1538390198),
	(5,2,'$1$QZXApEeM$qLS2GdyEEplxAZCf3K0it1',1538853901),
	(6,1,'$1$QZXApEeM$qLS2GdyEEplxAZCf377777',1548390300),
	(7,2,'$1$QZXApEeM$qLS2GdyEEplxAZCf3K0it1',1538858809),
	(8,1,'$1$QZXApEeM$qLS2GdyEEplxAZCf377777',1538390310);

/*!40000 ALTER TABLE `bk_tokens` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы bk_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bk_users`;

CREATE TABLE `bk_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `role` varchar(11) NOT NULL DEFAULT 'user',
  `active` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `bk_users` WRITE;
/*!40000 ALTER TABLE `bk_users` DISABLE KEYS */;

INSERT INTO `bk_users` (`id`, `username`, `password`, `email`, `role`, `active`)
VALUES
	(1,'Admin','1','1@1.com','admin',1),
	(2,'user','2','2@2.com','user',1);

/*!40000 ALTER TABLE `bk_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
