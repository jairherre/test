CREATE TABLE `wp_tcb_api_error_log` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `date` datetime DEFAULT NULL,  `error_message` varchar(400) DEFAULT NULL,  `api_data` text,  `connection` varchar(64) DEFAULT NULL,  `list_id` varchar(255) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_tcb_api_error_log` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_tcb_api_error_log` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
