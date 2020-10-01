CREATE TABLE `wp_csp3_subscribers` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `page_id` int(11) NOT NULL,  `email` varchar(255) DEFAULT NULL,  `fname` varchar(255) DEFAULT NULL,  `lname` varchar(255) DEFAULT NULL,  `ref_url` varchar(255) DEFAULT NULL,  `clicks` int(11) NOT NULL DEFAULT '0',  `conversions` int(11) NOT NULL DEFAULT '0',  `referrer` int(11) NOT NULL DEFAULT '0',  `confirmed` int(11) NOT NULL DEFAULT '0',  `optin_confirm` int(11) NOT NULL DEFAULT '0',  `ip` varchar(255) DEFAULT NULL,  `meta` text,  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40000 ALTER TABLE `wp_csp3_subscribers` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
/*!40000 ALTER TABLE `wp_csp3_subscribers` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
