CREATE TABLE `wp_failed_jobs` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `job` text COLLATE utf8mb4_unicode_520_ci NOT NULL,  `failed_at` datetime NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_failed_jobs` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_failed_jobs` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
