CREATE TABLE `wp_lms_resource_mapping` (  `m_id` int(11) NOT NULL AUTO_INCREMENT,  `l_id` int(11) NOT NULL,  `r_id` int(11) NOT NULL,  `r_title` varchar(255) NOT NULL,  `r_highlight` enum('no','yes') NOT NULL DEFAULT 'no',  PRIMARY KEY (`m_id`)) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_lms_resource_mapping` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_lms_resource_mapping` VALUES('36', '182', '0', 'neu', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('37', '182', '107', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('42', '8', '0', 'Title 1', 'yes');
INSERT INTO `wp_lms_resource_mapping` VALUES('43', '8', '138', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('44', '8', '0', 'Title 2', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('45', '8', '113', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('50', '19', '0', 'Club', 'yes');
INSERT INTO `wp_lms_resource_mapping` VALUES('51', '19', '107', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('52', '19', '0', 'Gute Links', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('53', '19', '112', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('56', '299', '0', 'About Video Upload', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('57', '299', '300', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('58', '303', '0', 'Read this', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('59', '303', '304', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('60', '307', '0', 'About Video Upload', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('61', '226', '0', 'Ressource Test', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('62', '226', '309', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('70', '2359', '0', 'Ressources', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('71', '2359', '113', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('82', '3284', '0', 'Ressourcen', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('83', '3284', '3995', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('84', '3284', '3998', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('85', '3284', '309', '', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('90', '296', '0', 'Important Links', 'no');
INSERT INTO `wp_lms_resource_mapping` VALUES('91', '296', '297', '', 'no');
/*!40000 ALTER TABLE `wp_lms_resource_mapping` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
