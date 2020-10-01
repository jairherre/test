CREATE TABLE `wp_term_taxonomy` (  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',  `count` bigint(20) NOT NULL DEFAULT '0',  PRIMARY KEY (`term_taxonomy_id`),  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),  KEY `taxonomy` (`taxonomy`)) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_term_taxonomy` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_term_taxonomy` VALUES('1', '1', 'category', '', '0', '1');
INSERT INTO `wp_term_taxonomy` VALUES('2', '2', 'product_type', '', '0', '1');
INSERT INTO `wp_term_taxonomy` VALUES('3', '3', 'product_type', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('4', '4', 'product_type', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('5', '5', 'product_type', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('6', '6', 'product_visibility', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('7', '7', 'product_visibility', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('8', '8', 'product_visibility', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('9', '9', 'product_visibility', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('10', '10', 'product_visibility', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('11', '11', 'product_visibility', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('12', '12', 'product_visibility', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('13', '13', 'product_visibility', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('14', '14', 'product_visibility', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('15', '15', 'product_cat', '', '0', '1');
INSERT INTO `wp_term_taxonomy` VALUES('16', '16', 'cartflows_step_type', '', '0', '1');
INSERT INTO `wp_term_taxonomy` VALUES('17', '17', 'cartflows_step_type', '', '0', '1');
INSERT INTO `wp_term_taxonomy` VALUES('18', '18', 'cartflows_step_type', '', '0', '1');
INSERT INTO `wp_term_taxonomy` VALUES('19', '19', 'cartflows_step_type', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('20', '20', 'cartflows_step_type', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('21', '21', 'cartflows_step_flow', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('22', '22', 'tcb_symbols_tax', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('23', '23', 'tcb_symbols_tax', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('24', '24', 'cartflows_step_flow', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('25', '25', 'cartflows_step_flow', '', '0', '3');
INSERT INTO `wp_term_taxonomy` VALUES('26', '26', 'nav_menu', '', '0', '4');
INSERT INTO `wp_term_taxonomy` VALUES('27', '27', 'lms_course_category', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('28', '28', 'lms_course_category', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('29', '29', 'lms_course_category', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('30', '30', 'action-group', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('31', '31', 'action-group', '', '0', '714');
INSERT INTO `wp_term_taxonomy` VALUES('32', '32', 'action-group', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('33', '33', 'action-group', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('34', '34', 'cartflows_step_type', '', '0', '0');
INSERT INTO `wp_term_taxonomy` VALUES('35', '35', 'elementor_library_type', '', '0', '1');
INSERT INTO `wp_term_taxonomy` VALUES('36', '36', 'elementor_library_type', '', '0', '3');
INSERT INTO `wp_term_taxonomy` VALUES('37', '37', 'tg_course_category', '', '0', '1');
INSERT INTO `wp_term_taxonomy` VALUES('38', '38', 'tg_course_category', '', '0', '0');
/*!40000 ALTER TABLE `wp_term_taxonomy` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
