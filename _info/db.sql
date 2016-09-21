/*
SQLyog Enterprise - MySQL GUI v8.12 
MySQL - 5.5.5-10.1.13-MariaDB : Database - larav-admin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`larav-admin` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `larav-admin`;

/*Table structure for table `admin_permissions` */

DROP TABLE IF EXISTS `admin_permissions`;

CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_users_id` int(11) NOT NULL,
  `admin_section_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_admin_users_id_admin_section_id_unique` (`admin_users_id`,`admin_section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_permissions` */

insert  into `admin_permissions`(`id`,`admin_users_id`,`admin_section_id`) values (1,1,1),(2,1,2);

/*Table structure for table `admin_sections` */

DROP TABLE IF EXISTS `admin_sections`;

CREATE TABLE `admin_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_sections` */

insert  into `admin_sections`(`id`,`label`) values (1,'Admin Users');

/*Table structure for table `admin_users` */

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_add` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pass_w` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_super_admin` tinyint(4) NOT NULL DEFAULT '0',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_email_add_unique` (`email_add`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_users` */

insert  into `admin_users`(`id`,`email_add`,`pass_w`,`first_name`,`last_name`,`is_active`,`is_super_admin`,`added_on`) values (1,'raheel.hsn1@gmail.com','56c66c8878b1783ac18da0b4a3aaa1b03a8116064a7524a3eb790a624a50eb68','','',1,0,'2016-09-01 20:22:33');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values ('2016_08_18_051311_class_admin_tables',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
