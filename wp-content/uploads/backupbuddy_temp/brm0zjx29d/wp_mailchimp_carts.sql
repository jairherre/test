CREATE TABLE `wp_mailchimp_carts` (  `id` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `user_id` int(11) DEFAULT NULL,  `cart` text COLLATE utf8mb4_unicode_520_ci NOT NULL,  `created_at` datetime NOT NULL,  PRIMARY KEY (`email`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_mailchimp_carts` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_mailchimp_carts` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
