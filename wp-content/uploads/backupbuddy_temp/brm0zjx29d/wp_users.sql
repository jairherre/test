CREATE TABLE `wp_users` (  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',  `user_status` int(11) NOT NULL DEFAULT '0',  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',  PRIMARY KEY (`ID`),  KEY `user_login_key` (`user_login`),  KEY `user_nicename` (`user_nicename`),  KEY `user_email` (`user_email`)) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40000 ALTER TABLE `wp_users` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_users` VALUES('1', 'julius.miribung@gmail.com', '$P$BhgviVrRuo50XsFHvEDxdxuzzC.G5C.', 'juliusmiribung', 'julius.miribung@gmail.com', '', '2018-08-10 20:14:09', '', '0', 'Juliusmiribung');
INSERT INTO `wp_users` VALUES('2', 'Avi', '$P$BIK2n6OOu/6mnsq.J6Hpsaa1hzeII1/', 'avi', 'demoforafo@gmail.com', '', '2018-08-10 20:26:33', '', '0', 'Avi');
INSERT INTO `wp_users` VALUES('5', 'Anna', '$P$BuSVUprrM5tPLgpSsnbCoEHDdcWgnp0', 'anna', 'goncharenkoadamivna@gmail.com', '', '2018-12-19 08:12:01', '1545207121:$P$BqC3Gu8yv.XWS4hcpXVIocqf4rSph3.', '0', 'Anna');
INSERT INTO `wp_users` VALUES('8', 'testaiosjdoiahe@test.com', '$P$BiQxkW6Fk3Y2hogPWZft4YMxGCy3Dl0', 'testaiosjdoiahetest-com', 'testaiosjdoiahe@test.com', '', '2020-01-16 08:24:09', '', '0', 'testaiosjdoiahe@test.com');
INSERT INTO `wp_users` VALUES('10', 'uuuuiiii@test.com', '$P$BAvB1xXlM0OTzdFZUGTrKH3Wa9bkbb.', 'uuuuiiiitest-com', 'uuuuiiii@test.com', '', '2020-01-16 11:15:07', '', '0', 'uuuuiiii@test.com');
INSERT INTO `wp_users` VALUES('11', 'Obi', '$P$BiEkc/t2KmIhpp.nJj5EfvEoRxDL6m0', 'obi', 'obiplabon@gmail.com', '', '2020-05-11 14:23:34', '', '0', 'Obi');
INSERT INTO `wp_users` VALUES('12', 'talk.souvik@gmail.com', '$P$BQZqZPi6Gzs5WC1mEDsbV9ekL8cSXf0', 'talk-souvikgmail-com', 'talk.souvik@gmail.com', '', '2020-07-22 11:24:13', '', '0', 'Souvik');
INSERT INTO `wp_users` VALUES('13', 'mail2jul334892736@gmail.com', '$P$BA1xcKqi84mFhaMP/Y8AzUAAac7aCF.', 'mail2jul334892736gmail-com', 'mail2jul+334892736@gmail.com', '', '2020-08-26 15:06:36', '', '0', 'Jul 2 M2');
INSERT INTO `wp_users` VALUES('14', 'Oleksandr', '$P$BDFNKjxwN/eYOT2TzaqQV3u8k4afS20', 'oleksandr', 'dev2.perfectorium@gmail.com', '', '2020-08-27 14:42:11', '', '0', 'Oleksandr');
INSERT INTO `wp_users` VALUES('15', 'mail2jul687@gmail.com', '$P$Bc1ka6.Z3JOmcYvJZo.sUk60SwLTyi/', 'mail2jul687gmail-com', 'mail2jul+687@gmail.com', '', '2020-08-28 07:25:36', '', '0', 'ahds ahsiudh');
INSERT INTO `wp_users` VALUES('16', 'mail2jul98729834@gmail.com', '$P$Bn7BZxwaYv8Bpkd3K/Z8pTxBjQXCJb0', 'mail2jul98729834gmail-com', 'mail2jul+98729834@gmail.com', '', '2020-08-28 07:45:07', '', '0', 'asdasd sdfsdf');
INSERT INTO `wp_users` VALUES('17', 'mail2julcctest1@gmail.com', '$P$BRU1ugCPH9EZVWyAXzeQxVxRAIJdyy.', 'mail2julcctest1gmail-com', 'mail2jul+cctest1@gmail.com', '', '2020-08-28 07:51:06', '', '0', 'Julu sfsdfsd');
INSERT INTO `wp_users` VALUES('18', 'mail2juldstest1@gmail.com', '$P$BxVJ50DpW2kgs0EYzbMxiYRZZ6u30K1', 'mail2juldstest1gmail-com', 'mail2jul+dstest1@gmail.com', '', '2020-08-28 07:51:22', '', '0', 'asdasd asdfasf');
/*!40000 ALTER TABLE `wp_users` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;