# Sequel Pro dump
# Version 2492
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.5.0-m2)
# Database: pinnect112
# Generation Time: 2012-11-20 06:37:57 +0000
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table pnct_Ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_Ads`;

CREATE TABLE `pnct_Ads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `width` int(10) unsigned NOT NULL,
  `height` int(10) unsigned NOT NULL,
  `enabled` tinyint(3) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_Board
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_Board`;

CREATE TABLE `pnct_Board` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `categoryId` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `access` tinyint(3) unsigned DEFAULT NULL,
  `cover` bigint(20) unsigned DEFAULT NULL,
  `sortOrder` bigint(20) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_Board` WRITE;
/*!40000 ALTER TABLE `pnct_Board` DISABLE KEYS */;
INSERT INTO `pnct_Board` (`id`,`userId`,`categoryId`,`title`,`url`,`description`,`access`,`cover`,`sortOrder`)
VALUES
	(1,1,1,'Products I Love','products_i_love',NULL,0,NULL,1),
	(2,1,1,'Favorite Places &amp; Spaces','favorite_places_-amp-_spaces',NULL,0,NULL,2),
	(3,1,1,'Books Worth Reading','books_worth_reading',NULL,0,NULL,3),
	(4,1,1,'My Style','my_style',NULL,0,NULL,4),
	(5,1,1,'For the Home','for_the_home',NULL,0,NULL,5);

/*!40000 ALTER TABLE `pnct_Board` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_BoardUser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_BoardUser`;

CREATE TABLE `pnct_BoardUser` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `boardId` bigint(20) unsigned DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_CloudStorageBin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_CloudStorageBin`;

CREATE TABLE `pnct_CloudStorageBin` (
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `provider` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_CmsArticle
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_CmsArticle`;

CREATE TABLE `pnct_CmsArticle` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `editorType` tinyint(3) unsigned DEFAULT NULL,
  `order` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_CmsBlock
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_CmsBlock`;

CREATE TABLE `pnct_CmsBlock` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `space` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hide` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `editorType` tinyint(3) unsigned DEFAULT NULL,
  `getParams` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_CmsPage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_CmsPage`;

CREATE TABLE `pnct_CmsPage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `mainMenu` tinyint(3) unsigned DEFAULT NULL,
  `editorType` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_Gift
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_Gift`;

CREATE TABLE `pnct_Gift` (
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `price` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_Gift` WRITE;
/*!40000 ALTER TABLE `pnct_Gift` DISABLE KEYS */;
INSERT INTO `pnct_Gift` (`id`,`price`)
VALUES
	(1,10000);

/*!40000 ALTER TABLE `pnct_Gift` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_Hash
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_Hash`;

CREATE TABLE `pnct_Hash` (
  `hash` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `expire` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_I18N
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_I18N`;

CREATE TABLE `pnct_I18N` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relatedId` bigint(20) unsigned DEFAULT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_I18N` WRITE;
/*!40000 ALTER TABLE `pnct_I18N` DISABLE KEYS */;
INSERT INTO `pnct_I18N` (`id`,`model`,`relatedId`,`language`,`name`,`value`)
VALUES
	(1,'PictureCategory',1,'en_us','name','Architecture'),
	(2,'PictureCategory',2,'en_us','name','Art'),
	(3,'PictureCategory',3,'en_us','name','Cars & Motorcycles'),
	(4,'PictureCategory',4,'en_us','name','Design'),
	(5,'PictureCategory',5,'en_us','name','DIY & Crafts'),
	(6,'PictureCategory',6,'en_us','name','Education'),
	(7,'PictureCategory',7,'en_us','name','Film, Music & Books'),
	(8,'PictureCategory',8,'en_us','name','Fitness'),
	(9,'PictureCategory',9,'en_us','name','Food & Drink'),
	(10,'PictureCategory',10,'en_us','name','Gardening'),
	(11,'PictureCategory',11,'en_us','name','Geek'),
	(12,'PictureCategory',12,'en_us','name','Hair & Beauty'),
	(13,'PictureCategory',13,'en_us','name','History'),
	(14,'PictureCategory',14,'en_us','name','Holidays'),
	(15,'PictureCategory',15,'en_us','name','Home Decor'),
	(16,'PictureCategory',16,'en_us','name','Humor'),
	(17,'PictureCategory',17,'en_us','name','Kids'),
	(18,'PictureCategory',18,'en_us','name','My Life'),
	(19,'PictureCategory',19,'en_us','name','Women\'s Apparel'),
	(20,'PictureCategory',20,'en_us','name','Men\'s Apparel'),
	(21,'PictureCategory',21,'en_us','name','Outdoors'),
	(22,'PictureCategory',22,'en_us','name','People'),
	(23,'PictureCategory',23,'en_us','name','Pets'),
	(24,'PictureCategory',24,'en_us','name','Photography'),
	(25,'PictureCategory',25,'en_us','name','Print & Posters'),
	(26,'PictureCategory',26,'en_us','name','Products'),
	(27,'PictureCategory',27,'en_us','name','Science & Nature'),
	(28,'PictureCategory',28,'en_us','name','Sports'),
	(29,'PictureCategory',29,'en_us','name','Technology'),
	(30,'PictureCategory',30,'en_us','name','Travel & Places'),
	(31,'PictureCategory',31,'en_us','name','Wedding & Events'),
	(32,'PictureCategory',32,'en_us','name','Other');

