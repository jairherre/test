CREATE TABLE `wp_cartflows_visits` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `step_id` bigint(20) NOT NULL,  `date_visited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `visit_type` enum('new','return') COLLATE utf8mb4_unicode_ci DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_cartflows_visits` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_cartflows_visits` VALUES('1', '269', '2019-07-25 19:44:57', 'new');
INSERT INTO `wp_cartflows_visits` VALUES('2', '251', '2019-07-25 19:46:07', 'new');
INSERT INTO `wp_cartflows_visits` VALUES('3', '269', '2019-07-25 19:46:17', 'new');
INSERT INTO `wp_cartflows_visits` VALUES('4', '269', '2019-07-25 19:48:28', 'new');
INSERT INTO `wp_cartflows_visits` VALUES('5', '269', '2019-07-25 19:49:06', 'return');
INSERT INTO `wp_cartflows_visits` VALUES('6', '269', '2019-07-25 19:49:20', 'return');
INSERT INTO `wp_cartflows_visits` VALUES('7', '269', '2019-07-25 19:49:48', 'return');
INSERT INTO `wp_cartflows_visits` VALUES('8', '284', '2019-07-25 19:50:51', 'new');
INSERT INTO `wp_cartflows_visits` VALUES('9', '284', '2019-07-25 19:51:46', 'new');
INSERT INTO `wp_cartflows_visits` VALUES('10', '283', '2019-07-25 19:52:44', 'new');
INSERT INTO `wp_cartflows_visits` VALUES('11', '284', '2019-07-25 19:52:56', 'new');
INSERT INTO `wp_cartflows_visits` VALUES('12', '284', '2019-07-25 19:53:17', 'return');
INSERT INTO `wp_cartflows_visits` VALUES('13', '283', '2019-07-26 09:26:19', 'new');
INSERT INTO `wp_cartflows_visits` VALUES('14', '284', '2019-07-26 09:26:30', 'return');
INSERT INTO `wp_cartflows_visits` VALUES('15', '284', '2019-07-26 09:26:43', 'return');
/*!40000 ALTER TABLE `wp_cartflows_visits` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
