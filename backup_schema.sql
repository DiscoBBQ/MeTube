# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: mmlab.cs.clemson.edu (MySQL 5.5.29-0ubuntu0.12.04.1)
# Database: u5
# Generation Time: 2014-04-22 13:04:57 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `user_id` int(11) unsigned DEFAULT NULL,
  `media_id` int(11) unsigned DEFAULT NULL,
  `comment` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `comments_user_fk` (`user_id`),
  KEY `comments_media_fk` (`media_id`),
  CONSTRAINT `comments_media_fk` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table interactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `interactions`;

CREATE TABLE `interactions` (
  `user_id` int(11) unsigned DEFAULT NULL,
  `media_id` int(11) unsigned DEFAULT NULL,
  `category` varchar(32) NOT NULL DEFAULT '',
  `count` int(11) DEFAULT '1',
  UNIQUE KEY `interaction_set` (`user_id`,`media_id`,`category`),
  KEY `interactions_media_fk` (`media_id`),
  CONSTRAINT `interactions_media_fk` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `interactions_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table keywords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keywords`;

CREATE TABLE `keywords` (
  `mediaid` int(11) unsigned NOT NULL,
  `keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`mediaid`,`keyword`),
  CONSTRAINT `keywords_media_fk` FOREIGN KEY (`mediaid`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table media
# ------------------------------------------------------------

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `extension` varchar(32) DEFAULT NULL,
  `authorid` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(127) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_user_fk` (`authorid`),
  CONSTRAINT `media_user_fk` FOREIGN KEY (`authorid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) unsigned DEFAULT NULL,
  `from_user_id` int(11) unsigned DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_message_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_from_user_fk` (`from_user_id`),
  KEY `messages_parent_message_fk` (`parent_message_id`),
  KEY `messages_to_user_fk` (`to_user_id`),
  CONSTRAINT `messages_to_user_fk` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `messages_from_user_fk` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `messages_parent_message_fk` FOREIGN KEY (`parent_message_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table playlist
# ------------------------------------------------------------

DROP TABLE IF EXISTS `playlist`;

CREATE TABLE `playlist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `playlist_user_fk` (`user_id`),
  CONSTRAINT `playlist_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table playlist_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `playlist_item`;

CREATE TABLE `playlist_item` (
  `item_order` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` int(11) unsigned NOT NULL DEFAULT '0',
  `playlist_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_order`,`media_id`,`playlist_id`),
  KEY `playlist_item_media_fk` (`media_id`),
  KEY `playlist_item_playlist_fk` (`playlist_id`),
  CONSTRAINT `playlist_item_playlist_fk` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `playlist_item_media_fk` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table subscriptions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscriptions`;

CREATE TABLE `subscriptions` (
  `subscribing_user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `subscription_user_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscribing_user_id`,`subscription_user_id`),
  KEY `subscriptions_subscription_user_fk` (`subscription_user_id`),
  CONSTRAINT `subscriptions_subscription_user_fk` FOREIGN KEY (`subscription_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subscriptions_subscribing_user_fk` FOREIGN KEY (`subscribing_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `channel_name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`channel_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
