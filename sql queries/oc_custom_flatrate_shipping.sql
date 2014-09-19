# Host: localhost  (Version: 5.5.25)
# Date: 2014-09-17 21:18:19
# Generator: MySQL-Front 5.2  (Build 5.28)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;

#
# Source for table "oc_custom_flatrate_shipping"
#

DROP TABLE IF EXISTS `oc_custom_flatrate_shipping`;
CREATE TABLE `oc_custom_flatrate_shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `countries` mediumtext,
  `price` int(11) DEFAULT '0',
  `order` int(3) DEFAULT NULL,
  `cart_price` int(11) DEFAULT '0',
  `message` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "oc_custom_flatrate_shipping"
#

INSERT INTO `oc_custom_flatrate_shipping` VALUES (1,'Great Britain','222',0,1,125,'Your Shipping Is Free For This Order\" (UK, order above £#cart_price#)'),(2,'Great Britain - big order','222',5,2,0,'Flat Rate Shipping To #country# £#price#'),(3,'EU','14,21,33,84,57,67,103,67,105,55,117,123,124,132,150,81,170,171,175,189,190,97,72,74,53,56,203',10,3,0,'Flat Rate Shipping To #country# £#price#'),(4,'USA and Canada','38, 223',20,4,0,'Flat Rate Shipping To #country# £#price#'),(5,'World','',30,5,0,'Flat Rate Shipping To #country# £#price#');

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