/*!40000 ALTER TABLE `pnct_I18N` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_Location
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_Location`;

CREATE TABLE `pnct_Location` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cityASCII` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_MailQueue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_MailQueue`;

CREATE TABLE `pnct_MailQueue` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `template` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `params` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_NetworkEvent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_NetworkEvent`;

CREATE TABLE `pnct_NetworkEvent` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `eventModule` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eventType` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` bigint(20) unsigned DEFAULT NULL,
  `params` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_NetworkEvent` WRITE;
/*!40000 ALTER TABLE `pnct_NetworkEvent` DISABLE KEYS */;
INSERT INTO `pnct_NetworkEvent` (`id`,`userId`,`eventModule`,`eventType`,`created`,`params`)
VALUES
	(1,1,'picture','post',1353385002,'a:1:{s:4:\"post\";s:1:\"1\";}'),
	(2,1,'picture','post',1353385328,'a:1:{s:4:\"post\";s:1:\"2\";}');

/*!40000 ALTER TABLE `pnct_NetworkEvent` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_NetworkFollowBoard
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_NetworkFollowBoard`;

CREATE TABLE `pnct_NetworkFollowBoard` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `boardId` bigint(20) unsigned DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_NetworkFollowUser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_NetworkFollowUser`;

CREATE TABLE `pnct_NetworkFollowUser` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `followUserId` bigint(20) unsigned DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_NetworkInvite
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_NetworkInvite`;

CREATE TABLE `pnct_NetworkInvite` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hash` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_NetworkRequest
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_NetworkRequest`;

CREATE TABLE `pnct_NetworkRequest` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_Picture
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_Picture`;

CREATE TABLE `pnct_Picture` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bin` bigint(20) unsigned DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `created` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_Picture` WRITE;
/*!40000 ALTER TABLE `pnct_Picture` DISABLE KEYS */;
INSERT INTO `pnct_Picture` (`id`,`bin`,`userId`,`height`,`created`)
VALUES
	(1,1,1,209,1353385002),
	(2,2,1,209,1353385327);

/*!40000 ALTER TABLE `pnct_Picture` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_PictureCategory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_PictureCategory`;

CREATE TABLE `pnct_PictureCategory` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` bigint(20) unsigned DEFAULT NULL,
  `enabled` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_PictureCategory` WRITE;
/*!40000 ALTER TABLE `pnct_PictureCategory` DISABLE KEYS */;
INSERT INTO `pnct_PictureCategory` (`id`,`url`,`image`,`enabled`)
VALUES
	(1,'architecture',NULL,1),
	(2,'art',NULL,1),
	(3,'cars-motorcycles',NULL,1),
	(4,'design',NULL,1),
	(5,'diy-crafts',NULL,1),
	(6,'education',NULL,1),
	(7,'film-music-books',NULL,1),
	(8,'fitness',NULL,1),
	(9,'food-drink',NULL,1),
	(10,'gardening',NULL,1),
	(11,'geek',NULL,1),
	(12,'hair-beauty',NULL,1),
	(13,'history',NULL,1),
	(14,'holidays',NULL,1),
	(15,'home-decor',NULL,1),
	(16,'humor',NULL,1),
	(17,'kids',NULL,1),
	(18,'my-life',NULL,1),
	(19,'women-s-apparel',NULL,1),
	(20,'men-s-apparel',NULL,1),
	(21,'outdoors',NULL,1),
	(22,'people',NULL,1),
	(23,'pets',NULL,1),
	(24,'photography',NULL,1),
	(25,'print-posters',NULL,1),
	(26,'products',NULL,1),
	(27,'science-nature',NULL,1),
	(28,'sports',NULL,1),
	(29,'technology',NULL,1),
	(30,'travel-places',NULL,1),
	(31,'wedding-events',NULL,1),
	(32,'other',NULL,1);

