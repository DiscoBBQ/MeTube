-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2014 at 09:17 PM
-- Server version: 5.6.16
-- PHP Version: 5.3.10-1ubuntu3.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `u5`
--
CREATE DATABASE IF NOT EXISTS `u5` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `u5`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `user_id` int(11) unsigned DEFAULT NULL,
  `media_id` int(11) unsigned DEFAULT NULL,
  `comment` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `comments_user_fk` (`user_id`),
  KEY `comments_media_fk` (`media_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- RELATIONS FOR TABLE `comments`:
--   `media_id`
--       `media` -> `id`
--   `user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `interactions`
--

DROP TABLE IF EXISTS `interactions`;
CREATE TABLE IF NOT EXISTS `interactions` (
  `user_id` int(11) unsigned DEFAULT NULL,
  `media_id` int(11) unsigned DEFAULT NULL,
  `category` varchar(32) NOT NULL DEFAULT '',
  `count` int(11) DEFAULT '1',
  UNIQUE KEY `interaction_set` (`user_id`,`media_id`,`category`),
  KEY `interactions_media_fk` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `interactions`:
--   `media_id`
--       `media` -> `id`
--   `user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
CREATE TABLE IF NOT EXISTS `keywords` (
  `mediaid` int(11) unsigned NOT NULL,
  `keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`mediaid`,`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `keywords`:
--   `mediaid`
--       `media` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `extension` varchar(32) DEFAULT NULL,
  `authorid` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(127) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_user_fk` (`authorid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- RELATIONS FOR TABLE `media`:
--   `authorid`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
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
  KEY `messages_to_user_fk` (`to_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- RELATIONS FOR TABLE `messages`:
--   `from_user_id`
--       `users` -> `id`
--   `parent_message_id`
--       `messages` -> `id`
--   `to_user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
  ('2014_02_23_161117_create_users_table',1),
  ('2014_02_26_215107_create_messages_table',1),
  ('2014_03_06_022416_rename_crypted_password_to_password',1),
  ('2014_03_06_035400_add_uniqueness_index_on_username_in_users',1),
  ('2014_03_06_141955_create_media_table',1),
  ('2014_03_18_130229_create_keywords_table',1),
  ('2014_03_18_131523_remove_keywords_from_media_table',1),
  ('2014_03_18_171132_create_interactions_table',1),
  ('2014_03_18_213442_create_subscription_table',1),
  ('2014_03_19_013915_create_playlist_table',1),
  ('2014_03_19_013958_create_playlist_item_table',1),
  ('2014_03_19_155105_create_comment_table',1),
  ('2014_04_05_160639_set_users_created_at_default_value_to_non_null',2),
  ('2014_04_05_161136_add_created_at_to_messages',2),
  ('2014_04_05_183300_rename_username_to_channel_name',3),
  ('2014_04_05_183614_require_unique_email_in_users',3),
  ('2014_04_06_033432_change_primary_key_on_playlist_item',3),
  ('2014_04_06_154847_change_created_on_to_created_at_in_media',3),
  ('2014_04_06_171222_add_id_to_comments',3),
  ('2014_04_06_171532_rename_timestamp_to_created_at_in_comments',3),
  ('2014_04_18_042731_change_description_fields_to_text',4),
  ('2014_04_18_051235_remove_salt_from_users',4),
  ('2014_04_18_051550_add_count_field_to_interactions',4),
  ('2014_04_18_052524_change_index_on_interactions_and_allow_user_id_to_be_null',4),
  ('2014_04_21_034602_add_parent_messsage_id_to_messages',5),
  ('2014_04_21_045918_change_message_fields_to_fit_correct_keytypes',5),
  ('2014_04_21_050500_change_media_to_innodb',5),
  ('2014_04_21_050545_add_foreign_keys_to_messages',5),
  ('2014_04_21_051039_change_comments_fields_to_match_correct_datatypes',5),
  ('2014_04_21_051208_add_foreign_keys_to_comments',5),
  ('2014_04_21_051830_change_interactions_fields_to_match_correct_datatypes',5),
  ('2014_04_21_051950_add_foreign_keys_to_interactions',5),
  ('2014_04_21_053042_add_foreign_keys_to_keywords',5),
  ('2014_04_21_053636_change_media_fields_to_correct_datatype',5),
  ('2014_04_21_053749_add_foreign_keys_to_media',5),
  ('2014_04_21_054120_change_playlist_fields_to_correct_datatype',5),
  ('2014_04_21_054217_add_foreign_keys_to_playlist',5),
  ('2014_04_21_054352_change_playlist_item_fields_to_correct_datatype',5),
  ('2014_04_21_054456_add_foreign_keys_to_playlist_item',5),
  ('2014_04_21_054715_change_subscriptions_fields_to_match_datatype',5),
  ('2014_04_21_054842_add_foreign_keys_to_subscriptions',5);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

DROP TABLE IF EXISTS `playlist`;
CREATE TABLE IF NOT EXISTS `playlist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `playlist_user_fk` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- RELATIONS FOR TABLE `playlist`:
--   `user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `playlist_item`
--

DROP TABLE IF EXISTS `playlist_item`;
CREATE TABLE IF NOT EXISTS `playlist_item` (
  `item_order` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` int(11) unsigned NOT NULL DEFAULT '0',
  `playlist_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_order`,`media_id`,`playlist_id`),
  KEY `playlist_item_media_fk` (`media_id`),
  KEY `playlist_item_playlist_fk` (`playlist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- RELATIONS FOR TABLE `playlist_item`:
--   `media_id`
--       `media` -> `id`
--   `playlist_id`
--       `playlist` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `subscribing_user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `subscription_user_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscribing_user_id`,`subscription_user_id`),
  KEY `subscriptions_subscription_user_fk` (`subscription_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `subscriptions`:
--   `subscribing_user_id`
--       `users` -> `id`
--   `subscription_user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `channel_name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`channel_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_media_fk` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `interactions`
--
ALTER TABLE `interactions`
  ADD CONSTRAINT `interactions_media_fk` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interactions_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keywords`
--
ALTER TABLE `keywords`
  ADD CONSTRAINT `keywords_media_fk` FOREIGN KEY (`mediaid`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_user_fk` FOREIGN KEY (`authorid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_user_fk` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_parent_message_fk` FOREIGN KEY (`parent_message_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_to_user_fk` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `playlist_item`
--
ALTER TABLE `playlist_item`
  ADD CONSTRAINT `playlist_item_media_fk` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `playlist_item_playlist_fk` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_subscribing_user_fk` FOREIGN KEY (`subscribing_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscriptions_subscription_user_fk` FOREIGN KEY (`subscription_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
