CREATE TABLE `wp_podsrel` (  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `pod_id` int(10) unsigned DEFAULT NULL,  `field_id` int(10) unsigned DEFAULT NULL,  `item_id` bigint(20) unsigned DEFAULT NULL,  `related_pod_id` int(10) unsigned DEFAULT NULL,  `related_field_id` int(10) unsigned DEFAULT NULL,  `related_item_id` bigint(20) unsigned DEFAULT NULL,  `weight` smallint(5) unsigned DEFAULT '0',  PRIMARY KEY (`id`),  KEY `field_item_idx` (`field_id`,`item_id`),  KEY `rel_field_rel_item_idx` (`related_field_id`,`related_item_id`),  KEY `field_rel_item_idx` (`field_id`,`related_item_id`),  KEY `rel_field_item_idx` (`related_field_id`,`item_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_podsrel` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_podsrel` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
