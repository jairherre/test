CREATE TABLE `wp_nf3_objects` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `type` longtext,  `title` longtext,  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  `updated_at` datetime DEFAULT NULL,  `object_title` longtext,  UNIQUE KEY `id` (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40000 ALTER TABLE `wp_nf3_objects` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_nf3_objects` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
