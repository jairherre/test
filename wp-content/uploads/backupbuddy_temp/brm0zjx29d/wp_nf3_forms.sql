CREATE TABLE `wp_nf3_forms` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `title` longtext,  `key` longtext,  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  `updated_at` datetime DEFAULT NULL,  `views` int(11) DEFAULT NULL,  `subs` int(11) DEFAULT NULL,  `form_title` longtext,  `default_label_pos` varchar(15) DEFAULT NULL,  `show_title` bit(1) DEFAULT NULL,  `clear_complete` bit(1) DEFAULT NULL,  `hide_complete` bit(1) DEFAULT NULL,  `logged_in` bit(1) DEFAULT NULL,  `seq_num` int(11) DEFAULT NULL,  UNIQUE KEY `id` (`id`)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40000 ALTER TABLE `wp_nf3_forms` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_nf3_forms` VALUES('1', 'Contact Me', NULL, '2019-03-16 22:25:52', '2019-03-16 22:25:52', NULL, NULL, 'Contact Me', 'above', '1', '1', '1', '0', NULL);
INSERT INTO `wp_nf3_forms` VALUES('2', 'Test Form', NULL, '2019-03-16 22:27:18', '2019-03-16 22:27:18', NULL, NULL, 'Test Form', 'above', '1', '1', '1', '0', NULL);
/*!40000 ALTER TABLE `wp_nf3_forms` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
