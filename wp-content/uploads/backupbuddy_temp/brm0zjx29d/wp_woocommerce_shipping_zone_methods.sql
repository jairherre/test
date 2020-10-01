CREATE TABLE `wp_woocommerce_shipping_zone_methods` (  `zone_id` bigint(20) unsigned NOT NULL,  `instance_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `method_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,  `method_order` bigint(20) unsigned NOT NULL,  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',  PRIMARY KEY (`instance_id`)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zone_methods` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_woocommerce_shipping_zone_methods` VALUES('1', '1', 'flat_rate', '1', '1');
INSERT INTO `wp_woocommerce_shipping_zone_methods` VALUES('0', '2', 'flat_rate', '1', '1');
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zone_methods` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
