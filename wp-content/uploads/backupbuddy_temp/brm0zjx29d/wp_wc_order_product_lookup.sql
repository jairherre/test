CREATE TABLE `wp_wc_order_product_lookup` (  `order_item_id` bigint(20) unsigned NOT NULL,  `order_id` bigint(20) unsigned NOT NULL,  `product_id` bigint(20) unsigned NOT NULL,  `variation_id` bigint(20) unsigned NOT NULL,  `customer_id` bigint(20) unsigned DEFAULT NULL,  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `product_qty` int(11) NOT NULL,  `product_net_revenue` double NOT NULL DEFAULT '0',  `product_gross_revenue` double NOT NULL DEFAULT '0',  `coupon_amount` double NOT NULL DEFAULT '0',  `tax_amount` double NOT NULL DEFAULT '0',  `shipping_amount` double NOT NULL DEFAULT '0',  `shipping_tax_amount` double NOT NULL DEFAULT '0',  PRIMARY KEY (`order_item_id`),  KEY `order_id` (`order_id`),  KEY `product_id` (`product_id`),  KEY `customer_id` (`customer_id`),  KEY `date_created` (`date_created`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_wc_order_product_lookup` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_wc_order_product_lookup` VALUES('1', '490', '279', '0', '1', '2019-10-21 20:48:39', '1', '5', '5', '0', '0', '0', '0');
INSERT INTO `wp_wc_order_product_lookup` VALUES('2', '542', '279', '0', '1', '2019-10-24 09:37:47', '1', '5', '5', '0', '0', '0', '0');
INSERT INTO `wp_wc_order_product_lookup` VALUES('3', '1434', '279', '0', '2', '2019-12-06 09:58:51', '1', '5', '5', '0', '0', '0', '0');
INSERT INTO `wp_wc_order_product_lookup` VALUES('4', '1437', '279', '0', '2', '2019-12-06 10:01:53', '1', '5', '5', '0', '0', '0', '0');
/*!40000 ALTER TABLE `wp_wc_order_product_lookup` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;