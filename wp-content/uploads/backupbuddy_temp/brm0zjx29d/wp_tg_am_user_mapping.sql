CREATE TABLE `wp_tg_am_user_mapping` (  `m_id` int(11) NOT NULL AUTO_INCREMENT,  `am_id` int(11) NOT NULL,  `user_id` int(11) NOT NULL,  `added_on` datetime NOT NULL,  `m_status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive',  `ua_mail_status` enum('Unsent','Sent') NOT NULL DEFAULT 'Unsent',  `uua_mail_status` enum('Unsent','Sent') NOT NULL DEFAULT 'Unsent',  PRIMARY KEY (`m_id`)) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_tg_am_user_mapping` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_tg_am_user_mapping` VALUES('1', '4052', '2', '2020-07-22 11:38:10', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('4', '4074', '2', '2020-07-24 07:34:43', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('5', '4074', '11', '2020-07-24 07:34:51', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('6', '4074', '12', '2020-07-24 07:34:57', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('7', '4074', '1', '2020-07-24 08:02:14', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('9', '4074', '12', '2020-07-24 08:25:24', 'Active', 'Sent', 'Sent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('10', '4052', '12', '2020-07-24 16:54:43', 'Inactive', 'Sent', 'Sent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('13', '4089', '12', '2020-07-26 15:04:10', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('14', '4089', '11', '2020-07-27 09:06:43', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('15', '4089', '1', '2020-07-27 09:06:54', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('16', '4089', '2', '2020-07-27 09:07:08', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('17', '4089', '13', '2020-08-26 15:06:36', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('18', '4089', '15', '2020-08-28 07:25:36', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('19', '4089', '16', '2020-08-28 07:45:07', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('20', '4089', '17', '2020-08-28 07:51:06', 'Active', 'Sent', 'Unsent');
INSERT INTO `wp_tg_am_user_mapping` VALUES('21', '4089', '18', '2020-08-28 07:51:22', 'Active', 'Sent', 'Unsent');
/*!40000 ALTER TABLE `wp_tg_am_user_mapping` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
