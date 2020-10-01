CREATE TABLE `wp_wc_customer_lookup` (  `customer_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `user_id` bigint(20) unsigned DEFAULT NULL,  `username` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',  `first_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `last_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `email` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,  `date_last_active` timestamp NULL DEFAULT NULL,  `date_registered` timestamp NULL DEFAULT NULL,  `country` char(2) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',  `postcode` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',  `city` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',  `state` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',  PRIMARY KEY (`customer_id`),  UNIQUE KEY `user_id` (`user_id`),  KEY `email` (`email`)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_wc_customer_lookup` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_wc_customer_lookup` VALUES('1', '1', 'julius.miribung@gmail.com', 'Julius', '', 'julius.miribung@gmail.com', '2020-03-24 00:00:00', '2018-08-10 20:14:09', '', '', '', '');
INSERT INTO `wp_wc_customer_lookup` VALUES('2', '2', 'Avi', 'demoforafo', '', 'demoforafo@gmail.com', '2020-03-14 00:00:00', '2018-08-10 20:26:33', '', '', '', '');
/*!40000 ALTER TABLE `wp_wc_customer_lookup` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
