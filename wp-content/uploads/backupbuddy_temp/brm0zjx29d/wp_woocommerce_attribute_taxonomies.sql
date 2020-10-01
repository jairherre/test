CREATE TABLE `wp_woocommerce_attribute_taxonomies` (  `attribute_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `attribute_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,  `attribute_label` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,  `attribute_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,  `attribute_orderby` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,  `attribute_public` int(1) NOT NULL DEFAULT '1',  PRIMARY KEY (`attribute_id`),  KEY `attribute_name` (`attribute_name`(20))) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_woocommerce_attribute_taxonomies` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_woocommerce_attribute_taxonomies` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
