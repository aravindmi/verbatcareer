/*
SQLyog Community
MySQL - 5.7.9 : Database - career_dev
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `applicants` */

DROP TABLE IF EXISTS `applicants`;

CREATE TABLE `applicants` (
  `applicant_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `applicant_first_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_last_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_mail` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_location` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_cover_letter` text COLLATE utf8_unicode_ci,
  `applicant_resume` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applicant_status` int(1) DEFAULT '1' COMMENT '1=pending review, 2=reviwed, 3=rejected, 4=onhold',
  `applicant_read_status` int(1) DEFAULT '1' COMMENT '1=unread, 0=read',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted` int(1) DEFAULT '0' COMMENT '0=undeleted, 1= deleted',
  PRIMARY KEY (`applicant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `applicants` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_slug` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_code` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_description` text COLLATE utf8_unicode_ci,
  `job_location` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_experience` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_status` int(1) DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `job_post_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` int(1) DEFAULT '0' COMMENT '0=undeleted, 1= deleted',
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_loggedin` datetime DEFAULT NULL,
  `last_loggedin_ip` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email_id`,`password`,`role_id`,`remember_token`,`last_loggedin`,`last_loggedin_ip`,`created_at`,`updated_at`,`deleted_status`) values 
(1,'Administrator','admin@zestedu.in','0afd4c7797e3073b487f694a6a6b804e8b553cab','1',NULL,'2016-03-22 18:02:07','127.0.0.1','2015-07-01 18:30:00','2015-07-01 18:30:00','0');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
