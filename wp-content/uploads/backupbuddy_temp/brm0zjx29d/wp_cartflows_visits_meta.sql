CREATE TABLE `wp_cartflows_visits_meta` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `visit_id` bigint(20) NOT NULL,  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,  `meta_value` longtext COLLATE utf8mb4_unicode_ci,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_cartflows_visits_meta` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_cartflows_visits_meta` VALUES('1', '1', 'user_ip_address', '127.0.0.1, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('2', '1', 'http_referer', 'https://127.0.0.1/checkout-page-2/');
INSERT INTO `wp_cartflows_visits_meta` VALUES('3', '2', 'user_ip_address', '79.40.69.152, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('4', '2', 'http_referer', 'https://lms.engaging-people.com/wp-admin/post.php?post=250&action=edit');
INSERT INTO `wp_cartflows_visits_meta` VALUES('5', '3', 'user_ip_address', '79.40.69.152, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('6', '3', 'http_referer', 'https://lms.engaging-people.com/landing-page-2/');
INSERT INTO `wp_cartflows_visits_meta` VALUES('7', '4', 'user_ip_address', '127.0.0.1, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('8', '4', 'http_referer', 'https://127.0.0.1/checkout-page-2/');
INSERT INTO `wp_cartflows_visits_meta` VALUES('9', '5', 'user_ip_address', '79.40.69.152, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('10', '5', 'http_referer', 'https://lms.engaging-people.com/wp-admin/post.php?post=269&action=edit');
INSERT INTO `wp_cartflows_visits_meta` VALUES('11', '6', 'user_ip_address', '79.40.69.152, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('12', '6', 'http_referer', 'https://lms.engaging-people.com/wp-admin/post.php?post=269&action=elementor');
INSERT INTO `wp_cartflows_visits_meta` VALUES('13', '7', 'user_ip_address', '79.40.69.152, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('14', '7', 'http_referer', 'https://lms.engaging-people.com/wp-admin/post.php?post=269&action=elementor');
INSERT INTO `wp_cartflows_visits_meta` VALUES('15', '8', 'user_ip_address', '127.0.0.1, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('16', '8', 'http_referer', 'https://127.0.0.1/checkout-page-3/');
INSERT INTO `wp_cartflows_visits_meta` VALUES('17', '9', 'user_ip_address', '127.0.0.1, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('18', '9', 'http_referer', 'https://127.0.0.1/checkout-page-3/');
INSERT INTO `wp_cartflows_visits_meta` VALUES('19', '10', 'user_ip_address', '79.40.69.152, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('20', '10', 'http_referer', 'https://lms.engaging-people.com/wp-admin/edit.php?post_type=cartflows_flow&paged=1&ids=250%2C70');
INSERT INTO `wp_cartflows_visits_meta` VALUES('21', '11', 'user_ip_address', '79.40.69.152, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('22', '11', 'http_referer', 'https://lms.engaging-people.com/landing-page-3/');
INSERT INTO `wp_cartflows_visits_meta` VALUES('23', '12', 'user_ip_address', '79.40.69.152, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('24', '12', 'http_referer', 'https://lms.engaging-people.com/wp-admin/post.php?post=284&action=elementor');
INSERT INTO `wp_cartflows_visits_meta` VALUES('25', '13', 'user_ip_address', '79.9.75.123, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('26', '13', 'http_referer', 'https://lms.engaging-people.com/wp-admin/post.php?post=282&action=edit');
INSERT INTO `wp_cartflows_visits_meta` VALUES('27', '14', 'user_ip_address', '79.9.75.123, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('28', '14', 'http_referer', 'https://lms.engaging-people.com/landing-page-3/');
INSERT INTO `wp_cartflows_visits_meta` VALUES('29', '15', 'user_ip_address', '79.9.75.123, 127.0.0.1');
INSERT INTO `wp_cartflows_visits_meta` VALUES('30', '15', 'http_referer', 'https://lms.engaging-people.com/wp-admin/post.php?post=284&action=elementor');
/*!40000 ALTER TABLE `wp_cartflows_visits_meta` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;