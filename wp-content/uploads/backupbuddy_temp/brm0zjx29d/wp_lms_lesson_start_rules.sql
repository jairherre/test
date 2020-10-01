CREATE TABLE `wp_lms_lesson_start_rules` (  `r_id` int(11) NOT NULL AUTO_INCREMENT,  `c_id` int(11) NOT NULL,  `f_l_id` int(11) NOT NULL,  `s_l_id` int(11) NOT NULL,  PRIMARY KEY (`r_id`)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_lms_lesson_start_rules` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_lms_lesson_start_rules` VALUES('1', '7', '8', '10');
INSERT INTO `wp_lms_lesson_start_rules` VALUES('2', '7', '10', '11');
/*!40000 ALTER TABLE `wp_lms_lesson_start_rules` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
