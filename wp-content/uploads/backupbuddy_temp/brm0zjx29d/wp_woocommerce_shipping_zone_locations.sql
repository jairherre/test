CREATE TABLE `wp_woocommerce_shipping_zone_locations` (  `location_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `zone_id` bigint(20) unsigned NOT NULL,  `location_code` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,  `location_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,  PRIMARY KEY (`location_id`),  KEY `location_id` (`location_id`),  KEY `location_type_code` (`location_type`(10),`location_code`(20))) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zone_locations` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_woocommerce_shipping_zone_locations` VALUES('1', '1', 'IT', 'country');
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zone_locations` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
