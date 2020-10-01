CREATE TABLE `wp_nf3_object_meta` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `parent_id` int(11) NOT NULL,  `key` longtext NOT NULL,  `value` longtext,  `meta_key` longtext,  `meta_value` longtext,  UNIQUE KEY `id` (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40000 ALTER TABLE `wp_nf3_object_meta` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_nf3_object_meta` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
