CREATE TABLE `wp_tg_orders` (  `order_id` int(11) NOT NULL AUTO_INCREMENT,  `user_id` int(11) NOT NULL,  `payment_gateway` varchar(255) NOT NULL,  `payment_gateway_order_id` varchar(255) NOT NULL,  `added_on` datetime NOT NULL,  PRIMARY KEY (`order_id`)) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_tg_orders` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_tg_orders` VALUES('1', '2', 'manual', '4052', '2020-07-22 11:38:10');
INSERT INTO `wp_tg_orders` VALUES('4', '1', 'manual', '4074', '2020-07-24 07:34:43');
INSERT INTO `wp_tg_orders` VALUES('5', '2', 'manual', '4074', '2020-07-24 07:34:51');
INSERT INTO `wp_tg_orders` VALUES('6', '11', 'manual', '4074', '2020-07-24 07:34:57');
INSERT INTO `wp_tg_orders` VALUES('8', '12', 'manual', '4052', '2020-07-24 16:54:43');
INSERT INTO `wp_tg_orders` VALUES('11', '12', 'manual', '4089', '2020-07-26 15:04:10');
INSERT INTO `wp_tg_orders` VALUES('12', '11', 'manual', '4089', '2020-07-27 09:06:43');
INSERT INTO `wp_tg_orders` VALUES('13', '1', 'manual', '4089', '2020-07-27 09:06:54');
INSERT INTO `wp_tg_orders` VALUES('14', '2', 'manual', '4089', '2020-07-27 09:07:09');
INSERT INTO `wp_tg_orders` VALUES('15', '13', 'digistore24', 'CDNPJECT', '2020-08-26 15:06:36');
INSERT INTO `wp_tg_orders` VALUES('16', '15', 'digistore24', '9JMVCZ76', '2020-08-28 07:25:36');
INSERT INTO `wp_tg_orders` VALUES('17', '16', 'digistore24', '935RP7EW', '2020-08-28 07:45:07');
INSERT INTO `wp_tg_orders` VALUES('18', '17', 'copecart', 'XB5454ju', '2020-08-28 07:51:06');
INSERT INTO `wp_tg_orders` VALUES('19', '18', 'digistore24', '4SQ6Y6AC', '2020-08-28 07:51:22');
/*!40000 ALTER TABLE `wp_tg_orders` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