/*!40000 ALTER TABLE `pnct_PictureCategory` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_PictureComment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_PictureComment`;

CREATE TABLE `pnct_PictureComment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `postId` bigint(20) unsigned DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci,
  `created` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `postId` (`postId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_PictureCommentReport
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_PictureCommentReport`;

CREATE TABLE `pnct_PictureCommentReport` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `commentId` bigint(20) unsigned DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `reportType` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_PictureLike
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_PictureLike`;

CREATE TABLE `pnct_PictureLike` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `postId` bigint(20) unsigned DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `created` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_PicturePost
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_PicturePost`;

CREATE TABLE `pnct_PicturePost` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pictureId` bigint(20) unsigned DEFAULT NULL,
  `parentId` bigint(20) unsigned DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `boardId` bigint(20) unsigned DEFAULT NULL,
  `source` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sourceDomain` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `channel` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `likes` bigint(20) unsigned DEFAULT NULL,
  `reposts` bigint(20) unsigned DEFAULT NULL,
  `comments` bigint(20) unsigned DEFAULT NULL,
  `created` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sourceDomain` (`sourceDomain`),
  KEY `boardId` (`boardId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_PicturePost` WRITE;
/*!40000 ALTER TABLE `pnct_PicturePost` DISABLE KEYS */;
INSERT INTO `pnct_PicturePost` (`id`,`pictureId`,`parentId`,`userId`,`boardId`,`source`,`sourceDomain`,`channel`,`message`,`likes`,`reposts`,`comments`,`created`)
VALUES
	(1,1,NULL,1,3,NULL,NULL,'upload','test price $10000',NULL,NULL,NULL,1353385002),
	(2,2,NULL,1,3,NULL,NULL,'upload','test price 2 Rp 100000',NULL,NULL,NULL,1353385327);

/*!40000 ALTER TABLE `pnct_PicturePost` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_PictureReport
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_PictureReport`;

CREATE TABLE `pnct_PictureReport` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `postId` bigint(20) unsigned DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `reportType` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_SocialUser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_SocialUser`;

CREATE TABLE `pnct_SocialUser` (
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `provider` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `data` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_StorageBin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_StorageBin`;

CREATE TABLE `pnct_StorageBin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_StorageBin` WRITE;
/*!40000 ALTER TABLE `pnct_StorageBin` DISABLE KEYS */;
INSERT INTO `pnct_StorageBin` (`id`,`owner`,`status`,`created`)
VALUES
	(1,'1',1,1353383245),
	(2,'1',1,1353383293);

/*!40000 ALTER TABLE `pnct_StorageBin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_StorageFile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_StorageFile`;

CREATE TABLE `pnct_StorageFile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `binId` bigint(20) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `extension` char(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created` bigint(20) unsigned NOT NULL DEFAULT '0',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `binId` (`binId`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_StorageFile` WRITE;
/*!40000 ALTER TABLE `pnct_StorageFile` DISABLE KEYS */;
INSERT INTO `pnct_StorageFile` (`id`,`binId`,`name`,`hash`,`extension`,`created`,`size`)
VALUES
	(1,1,'original','3b490fa6b11b376d4859df31c8fe8ff5','png',1353383245,19882),
	(2,2,'original','8fbcc90b79d10057ca1df9cc76eef15d','png',1353383293,19882),
	(6,1,'large','530e2877a18d19e6f94a0e535c54b339','png',1353385002,19882),
	(7,1,'medium','78f474ca5354e5b2e268953f5b7cae66','png',1353385002,43923),
	(8,1,'small','b3a06ae4dc1f217ff893db9920faf5cc','png',1353385002,10760),
	(9,2,'large','2de036684435ca44a40cf2fbcf339ae4','png',1353385327,19882),
	(10,2,'medium','f1e4a6265cf072dee7b2bb558ac569c1','png',1353385327,43923),
	(11,2,'small','54695123010f04672459854fa46ba776','png',1353385327,10760);

/*!40000 ALTER TABLE `pnct_StorageFile` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_ThemeColorScheme
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_ThemeColorScheme`;

CREATE TABLE `pnct_ThemeColorScheme` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `themeId` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `current` tinyint(3) unsigned NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_ThemeImage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_ThemeImage`;

CREATE TABLE `pnct_ThemeImage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `themeId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` blob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themeId` (`themeId`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_User
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_User`;

CREATE TABLE `pnct_User` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `changePassword` tinyint(3) unsigned DEFAULT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `created` bigint(20) unsigned DEFAULT NULL,
  `firstName` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` bigint(20) unsigned DEFAULT NULL,
  `timeZone` double DEFAULT '0',
  `ip` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pnct_User` WRITE;
/*!40000 ALTER TABLE `pnct_User` DISABLE KEYS */;
INSERT INTO `pnct_User` (`id`,`email`,`password`,`salt`,`changePassword`,`role`,`created`,`firstName`,`lastName`,`username`,`avatar`,`timeZone`,`ip`,`language`,`about`)
VALUES
	(1,'test@admin.com','6e2722a5242fe5090001c7fcccc62145','T^6',NULL,'administrator',1353382888,'test','admin','administrator',NULL,0,',::1,',NULL,NULL);

/*!40000 ALTER TABLE `pnct_User` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pnct_UserNotify
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_UserNotify`;

CREATE TABLE `pnct_UserNotify` (
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment` tinyint(3) unsigned DEFAULT '1',
  `like` tinyint(3) unsigned DEFAULT '1',
  `repost` tinyint(3) unsigned DEFAULT '1',
  `follow` tinyint(3) unsigned DEFAULT '1',
  `unfollow` tinyint(3) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table pnct_Video
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pnct_Video`;

CREATE TABLE `pnct_Video` (
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `provider` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
