CREATE TABLE `wp_woocommerce_shipping_zones` (  `zone_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `zone_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,  `zone_order` bigint(20) unsigned NOT NULL,  PRIMARY KEY (`zone_id`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zones` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_woocommerce_shipping_zones` VALUES('1', 'Italy', '0');
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zones` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
