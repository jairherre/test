CREATE TABLE `wp_lms_frmt_form_data` (  `log_id` int(11) NOT NULL AUTO_INCREMENT,  `entry_id` int(11) NOT NULL,  `l_id` int(11) NOT NULL,  `user_id` int(11) NOT NULL,  PRIMARY KEY (`log_id`)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_lms_frmt_form_data` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_lms_frmt_form_data` VALUES('1', '44', '130', '1');
INSERT INTO `wp_lms_frmt_form_data` VALUES('2', '45', '130', '1');
/*!40000 ALTER TABLE `wp_lms_frmt_form_data` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
