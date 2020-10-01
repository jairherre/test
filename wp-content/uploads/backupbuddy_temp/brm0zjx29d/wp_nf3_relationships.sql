CREATE TABLE `wp_nf3_relationships` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `child_id` int(11) NOT NULL,  `child_type` longtext NOT NULL,  `parent_id` int(11) NOT NULL,  `parent_type` longtext NOT NULL,  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  `updated_at` datetime DEFAULT NULL,  UNIQUE KEY `id` (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40000 ALTER TABLE `wp_nf3_relationships` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_nf3_relationships` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
