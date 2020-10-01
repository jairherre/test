CREATE TABLE `wp_toolset_post_guid_id` (  `guid` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',  `post_id` bigint(20) NOT NULL,  UNIQUE KEY `post_id` (`post_id`),  KEY `guid` (`guid`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_toolset_post_guid_id` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_toolset_post_guid_id` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
