-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Mar 26 Janvier 2016 à 23:08
-- Version du serveur: 5.5.34
-- Version de PHP: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `hicom-multirestaurants`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `role` tinyint(1) NOT NULL,
  `shopId` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `account`
--

INSERT INTO `account` (`id`, `type`, `username`, `password`, `email`, `full_name`, `phone`, `address`, `role`, `shopId`, `status`) VALUES
('1397811111', 0, 'Cuong', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'immrhy@gmail.com', 'Hy Cuong 1', '0123756789 1', '17Phung chi kien 1', 1, 0, 1),
('1397811112', 0, 'Moon', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'innrhy@gmail.com', 'Nguyen Kieu Oanh', '01897654', '17 Phung Chi Kien', 1, 0, 1),
('1414741098', 0, 'Alberto', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'mango@fruitysolution.com', 'Alberto Massa', '+65 85245135', 'Fernwood towers ', 1, 0, 1),
('1414741099', 0, 'testuser', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'testuser@gmail.com', 'Test User', '0123456789', 'Hanoi', 0, 0, 1),
('1432348471', 0, 'Peter', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'peter.parker@gmail.com', 'Peter Parker', '123456789', '123 King Street', 3, 39, 1),
('1432349043', 0, 'Andrew', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'andrew@gmail.com', 'Andrew', '123456789', '123 King Street', 4, 39, 1),
('1432968683', 0, 'cuonghy', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'cuonghy@gmail.com', 'Cuong Hy', '112223444', '123 King Street', 5, 39, 1),
('1432968757', 0, 'tester', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'fruity.tester123@gmail.com', 'pham manh cuong 1', '757-681-5600', 'PO Box 668132, Charlotte, NC', 1, 0, 1),
('1436099278', 0, 'bizpro', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'bizpro@012.net.il', 'Bizpro', '0123456789', 'PO Box 668132, Charlotte, NC 28266', 1, 0, 1),
('1436100426', 0, 'bizprorep2', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'bizprorep2@bmola.com', 'BizproRep', '0123456789', 'Somewhere', 5, 41, 1),
('1441015549', 0, 'peterdelivery', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'peter@gmail.com.abc', 'Peter Pan', '0123456789', '123 Street', 1, 41, 1),
('1441015578', 0, 'andrechef', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'andrew@gmail.com.abc', 'Peter Pan', '0123456789', '123 Street', 3, 41, 1),
('1441093422', 0, 'nevermore', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'nevermore@gmail.com', 'Never More', '0123456789', '123 Street', 3, 40, 1),
('1442497728', 0, 'bizprochef', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'bizprochefPT@bmola.com', 'Bizpro Chef', '0123456789', '123 King Street', 3, 39, 1),
('1442497765', 0, 'testchef', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'testchef@bmola.com', 'Bmola', '0123456789', '123 Queen Street', 3, 39, 1),
('1449636583', 1, 'nxh_ars_11@yahoo.com.vn', '1e34d23747b2322054ca64e3ada566d8ddd75b24', 'nxh_ars_11@yahoo.com.vn', 'Hoàng Hải', '', '', 0, 0, 1),
('1449646774', 0, 'demo1', '10f71961bd11dd33c1c95c771b98cf0e09d57b7c', 'email@gmail.com', 'Pham Manh Cuong', '0912312308', 'Phung Chi Kien', 0, 0, 0),
('1449825085', 0, 'aa', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'email@fjjfjfnd.jcjc', 'demo', '0912312308', 'address', 0, 0, 1),
('1449904991', 1, 'huybkaptech@gmail.com', 'ad9532027e49ea7b72c5f47cea389bfe3510bdc7', 'huybkaptech@gmail.com', 'Huy Huy', '', '', 0, 0, 1),
('1450082617', 0, '123456', '8cb2237d0679ca88db6464eac60da96345513964', 'email1231@gmail.com', 'PhamManhCuong', '0912312308', 'address', 0, NULL, 1),
('1450162397', 1, 'phamvandiep93@yahoo.com', 'afcf9dae15e41cd425eae99b1fbb8729b732a722', 'phamvandiep93@yahoo.com', 'Phạm Điệp', '', '', 0, NULL, 1),
('1450176364', 1, 'hicom.register@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'hicom.register@gmail.com', 'John John', '0912312308', 'Address', 1, NULL, 1),
('1450260376', 0, 'admin123', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'akalololala@gmail.com', 'pham diep', '0977877271', 'hâhh', 0, NULL, 1),
('1450338899', 0, 'Diep', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'diep@gmail.com', 'Pham Diep', '0912312308', 'address', 0, NULL, 1),
('1450339317', 1, 'anhhaicz@gmail.com', 'dc94e48d161910e3d8f5d24892f0c6d171c31586', 'anhhaicz@gmail.com', 'Hoàng Tiến', '', '', 0, NULL, 1),
('1450414768', 1, 'fruity.tester@gmail.com', 'c3e57448281c5cc2ce2327375f3f278b8cb63429', 'fruity.tester@gmail.com', 'Phạm Đan Trường', '', '', 0, NULL, 1),
('1450695146', 0, 'hanh', 'e63b80d4e2977478450f01731535833551ac59a5', 'kieuhanh1994@gmail.com', 'hanh kieu', '08939293', 'hhh', 0, NULL, 1),
('1452564676', 1, 'maiyeuemb09@gmail.com', '36e7ae45bce464b12a08e8e9350fccd328d43afd', 'maiyeuemb09@gmail.com', 'Visao Codon', '', '', 0, NULL, 1),
('admin', 0, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@gmail.com', 'Stephen', '9942048657', 'Hanoi', 2, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `bannerId` int(11) NOT NULL AUTO_INCREMENT,
  `bannerName` varchar(100) NOT NULL,
  `bannerImage` varchar(100) NOT NULL,
  `shopId` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`bannerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `banner`
--

INSERT INTO `banner` (`bannerId`, `bannerName`, `bannerImage`, `shopId`, `status`) VALUES
(1, '1', '1433238361.jpg', 38, 1),
(2, '23', '1433238381.jpg', 38, 1),
(3, 'TestBanner', '1436106405.jpg', 41, 1),
(4, 'Banner2', '1436216938.jpg', 41, 1),
(5, 'Banner1', '1441014692.jpg', 40, 1),
(6, 'Banner2', '1441014713.png', 40, 1),
(7, 'Banner3', '1441014730.jpg', 40, 1);

-- --------------------------------------------------------

--
-- Structure de la table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `cityId` int(11) NOT NULL AUTO_INCREMENT,
  `cityPostCode` varchar(20) NOT NULL,
  `cityName` varchar(100) NOT NULL,
  PRIMARY KEY (`cityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Contenu de la table `city`
--

INSERT INTO `city` (`cityId`, `cityPostCode`, `cityName`) VALUES
(1, '560', 'Bangalore'),
(16, 'AZ1', 'Poplar'),
(17, '230', 'Port Louis'),
(18, '043', 'Ha Noi'),
(19, '083', 'Ho Chi Minh'),
(20, '040', 'Bac Ninh'),
(21, '041', 'Vinh Phuc'),
(22, '458', 'Singapore'),
(23, 'A50', 'Tel Aviv'),
(24, 'C51', 'Ramat Gan'),
(25, '122018', 'Gurgaon');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `account_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `rate` float(4,2) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Contenu de la table `comment`
--

INSERT INTO `comment` (`id`, `location_id`, `food_id`, `account_id`, `title`, `content`, `rate`, `created`) VALUES
(4, 41, 6, 'hdjdj', '', 'Hdjdhd', 4.33, '2015-12-15 13:51:03'),
(5, 40, 5, 'Pham Manh Cuong', '', '0912312308', 10.00, '2015-12-17 14:32:44'),
(6, 40, 5, 'gbb', '', 'Cachko', 3.58, '2015-12-17 15:10:19'),
(7, 41, 6, 'fighters', '', ' Shells fklsd', 10.00, '2015-12-17 16:34:30'),
(8, 41, 6, 'f ads d', '', ' Afar s', 10.00, '2015-12-17 16:35:59'),
(9, 40, 12, 'fix ', '', ' Ft fgfcgf', 10.00, '2015-12-17 17:26:48'),
(10, 41, 6, '1', '', '2', 10.00, '2015-12-17 19:25:43'),
(11, 41, 6, '3', '', '4', 10.00, '2015-12-17 19:25:54'),
(12, 41, 6, '5', '', 'The &quot; entity was mistakenly omitted from the HTML 3.2 specification. While use of &quot; generates error reports when validating against 3.2, browsers have continued to recognize the entity and its use is generally safe (sticklers may wish to use &#34; instead). The omission has been corrected in the HTML 4.0 specification.', 10.00, '2015-12-17 19:26:03'),
(13, 40, 12, 'đầu', '', 'Fsdfsfsd', 10.00, '2015-12-17 20:33:56'),
(14, 40, 12, 'Đà', '', 'Fsfs', 10.00, '2015-12-17 20:34:04'),
(15, 40, 12, 'chin', '', 'Chim', 10.00, '2015-12-17 21:40:01'),
(16, 41, 6, 'Pham Manh Cuong', '', 'Very good', 10.00, '2015-12-18 11:37:25'),
(17, 41, 6, 'ghh', '', 'Fight', 6.00, '2015-12-22 10:51:15'),
(18, 41, 7, 'tvvbggg', '', 'Gbyogmb', 10.00, '2015-12-22 10:52:22');

-- --------------------------------------------------------

--
-- Structure de la table `datetb`
--

CREATE TABLE IF NOT EXISTS `datetb` (
  `dateId` int(11) NOT NULL AUTO_INCREMENT,
  `dateName` varchar(20) DEFAULT NULL,
  `fullDateName` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`dateId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `datetb`
--

INSERT INTO `datetb` (`dateId`, `dateName`, `fullDateName`) VALUES
(1, 'sun', 'Sunday'),
(2, 'mon', 'Monday'),
(3, 'tue', 'Tuesday'),
(4, 'wed', 'Wednesday'),
(5, 'thu', 'Thusday'),
(6, 'fri', 'Friday'),
(7, 'sat', 'Saturday');

-- --------------------------------------------------------

--
-- Structure de la table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `tittle` text NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `status` int(11) DEFAULT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  `note` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Contenu de la table `feedback`
--

INSERT INTO `feedback` (`id`, `account_id`, `tittle`, `description`, `created`, `status`, `type`, `note`) VALUES
(6, 1450176364, 'bug tie', 'bug jcjc', '2016-01-19 16:15:27', 1, 2, ''),
(7, 1450176364, 'bug tie', 'bug jcjc', '2016-01-19 16:15:32', 1, 2, ''),
(8, 1450176364, 'demo', 'ndjdjdd', '2016-01-19 17:49:32', 1, 2, ''),
(9, 1450176364, 'demo', 'ndjdjdd', '2016-01-19 17:50:47', 0, 2, ''),
(10, 1450176364, 'title', '0912312308', '2016-01-21 15:08:27', 0, 1, ''),
(11, 1450176364, 'nice to meet you', 'deacription', '2016-01-21 15:18:25', 0, 1, ''),
(12, 1450176364, 'alo', 'hfjfhff', '2016-01-21 15:18:56', 0, 1, ''),
(13, 1450176364, 'alo', 'hfjfhff', '2016-01-21 15:19:09', 0, 1, ''),
(15, 1450162397, 'Shahs', 'Shah', '2016-01-21 15:48:28', 0, 1, ''),
(16, 1450162397, 'Shahs be', 'Shahs', '2016-01-21 15:48:55', 0, 2, ''),
(17, 1450162397, 'Shah', 'Shan', '2016-01-21 15:50:32', 0, 2, ''),
(18, 1450176364, 'Report Bizpro TelAviv (ID:43)', 'demo', '2016-01-21 16:47:35', 0, 2, ''),
(19, 1414741099, 'Report Bizpro TelAviv (ID:43)', 'Hah', '2016-01-21 17:27:17', 0, 2, ''),
(20, 1414741099, 'aaaa', 'bbbbbb', '2016-01-21 17:32:17', 0, 1, ''),
(22, 1414741099, 'Report Bizpro TelAviv (ID:43)', 'alo', '2016-01-21 17:33:41', 0, 2, ''),
(23, 1414741099, 'day la feedback', 'noi dung cua feedback', '2016-01-22 14:50:46', 0, 1, ''),
(24, 1414741099, 'day la bug', 'mo ta ve bug', '2016-01-22 14:52:15', 0, 3, ''),
(25, 1414741099, 'Report Bizpro TelAviv (ID:43)', 'do dong nat', '2016-01-22 14:52:54', 0, 2, '');

-- --------------------------------------------------------

--
-- Structure de la table `finance`
--

CREATE TABLE IF NOT EXISTS `finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopId` varchar(255) DEFAULT NULL,
  `budget` float DEFAULT NULL,
  `updateTime` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `finance`
--

INSERT INTO `finance` (`id`, `shopId`, `budget`, `updateTime`, `status`) VALUES
(1, '41', 5, '2015-12-14 13:34:39', 1),
(2, '40', 523, '2015-12-14 13:37:30', 1);

-- --------------------------------------------------------

--
-- Structure de la table `financehistory`
--

CREATE TABLE IF NOT EXISTS `financehistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` varchar(20) DEFAULT NULL,
  `amount` float(20,2) DEFAULT NULL,
  `createdTime` datetime DEFAULT NULL,
  `approvedTime` datetime DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `financeowner`
--

CREATE TABLE IF NOT EXISTS `financeowner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` varchar(20) DEFAULT NULL,
  `budget` float(20,2) DEFAULT NULL,
  `updateTime` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `financeowner`
--

INSERT INTO `financeowner` (`id`, `ownerId`, `budget`, `updateTime`, `status`) VALUES
(1, '1397811111', 528.00, '2015-12-14 13:37:30', 1);

-- --------------------------------------------------------

--
-- Structure de la table `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `food_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `food_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `food_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `food_price` double DEFAULT NULL,
  `food_thumbnail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `food_small_thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `food_menus` int(11) NOT NULL,
  `food_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `status_in_day` tinyint(1) NOT NULL DEFAULT '1',
  `food_event_cost` double DEFAULT NULL,
  `food_event_start_time` datetime DEFAULT NULL,
  `food_event_end_time` datetime DEFAULT NULL,
  `food_event_thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `lang` tinyint(1) DEFAULT NULL,
  `available` tinyint(1) DEFAULT NULL,
  `rate` float(4,2) DEFAULT NULL,
  `rate_times` int(11) DEFAULT NULL,
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Contenu de la table `food`
--

INSERT INTO `food` (`food_id`, `food_code`, `food_name`, `shop_id`, `food_price`, `food_thumbnail`, `food_small_thumbnail`, `food_menus`, `food_desc`, `status_in_day`, `food_event_cost`, `food_event_start_time`, `food_event_end_time`, `food_event_thumbnail`, `status`, `lang`, `available`, `rate`, `rate_times`) VALUES
(1, 'A9999', 'Siro', 38, 99, '1443423872.jpg', NULL, 30, 'Siro description.', 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 7.52, 0),
(3, 'TB22K', 'Orange juice', 38, 22, '1443423724.jpg', NULL, 30, 'Orange juice is the liquid extract of the fruit of the orange tree.', 0, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 0),
(5, 'MK9', 'Grilled Squid', 40, 123, '1432633468.jpg', NULL, 28, 'Grilled squid  very delicious.', 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 6.79, 2),
(6, '1', 'Milk Coffee', 41, 10, '1443424192.jpg', NULL, 30, 'Very delicious.', 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 8.79, 8),
(7, '2', 'Coffee Brown', 41, 5, '1443424275.jpg', NULL, 30, 'Coffee brown description.', 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 10.00, 1),
(8, '1', 'Salad', 42, 11, '1443424941.jpg', NULL, 26, 'Salad', 1, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 0),
(12, 'T1', 'Seafood Shrimp', 40, 100, '1443429375.jpg', NULL, 28, 'Seafood shrimp description', 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 10.00, 4),
(13, 'CC1', 'Fried Crab', 40, 300, '1443429717.jpg', NULL, 28, 'Fried crab description.', 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 10.00, 0);

-- --------------------------------------------------------

--
-- Structure de la table `food_promotion`
--

CREATE TABLE IF NOT EXISTS `food_promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_city` int(11) DEFAULT NULL,
  `location_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_id` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `location_image` varchar(100) DEFAULT NULL,
  `location_des` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `location_tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_open_hour_style` tinyint(1) NOT NULL DEFAULT '0',
  `location_open_hour` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `location_last_order_hour` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_latitude` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_longitude` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `lang` tinyint(1) DEFAULT NULL,
  `tax` varchar(500) DEFAULT NULL,
  `shipping` varchar(500) DEFAULT NULL,
  `rate` float(4,2) DEFAULT NULL,
  `rate_times` int(11) DEFAULT NULL,
  `gmt` varchar(40) DEFAULT NULL,
  `isVerified` int(1) NOT NULL DEFAULT '0',
  `isFeatured` int(1) NOT NULL DEFAULT '0',
  `facebook` varchar(500) NOT NULL,
  `twitter` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `live_chat` varchar(500) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Contenu de la table `location`
--

INSERT INTO `location` (`location_id`, `location_name`, `location_city`, `location_address`, `account_id`, `location_image`, `location_des`, `location_tel`, `location_open_hour_style`, `location_open_hour`, `location_last_order_hour`, `location_latitude`, `location_longitude`, `status`, `lang`, `tax`, `shipping`, `rate`, `rate_times`, `gmt`, `isVerified`, `isFeatured`, `facebook`, `twitter`, `email`, `live_chat`) VALUES
(38, 'Drinks Express', 1, '123 King Street', '1397811112', '1450080347.jpeg', 'Drinks for you!', '123456789', 0, NULL, NULL, '21.321233269428006', '104.8785400390625', 1, NULL, '{"VAT":"10","tax_status":"1"}', '{"flat_rate":"11","minimum":"1888","local_pickup":"1","shipping_status":"1"}', 7.52, 0, 'Asia/Bangkok', 0, 1, '', '', '', ''),
(39, 'Pizza Hut', 24, 'Tirza 1 Ramat Gan', '1436099278', '1450080159.jpeg', 'Delicious pizza', '1234567891', 0, NULL, NULL, '21.018078071903105', '105.78585660992744', 1, NULL, '{"VAT":"10","tax_status":"1"}', '{"flat_rate":"11","minimum":"1888","local_pickup":"1","shipping_status":"1"}', 8.35, 0, 'Asia/Bangkok', 0, 1, '', '', '', ''),
(40, 'Seafood', 24, '12 Diago Street', '1397811111', '1450080208.jpeg', 'Việt Nam', '12345654321', 0, NULL, NULL, '21.022699204347', '105.83696370000007', 1, NULL, '{"VAT":"10","tax_status":0}', '{"flat_rate":"10","minimum":1000,"local_pickup":1,"shipping_status":0}', 8.93, 6, 'Asia/Bangkok', 0, 0, '', '', '', ''),
(41, 'Garden Coffee', 24, 'Ramat Gan', '1397811111', '1450080041.jpeg', '', '0678947467', 0, NULL, NULL, '21.03847726713378', '105.78932202397468', 1, NULL, '{"VAT":"18","tax_status":"0"}', '{"flat_rate":"2","minimum":"50","local_pickup":"1","shipping_status":"1"}', 8.93, 9, 'Asia/Bangkok', 0, 0, '', '', '', ''),
(42, 'Sweeden Restaur', 23, 'Dizingof 55 Tel Aviv', '1436099278', '1450080475.jpeg', '', '1234655678', 0, NULL, NULL, '32.07554440995226', '34.77507379999997', 1, NULL, '{"VAT":"10","tax_status":"0"}', '{"flat_rate":"1","minimum":"30","local_pickup":"1","shipping_status":"1"}', NULL, 0, 'Asia/Bangkok', 0, 0, '', '', '', ''),
(43, 'Bizpro TelAviv', 25, 'Sector 48, Sohna Road, Gurgaon', '1397811111', '1450080106.jpeg', 'Veg food', '12345678', 0, NULL, NULL, '28.409827117544108', '77.0504668872195', 1, NULL, '{"VAT":"10","tax_status":"1"}', '{"flat_rate":"10","minimum":"1000","local_pickup":"1","shipping_status":"1"}', 9.36, 0, 'Asia/Bangkok', 1, 1, 'facebook', 'twitter', 'email@gmail.com', 'live chat');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_small_thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_desc` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `lang` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Contenu de la table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_name`, `menu_small_thumbnail`, `menu_desc`, `parent_id`, `status`, `lang`) VALUES
(10, 'Chicken', '1440745471.jpg', '<p>Chicken Category</p>\r\n', 0, 1, 2),
(13, 'Pizza', '1443423327.jpg', '<p>Pizza description</p>\r\n', 0, 1, 2),
(14, 'Thai', '1440745672.jpg', '<p>Thai food description</p>\r\n', 0, 1, 2),
(24, 'Sweet', '1396061261.jpg', '<p>Description</p>\r\n', 0, 1, NULL),
(25, 'Vegetarian', '1396061443.jpg', '<p>Vegetarian is something that has no meat or that is related to the absence of meat.</p>\r\n', 0, 1, NULL),
(26, 'Vegetables', '1396368716.jpg', '<p>vegetables</p>\r\n', 0, 1, NULL),
(27, 'Dessert', '1396402533.jpg', '<p>Dessert is a typically sweet course that concludes a meal. The course usually consists of sweet foods, but may include other items.</p>\r\n\r\n<p>There is a wide variety of desserts in western cultures including cakes, cookies, biscuits, gelatins, pastries, ice creams, pies, puddings, and candies. Fruit is also commonly found in dessert courses because of its naturally occurring sweetness. Many different cultures have their own variations of similar desserts around the world, such as in Russia, where many breakfast foods such as blint, oladi, and syrniki can be served with honey and jam to make them popular as desserts. The loosely defined course called dessert can apply to many foods</p>\r\n', 0, 1, NULL),
(28, 'Seafood', '1443422651.jpg', '<p>Seafood description.</p>\r\n', 0, 1, NULL),
(29, 'Cream', '1396409558.jpg', '<p>Cream is a dairy product that is composed of the higher-butterfat layer skimmed from the top of milk before homogenization. In un-homogenized milk, the fat, which is less dense, will eventually rise to the top. In the industrial production of cream, this process is accelerated by using centrifuges called &quot;separators&quot;. In many countries, cream is sold in several grades depending on the total butterfat content. Cream can be dried to a powder for shipment to distant markets.</p>\r\n', 0, 1, NULL),
(30, 'Drink', '1398218790.jpg', '<p>Drink</p>\r\n', 0, 1, NULL),
(31, 'Demo', '1449731673.png', '<p>Demo</p>\r\n', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `open_hour_detail`
--

CREATE TABLE IF NOT EXISTS `open_hour_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopId` int(11) NOT NULL,
  `dateId` int(11) NOT NULL,
  `openAM` varchar(20) DEFAULT NULL,
  `closeAM` varchar(20) DEFAULT NULL,
  `openPM` varchar(20) DEFAULT NULL,
  `closePM` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=288 ;

--
-- Contenu de la table `open_hour_detail`
--

INSERT INTO `open_hour_detail` (`id`, `shopId`, `dateId`, `openAM`, `closeAM`, `openPM`, `closePM`) VALUES
(225, 38, 1, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(226, 38, 2, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(227, 38, 3, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(228, 38, 4, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(229, 38, 5, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(230, 38, 6, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(231, 38, 7, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(232, 39, 1, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(233, 39, 2, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(234, 39, 3, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(235, 39, 4, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(236, 39, 5, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(237, 39, 6, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(238, 39, 7, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(239, 40, 1, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(240, 40, 2, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(241, 40, 3, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(242, 40, 4, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(243, 40, 5, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(244, 40, 6, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(245, 40, 7, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(246, 41, 1, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(247, 41, 2, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(248, 41, 3, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(249, 41, 4, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(250, 41, 5, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(251, 41, 6, '12:00 AM', '05:00 PM', '07:00 AM', '03:00 PM'),
(252, 41, 7, '12:00 AM', '04:00 AM', '07:00 AM', '08:00 AM'),
(253, 42, 1, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(254, 42, 2, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(255, 42, 3, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(256, 42, 4, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(257, 42, 5, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(258, 42, 6, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(259, 42, 7, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(260, 43, 1, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(261, 43, 2, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(262, 43, 3, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(263, 43, 4, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(264, 43, 5, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(265, 43, 6, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(266, 43, 7, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(281, 46, 1, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(282, 46, 2, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(283, 46, 3, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(284, 46, 4, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(285, 46, 5, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(286, 46, 6, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM'),
(287, 46, 7, '12:00 AM', '04:00 AM', '07:00 AM', '03:00 PM');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(11) NOT NULL,
  `order_places` text COLLATE utf8_unicode_ci NOT NULL,
  `order_requirement` text CHARACTER SET latin1 NOT NULL,
  `order_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `paymentMethod` int(11) DEFAULT NULL,
  `paymentStatus` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `group_code` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chef_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deliveryman_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `orders`
--

INSERT INTO `orders` (`order_id`, `account_id`, `shop_id`, `order_places`, `order_requirement`, `order_time`, `status`, `paymentMethod`, `paymentStatus`, `created`, `group_code`, `chef_id`, `deliveryman_id`) VALUES
(1, '1414741099', 41, 'Hanoi', '', '2016-01-22 10:51:26', 0, 1, 0, '2016-01-22 10:51:26', 'D237271099', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `order_food`
--

CREATE TABLE IF NOT EXISTS `order_food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `order_food`
--

INSERT INTO `order_food` (`id`, `order_id`, `food_id`, `number`, `price`) VALUES
(3, 1, 13, 4, 300),
(4, 1, 7, 1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `order_group`
--

CREATE TABLE IF NOT EXISTS `order_group` (
  `group_code` varchar(255) NOT NULL DEFAULT '',
  `total` float DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `account_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`group_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `order_group`
--

INSERT INTO `order_group` (`group_code`, `total`, `dateCreated`, `account_id`) VALUES
('D237271099', 7, '2016-01-22 10:51:26', '1414741099');

-- --------------------------------------------------------

--
-- Structure de la table `order_total`
--

CREATE TABLE IF NOT EXISTS `order_total` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` varchar(255) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `shipping` double DEFAULT NULL,
  `grandTotal` double DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `order_total`
--

INSERT INTO `order_total` (`id`, `orderId`, `total`, `tax`, `shipping`, `grandTotal`, `dateCreated`) VALUES
(1, '1', 5, 0, 2, 7, '2016-01-22 10:51:26');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE IF NOT EXISTS `promotion` (
  `promotion_id` int(10) NOT NULL AUTO_INCREMENT,
  `promotion_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `promotion_name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `promotion_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `promotion_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent_discount` float NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `lang` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`promotion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `promotion`
--

INSERT INTO `promotion` (`promotion_id`, `promotion_code`, `promotion_name`, `shop_id`, `promotion_desc`, `promotion_image`, `percent_discount`, `start_date`, `end_date`, `end_time`, `status`, `lang`) VALUES
(1, 'ABCD999', 'Open', 38, 'Open promotion', '1426304455.jpg', 20, '2015-06-02', '2015-09-30', '02:45:00', 1, NULL),
(2, 'ABCD9997654', 'Open', 39, '1234', '1423295410.jpg', 10, '2015-02-07', '2015-02-28', '03:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `request`
--

INSERT INTO `request` (`id`, `user_id`, `created`) VALUES
(9, '1443769547', '2015-11-28 17:58:45'),
(10, '1449629783', '2015-12-09 10:33:39'),
(13, '1450085999', '2015-12-14 16:48:26'),
(14, '1450260376', '2015-12-16 17:08:05'),
(15, '1450338899', '2015-12-17 14:55:17'),
(16, '1450414768', '2015-12-18 12:01:31'),
(17, '1450162397', '2015-12-21 17:55:04'),
(18, '1414741099', '2016-01-22 10:44:30');

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(10) unsigned NOT NULL,
  `setting_key` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `setting_data` text COLLATE utf8_unicode_ci,
  `setting_bankinfo` text COLLATE utf8_unicode_ci,
  `setting_currency` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_latitude` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `location_longitude` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_key`, `setting_value`, `setting_data`, `setting_bankinfo`, `setting_currency`, `location_latitude`, `location_longitude`) VALUES
(1382069043, 'SYSTEM_EMAIL', '1382069043', '{"host":"smtp.gmail.com","username":"fruity.tester@gmail.com","password":"trollerlvlmax","port":"465","encryption":"tls"}', '<p>Bank Infomation Restaurant</p>\r\n', '$', '21.041402256109038', '105.8025652');

-- --------------------------------------------------------

--
-- Structure de la table `user_shop`
--

CREATE TABLE IF NOT EXISTS `user_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopId` int(11) NOT NULL,
  `accountId` varchar(30) NOT NULL,
  `order_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `user_shop`
--

INSERT INTO `user_shop` (`id`, `shopId`, `accountId`, `order_count`) VALUES
(1, 40, '1449636583', 1),
(2, 41, '1449636583', 1),
(3, 41, '1449826580', 2),
(4, 40, '1449826580', 2),
(5, 38, '1432968757', 1),
(6, 41, '1414741099', 5),
(7, 40, '1414741099', 4),
(8, 41, '1450082617', 2),
(9, 40, '1450082617', 4),
(10, 41, '1450162397', 2),
(11, 40, '1450176364', 1),
(12, 41, '1450176364', 1),
(13, 40, '1450338899', 1),
(14, 40, '1450339317', 1),
(15, 41, '1397811111', 1),
(16, 40, '1397811111', 1),
(17, 40, '1450414768', 2),
(18, 41, '1450414768', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
