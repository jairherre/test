CREATE TABLE `wp_lms_post_mapping` (  `m_id` int(11) NOT NULL AUTO_INCREMENT,  `am_id` int(11) NOT NULL,  `p_id` int(11) NOT NULL,  `m_order` int(5) NOT NULL,  PRIMARY KEY (`m_id`)) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_lms_post_mapping` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_lms_post_mapping` VALUES('8', '312', '94', '1');
/*!40000 ALTER TABLE `wp_lms_post_mapping` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
