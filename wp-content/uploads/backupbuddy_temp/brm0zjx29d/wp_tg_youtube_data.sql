CREATE TABLE `wp_tg_youtube_data` (  `log_id` int(11) NOT NULL AUTO_INCREMENT,  `user_id` int(11) NOT NULL,  `l_id` int(11) NOT NULL,  PRIMARY KEY (`log_id`)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_tg_youtube_data` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_tg_youtube_data` VALUES('1', '12', '4063');
INSERT INTO `wp_tg_youtube_data` VALUES('2', '2', '4063');
/*!40000 ALTER TABLE `wp_tg_youtube_data` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
