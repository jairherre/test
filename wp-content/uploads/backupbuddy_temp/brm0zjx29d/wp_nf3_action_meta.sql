CREATE TABLE `wp_nf3_action_meta` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `parent_id` int(11) NOT NULL,  `key` longtext NOT NULL,  `value` longtext,  `meta_key` longtext,  `meta_value` longtext,  UNIQUE KEY `id` (`id`)) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4;
/*!40000 ALTER TABLE `wp_nf3_action_meta` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_nf3_action_meta` VALUES('1', '1', 'objectType', 'Action', 'objectType', 'Action');
INSERT INTO `wp_nf3_action_meta` VALUES('2', '1', 'objectDomain', 'actions', 'objectDomain', 'actions');
INSERT INTO `wp_nf3_action_meta` VALUES('3', '1', 'editActive', '', 'editActive', '');
INSERT INTO `wp_nf3_action_meta` VALUES('4', '1', 'conditions', 'a:6:{s:9:\"collapsed\";s:0:\"\";s:7:\"process\";s:1:\"1\";s:9:\"connector\";s:3:\"all\";s:4:\"when\";a:1:{i:0;a:6:{s:9:\"connector\";s:3:\"AND\";s:3:\"key\";s:0:\"\";s:10:\"comparator\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"when\";}}s:4:\"then\";a:1:{i:0;a:5:{s:3:\"key\";s:0:\"\";s:7:\"trigger\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"then\";}}s:4:\"else\";a:0:{}}', 'conditions', 'a:6:{s:9:\"collapsed\";s:0:\"\";s:7:\"process\";s:1:\"1\";s:9:\"connector\";s:3:\"all\";s:4:\"when\";a:1:{i:0;a:6:{s:9:\"connector\";s:3:\"AND\";s:3:\"key\";s:0:\"\";s:10:\"comparator\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"when\";}}s:4:\"then\";a:1:{i:0;a:5:{s:3:\"key\";s:0:\"\";s:7:\"trigger\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"then\";}}s:4:\"else\";a:0:{}}');
INSERT INTO `wp_nf3_action_meta` VALUES('5', '1', 'payment_gateways', '', 'payment_gateways', '');
INSERT INTO `wp_nf3_action_meta` VALUES('6', '1', 'payment_total', '', 'payment_total', '');
INSERT INTO `wp_nf3_action_meta` VALUES('7', '1', 'tag', '', 'tag', '');
INSERT INTO `wp_nf3_action_meta` VALUES('8', '1', 'to', '', 'to', '');
INSERT INTO `wp_nf3_action_meta` VALUES('9', '1', 'email_subject', '', 'email_subject', '');
INSERT INTO `wp_nf3_action_meta` VALUES('10', '1', 'email_message', '', 'email_message', '');
INSERT INTO `wp_nf3_action_meta` VALUES('11', '1', 'from_name', '', 'from_name', '');
INSERT INTO `wp_nf3_action_meta` VALUES('12', '1', 'from_address', '', 'from_address', '');
INSERT INTO `wp_nf3_action_meta` VALUES('13', '1', 'reply_to', '', 'reply_to', '');
INSERT INTO `wp_nf3_action_meta` VALUES('14', '1', 'email_format', 'html', 'email_format', 'html');
INSERT INTO `wp_nf3_action_meta` VALUES('15', '1', 'cc', '', 'cc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('16', '1', 'bcc', '', 'bcc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('17', '1', 'attach_csv', '', 'attach_csv', '');
INSERT INTO `wp_nf3_action_meta` VALUES('18', '1', 'redirect_url', '', 'redirect_url', '');
INSERT INTO `wp_nf3_action_meta` VALUES('19', '1', 'email_message_plain', '', 'email_message_plain', '');
INSERT INTO `wp_nf3_action_meta` VALUES('20', '2', 'to', '{field:email}', 'to', '{field:email}');
INSERT INTO `wp_nf3_action_meta` VALUES('21', '2', 'subject', 'This is an email action.', 'subject', 'This is an email action.');
INSERT INTO `wp_nf3_action_meta` VALUES('22', '2', 'message', 'Hello, Ninja Forms!', 'message', 'Hello, Ninja Forms!');
INSERT INTO `wp_nf3_action_meta` VALUES('23', '2', 'objectType', 'Action', 'objectType', 'Action');
INSERT INTO `wp_nf3_action_meta` VALUES('24', '2', 'objectDomain', 'actions', 'objectDomain', 'actions');
INSERT INTO `wp_nf3_action_meta` VALUES('25', '2', 'editActive', '', 'editActive', '');
INSERT INTO `wp_nf3_action_meta` VALUES('26', '2', 'conditions', 'a:6:{s:9:\"collapsed\";s:0:\"\";s:7:\"process\";s:1:\"1\";s:9:\"connector\";s:3:\"all\";s:4:\"when\";a:0:{}s:4:\"then\";a:1:{i:0;a:5:{s:3:\"key\";s:0:\"\";s:7:\"trigger\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"then\";}}s:4:\"else\";a:0:{}}', 'conditions', 'a:6:{s:9:\"collapsed\";s:0:\"\";s:7:\"process\";s:1:\"1\";s:9:\"connector\";s:3:\"all\";s:4:\"when\";a:0:{}s:4:\"then\";a:1:{i:0;a:5:{s:3:\"key\";s:0:\"\";s:7:\"trigger\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"then\";}}s:4:\"else\";a:0:{}}');
INSERT INTO `wp_nf3_action_meta` VALUES('27', '2', 'payment_gateways', '', 'payment_gateways', '');
INSERT INTO `wp_nf3_action_meta` VALUES('28', '2', 'payment_total', '', 'payment_total', '');
INSERT INTO `wp_nf3_action_meta` VALUES('29', '2', 'tag', '', 'tag', '');
INSERT INTO `wp_nf3_action_meta` VALUES('30', '2', 'email_subject', 'Submission Confirmation ', 'email_subject', 'Submission Confirmation ');
INSERT INTO `wp_nf3_action_meta` VALUES('31', '2', 'email_message', '<p>{all_fields_table}<br></p>', 'email_message', '<p>{all_fields_table}<br></p>');
INSERT INTO `wp_nf3_action_meta` VALUES('32', '2', 'from_name', '', 'from_name', '');
INSERT INTO `wp_nf3_action_meta` VALUES('33', '2', 'from_address', '', 'from_address', '');
INSERT INTO `wp_nf3_action_meta` VALUES('34', '2', 'reply_to', '', 'reply_to', '');
INSERT INTO `wp_nf3_action_meta` VALUES('35', '2', 'email_format', 'html', 'email_format', 'html');
INSERT INTO `wp_nf3_action_meta` VALUES('36', '2', 'cc', '', 'cc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('37', '2', 'bcc', '', 'bcc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('38', '2', 'attach_csv', '', 'attach_csv', '');
INSERT INTO `wp_nf3_action_meta` VALUES('39', '2', 'email_message_plain', '', 'email_message_plain', '');
INSERT INTO `wp_nf3_action_meta` VALUES('40', '3', 'objectType', 'Action', 'objectType', 'Action');
INSERT INTO `wp_nf3_action_meta` VALUES('41', '3', 'objectDomain', 'actions', 'objectDomain', 'actions');
INSERT INTO `wp_nf3_action_meta` VALUES('42', '3', 'editActive', '', 'editActive', '');
INSERT INTO `wp_nf3_action_meta` VALUES('43', '3', 'conditions', 'a:6:{s:9:\"collapsed\";s:0:\"\";s:7:\"process\";s:1:\"1\";s:9:\"connector\";s:3:\"all\";s:4:\"when\";a:1:{i:0;a:6:{s:9:\"connector\";s:3:\"AND\";s:3:\"key\";s:0:\"\";s:10:\"comparator\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"when\";}}s:4:\"then\";a:1:{i:0;a:5:{s:3:\"key\";s:0:\"\";s:7:\"trigger\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"then\";}}s:4:\"else\";a:0:{}}', 'conditions', 'a:6:{s:9:\"collapsed\";s:0:\"\";s:7:\"process\";s:1:\"1\";s:9:\"connector\";s:3:\"all\";s:4:\"when\";a:1:{i:0;a:6:{s:9:\"connector\";s:3:\"AND\";s:3:\"key\";s:0:\"\";s:10:\"comparator\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"when\";}}s:4:\"then\";a:1:{i:0;a:5:{s:3:\"key\";s:0:\"\";s:7:\"trigger\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"then\";}}s:4:\"else\";a:0:{}}');
INSERT INTO `wp_nf3_action_meta` VALUES('44', '3', 'payment_gateways', '', 'payment_gateways', '');
INSERT INTO `wp_nf3_action_meta` VALUES('45', '3', 'payment_total', '', 'payment_total', '');
INSERT INTO `wp_nf3_action_meta` VALUES('46', '3', 'tag', '', 'tag', '');
INSERT INTO `wp_nf3_action_meta` VALUES('47', '3', 'to', '{system:admin_email}', 'to', '{system:admin_email}');
INSERT INTO `wp_nf3_action_meta` VALUES('48', '3', 'email_subject', 'New message from {field:name}', 'email_subject', 'New message from {field:name}');
INSERT INTO `wp_nf3_action_meta` VALUES('49', '3', 'email_message', '<p>{field:message}</p><p>-{field:name} ( {field:email} )</p>', 'email_message', '<p>{field:message}</p><p>-{field:name} ( {field:email} )</p>');
INSERT INTO `wp_nf3_action_meta` VALUES('50', '3', 'from_name', '', 'from_name', '');
INSERT INTO `wp_nf3_action_meta` VALUES('51', '3', 'from_address', '', 'from_address', '');
INSERT INTO `wp_nf3_action_meta` VALUES('52', '3', 'reply_to', '{field:email}', 'reply_to', '{field:email}');
INSERT INTO `wp_nf3_action_meta` VALUES('53', '3', 'email_format', 'html', 'email_format', 'html');
INSERT INTO `wp_nf3_action_meta` VALUES('54', '3', 'cc', '', 'cc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('55', '3', 'bcc', '', 'bcc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('56', '3', 'attach_csv', '0', 'attach_csv', '0');
INSERT INTO `wp_nf3_action_meta` VALUES('57', '3', 'email_message_plain', '', 'email_message_plain', '');
INSERT INTO `wp_nf3_action_meta` VALUES('58', '4', 'message', 'Thank you {field:name} for filling out my form!', 'message', 'Thank you {field:name} for filling out my form!');
INSERT INTO `wp_nf3_action_meta` VALUES('59', '4', 'objectType', 'Action', 'objectType', 'Action');
INSERT INTO `wp_nf3_action_meta` VALUES('60', '4', 'objectDomain', 'actions', 'objectDomain', 'actions');
INSERT INTO `wp_nf3_action_meta` VALUES('61', '4', 'editActive', '', 'editActive', '');
INSERT INTO `wp_nf3_action_meta` VALUES('62', '4', 'conditions', 'a:6:{s:9:\"collapsed\";s:0:\"\";s:7:\"process\";s:1:\"1\";s:9:\"connector\";s:3:\"all\";s:4:\"when\";a:1:{i:0;a:6:{s:9:\"connector\";s:3:\"AND\";s:3:\"key\";s:0:\"\";s:10:\"comparator\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"when\";}}s:4:\"then\";a:1:{i:0;a:5:{s:3:\"key\";s:0:\"\";s:7:\"trigger\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"then\";}}s:4:\"else\";a:0:{}}', 'conditions', 'a:6:{s:9:\"collapsed\";s:0:\"\";s:7:\"process\";s:1:\"1\";s:9:\"connector\";s:3:\"all\";s:4:\"when\";a:1:{i:0;a:6:{s:9:\"connector\";s:3:\"AND\";s:3:\"key\";s:0:\"\";s:10:\"comparator\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"when\";}}s:4:\"then\";a:1:{i:0;a:5:{s:3:\"key\";s:0:\"\";s:7:\"trigger\";s:0:\"\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:5:\"field\";s:9:\"modelType\";s:4:\"then\";}}s:4:\"else\";a:0:{}}');
INSERT INTO `wp_nf3_action_meta` VALUES('63', '4', 'payment_gateways', '', 'payment_gateways', '');
INSERT INTO `wp_nf3_action_meta` VALUES('64', '4', 'payment_total', '', 'payment_total', '');
INSERT INTO `wp_nf3_action_meta` VALUES('65', '4', 'tag', '', 'tag', '');
INSERT INTO `wp_nf3_action_meta` VALUES('66', '4', 'to', '', 'to', '');
INSERT INTO `wp_nf3_action_meta` VALUES('67', '4', 'email_subject', '', 'email_subject', '');
INSERT INTO `wp_nf3_action_meta` VALUES('68', '4', 'email_message', '', 'email_message', '');
INSERT INTO `wp_nf3_action_meta` VALUES('69', '4', 'from_name', '', 'from_name', '');
INSERT INTO `wp_nf3_action_meta` VALUES('70', '4', 'from_address', '', 'from_address', '');
INSERT INTO `wp_nf3_action_meta` VALUES('71', '4', 'reply_to', '', 'reply_to', '');
INSERT INTO `wp_nf3_action_meta` VALUES('72', '4', 'email_format', 'html', 'email_format', 'html');
INSERT INTO `wp_nf3_action_meta` VALUES('73', '4', 'cc', '', 'cc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('74', '4', 'bcc', '', 'bcc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('75', '4', 'attach_csv', '', 'attach_csv', '');
INSERT INTO `wp_nf3_action_meta` VALUES('76', '4', 'redirect_url', '', 'redirect_url', '');
INSERT INTO `wp_nf3_action_meta` VALUES('77', '4', 'success_msg', '<p>Form submitted successfully.</p><p>A confirmation email was sent to {field:email}.</p>', 'success_msg', '<p>Form submitted successfully.</p><p>A confirmation email was sent to {field:email}.</p>');
INSERT INTO `wp_nf3_action_meta` VALUES('78', '4', 'email_message_plain', '', 'email_message_plain', '');
INSERT INTO `wp_nf3_action_meta` VALUES('79', '5', 'objectType', 'Action', 'objectType', 'Action');
INSERT INTO `wp_nf3_action_meta` VALUES('80', '5', 'objectDomain', 'actions', 'objectDomain', 'actions');
INSERT INTO `wp_nf3_action_meta` VALUES('81', '5', 'editActive', '', 'editActive', '');
INSERT INTO `wp_nf3_action_meta` VALUES('82', '5', 'message', 'Ihr Formular wurde erfolgreich gesendet.', 'message', 'Ihr Formular wurde erfolgreich gesendet.');
INSERT INTO `wp_nf3_action_meta` VALUES('83', '5', 'order', '1', 'order', '1');
INSERT INTO `wp_nf3_action_meta` VALUES('84', '5', 'payment_gateways', '', 'payment_gateways', '');
INSERT INTO `wp_nf3_action_meta` VALUES('85', '5', 'payment_total', '0', 'payment_total', '0');
INSERT INTO `wp_nf3_action_meta` VALUES('86', '5', 'tag', '', 'tag', '');
INSERT INTO `wp_nf3_action_meta` VALUES('87', '5', 'to', '{wp:admin_email}', 'to', '{wp:admin_email}');
INSERT INTO `wp_nf3_action_meta` VALUES('88', '5', 'reply_to', '', 'reply_to', '');
INSERT INTO `wp_nf3_action_meta` VALUES('89', '5', 'email_subject', 'Ninja Forms-Einreichung', 'email_subject', 'Ninja Forms-Einreichung');
INSERT INTO `wp_nf3_action_meta` VALUES('90', '5', 'email_message', '{fields_table}', 'email_message', '{fields_table}');
INSERT INTO `wp_nf3_action_meta` VALUES('91', '5', 'email_message_plain', '', 'email_message_plain', '');
INSERT INTO `wp_nf3_action_meta` VALUES('92', '5', 'from_name', '', 'from_name', '');
INSERT INTO `wp_nf3_action_meta` VALUES('93', '5', 'from_address', '', 'from_address', '');
INSERT INTO `wp_nf3_action_meta` VALUES('94', '5', 'email_format', 'html', 'email_format', 'html');
INSERT INTO `wp_nf3_action_meta` VALUES('95', '5', 'cc', '', 'cc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('96', '5', 'bcc', '', 'bcc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('97', '5', 'redirect_url', '', 'redirect_url', '');
INSERT INTO `wp_nf3_action_meta` VALUES('98', '5', 'submitter_email', '', 'submitter_email', '');
INSERT INTO `wp_nf3_action_meta` VALUES('99', '5', 'fields-save-toggle', 'save_all', 'fields-save-toggle', 'save_all');
INSERT INTO `wp_nf3_action_meta` VALUES('100', '5', 'exception_fields', 'a:0:{}', 'exception_fields', 'a:0:{}');
INSERT INTO `wp_nf3_action_meta` VALUES('101', '5', 'set_subs_to_expire', '0', 'set_subs_to_expire', '0');
INSERT INTO `wp_nf3_action_meta` VALUES('102', '5', 'subs_expire_time', '90', 'subs_expire_time', '90');
INSERT INTO `wp_nf3_action_meta` VALUES('103', '5', 'success_msg', 'Ihr Formular wurde erfolgreich gesendet.', 'success_msg', 'Ihr Formular wurde erfolgreich gesendet.');
INSERT INTO `wp_nf3_action_meta` VALUES('104', '6', 'objectType', 'Action', 'objectType', 'Action');
INSERT INTO `wp_nf3_action_meta` VALUES('105', '6', 'objectDomain', 'actions', 'objectDomain', 'actions');
INSERT INTO `wp_nf3_action_meta` VALUES('106', '6', 'editActive', '', 'editActive', '');
INSERT INTO `wp_nf3_action_meta` VALUES('107', '6', 'order', '2', 'order', '2');
INSERT INTO `wp_nf3_action_meta` VALUES('108', '6', 'message', 'This action adds users to WordPress\' personal data delete tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.', 'message', 'This action adds users to WordPress\' personal data delete tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.');
INSERT INTO `wp_nf3_action_meta` VALUES('109', '6', 'payment_gateways', '', 'payment_gateways', '');
INSERT INTO `wp_nf3_action_meta` VALUES('110', '6', 'payment_total', '0', 'payment_total', '0');
INSERT INTO `wp_nf3_action_meta` VALUES('111', '6', 'tag', '', 'tag', '');
INSERT INTO `wp_nf3_action_meta` VALUES('112', '6', 'to', '{wp:admin_email}', 'to', '{wp:admin_email}');
INSERT INTO `wp_nf3_action_meta` VALUES('113', '6', 'reply_to', '', 'reply_to', '');
INSERT INTO `wp_nf3_action_meta` VALUES('114', '6', 'email_subject', 'Ninja Forms-Einreichung', 'email_subject', 'Ninja Forms-Einreichung');
INSERT INTO `wp_nf3_action_meta` VALUES('115', '6', 'email_message', '{fields_table}', 'email_message', '{fields_table}');
INSERT INTO `wp_nf3_action_meta` VALUES('116', '6', 'email_message_plain', '', 'email_message_plain', '');
INSERT INTO `wp_nf3_action_meta` VALUES('117', '6', 'from_name', '', 'from_name', '');
INSERT INTO `wp_nf3_action_meta` VALUES('118', '6', 'from_address', '', 'from_address', '');
INSERT INTO `wp_nf3_action_meta` VALUES('119', '6', 'email_format', 'html', 'email_format', 'html');
INSERT INTO `wp_nf3_action_meta` VALUES('120', '6', 'cc', '', 'cc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('121', '6', 'bcc', '', 'bcc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('122', '7', 'objectType', 'Action', 'objectType', 'Action');
INSERT INTO `wp_nf3_action_meta` VALUES('123', '7', 'objectDomain', 'actions', 'objectDomain', 'actions');
INSERT INTO `wp_nf3_action_meta` VALUES('124', '7', 'editActive', '', 'editActive', '');
INSERT INTO `wp_nf3_action_meta` VALUES('125', '7', 'order', '3', 'order', '3');
INSERT INTO `wp_nf3_action_meta` VALUES('126', '7', 'message', 'This action adds users to WordPress\' personal data export tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.', 'message', 'This action adds users to WordPress\' personal data export tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.');
INSERT INTO `wp_nf3_action_meta` VALUES('127', '7', 'payment_gateways', '', 'payment_gateways', '');
INSERT INTO `wp_nf3_action_meta` VALUES('128', '7', 'payment_total', '0', 'payment_total', '0');
INSERT INTO `wp_nf3_action_meta` VALUES('129', '7', 'tag', '', 'tag', '');
INSERT INTO `wp_nf3_action_meta` VALUES('130', '7', 'to', '{wp:admin_email}', 'to', '{wp:admin_email}');
INSERT INTO `wp_nf3_action_meta` VALUES('131', '7', 'reply_to', '', 'reply_to', '');
INSERT INTO `wp_nf3_action_meta` VALUES('132', '7', 'email_subject', 'Ninja Forms-Einreichung', 'email_subject', 'Ninja Forms-Einreichung');
INSERT INTO `wp_nf3_action_meta` VALUES('133', '7', 'email_message', '{fields_table}', 'email_message', '{fields_table}');
INSERT INTO `wp_nf3_action_meta` VALUES('134', '7', 'email_message_plain', '', 'email_message_plain', '');
INSERT INTO `wp_nf3_action_meta` VALUES('135', '7', 'from_name', '', 'from_name', '');
INSERT INTO `wp_nf3_action_meta` VALUES('136', '7', 'from_address', '', 'from_address', '');
INSERT INTO `wp_nf3_action_meta` VALUES('137', '7', 'email_format', 'html', 'email_format', 'html');
INSERT INTO `wp_nf3_action_meta` VALUES('138', '7', 'cc', '', 'cc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('139', '7', 'bcc', '', 'bcc', '');
INSERT INTO `wp_nf3_action_meta` VALUES('140', '7', 'redirect_url', '', 'redirect_url', '');
INSERT INTO `wp_nf3_action_meta` VALUES('141', '7', 'submitter_email', 'email_1552775189847', 'submitter_email', 'email_1552775189847');
INSERT INTO `wp_nf3_action_meta` VALUES('142', '7', 'fields-save-toggle', 'save_all', 'fields-save-toggle', 'save_all');
INSERT INTO `wp_nf3_action_meta` VALUES('143', '7', 'exception_fields', 'a:0:{}', 'exception_fields', 'a:0:{}');
INSERT INTO `wp_nf3_action_meta` VALUES('144', '7', 'set_subs_to_expire', '0', 'set_subs_to_expire', '0');
INSERT INTO `wp_nf3_action_meta` VALUES('145', '7', 'subs_expire_time', '90', 'subs_expire_time', '90');
/*!40000 ALTER TABLE `wp_nf3_action_meta` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;