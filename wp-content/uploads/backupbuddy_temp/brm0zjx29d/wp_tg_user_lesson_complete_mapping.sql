CREATE TABLE `wp_tg_user_lesson_complete_mapping` (  `m_id` int(11) NOT NULL AUTO_INCREMENT,  `user_id` int(11) NOT NULL,  `l_id` int(11) NOT NULL,  PRIMARY KEY (`m_id`)) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_tg_user_lesson_complete_mapping` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('1', '12', '4063');
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('2', '12', '4075');
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('3', '12', '4076');
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('9', '2', '4063');
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('10', '12', '4077');
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('11', '12', '4078');
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('12', '12', '4101');
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('13', '12', '4095');
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('14', '12', '4097');
INSERT INTO `wp_tg_user_lesson_complete_mapping` VALUES('15', '1', '4097');
/*!40000 ALTER TABLE `wp_tg_user_lesson_complete_mapping` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;