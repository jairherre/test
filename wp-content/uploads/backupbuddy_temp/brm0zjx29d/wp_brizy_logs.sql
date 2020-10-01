CREATE TABLE `wp_brizy_logs` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `type` text NOT NULL,  `message` text NOT NULL,  `context` text NOT NULL,  `session_id` text NOT NULL,  `date` datetime NOT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40000 ALTER TABLE `wp_brizy_logs` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_brizy_logs` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
