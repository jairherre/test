CREATE TABLE `wp_tg_resource_mapping` (  `m_id` int(11) NOT NULL AUTO_INCREMENT,  `l_id` int(11) NOT NULL,  `r_id` int(11) NOT NULL,  `r_title` varchar(255) NOT NULL,  `r_highlight` enum('no','yes') NOT NULL DEFAULT 'no',  PRIMARY KEY (`m_id`)) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_tg_resource_mapping` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_tg_resource_mapping` VALUES('17', '4063', '0', 'Video', 'yes');
INSERT INTO `wp_tg_resource_mapping` VALUES('18', '4063', '4066', '', 'no');
INSERT INTO `wp_tg_resource_mapping` VALUES('23', '4076', '0', 'Ressources', 'no');
INSERT INTO `wp_tg_resource_mapping` VALUES('24', '4076', '4109', '', 'no');
INSERT INTO `wp_tg_resource_mapping` VALUES('28', '4075', '0', 'Ressourcen', 'no');
/*!40000 ALTER TABLE `wp_tg_resource_mapping` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
