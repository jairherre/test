CREATE TABLE `wp_woocommerce_order_itemmeta` (  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `order_item_id` bigint(20) unsigned NOT NULL,  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,  `meta_value` longtext COLLATE utf8mb4_unicode_ci,  PRIMARY KEY (`meta_id`),  KEY `order_item_id` (`order_item_id`),  KEY `meta_key` (`meta_key`(32))) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_woocommerce_order_itemmeta` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('1', '1', '_product_id', '279');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('2', '1', '_variation_id', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('3', '1', '_qty', '1');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('4', '1', '_tax_class', 'zero-rate');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('5', '1', '_line_subtotal', '5');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('6', '1', '_line_subtotal_tax', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('7', '1', '_line_total', '5');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('8', '1', '_line_tax', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('9', '1', '_line_tax_data', 'a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('10', '2', '_product_id', '279');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('11', '2', '_variation_id', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('12', '2', '_qty', '1');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('13', '2', '_tax_class', 'zero-rate');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('14', '2', '_line_subtotal', '5');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('15', '2', '_line_subtotal_tax', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('16', '2', '_line_total', '5');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('17', '2', '_line_tax', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('18', '2', '_line_tax_data', 'a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('19', '3', '_product_id', '279');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('20', '3', '_variation_id', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('21', '3', '_qty', '1');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('22', '3', '_tax_class', 'zero-rate');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('23', '3', '_line_subtotal', '5');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('24', '3', '_line_subtotal_tax', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('25', '3', '_line_total', '5');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('26', '3', '_line_tax', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('27', '3', '_line_tax_data', 'a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('28', '4', '_product_id', '279');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('29', '4', '_variation_id', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('30', '4', '_qty', '1');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('31', '4', '_tax_class', 'zero-rate');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('32', '4', '_line_subtotal', '5');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('33', '4', '_line_subtotal_tax', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('34', '4', '_line_total', '5');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('35', '4', '_line_tax', '0');
INSERT INTO `wp_woocommerce_order_itemmeta` VALUES('36', '4', '_line_tax_data', 'a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}');
/*!40000 ALTER TABLE `wp_woocommerce_order_itemmeta` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
