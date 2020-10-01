CREATE TABLE `wp_queue` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `job` text COLLATE utf8mb4_unicode_520_ci NOT NULL,  `attempts` tinyint(1) NOT NULL DEFAULT '0',  `locked` tinyint(1) NOT NULL DEFAULT '0',  `locked_at` datetime DEFAULT NULL,  `available_at` datetime NOT NULL,  `created_at` datetime NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_queue` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_queue` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
