CREATE TABLE `wp_nf3_form_meta` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `parent_id` int(11) NOT NULL,  `key` longtext NOT NULL,  `value` longtext,  `meta_key` longtext,  `meta_value` longtext,  UNIQUE KEY `id` (`id`)) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4;
/*!40000 ALTER TABLE `wp_nf3_form_meta` DISABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
INSERT INTO `wp_nf3_form_meta` VALUES('1', '1', 'key', '', 'key', '');
INSERT INTO `wp_nf3_form_meta` VALUES('2', '1', 'created_at', '2019-03-16 22:25:52', 'created_at', '2019-03-16 22:25:52');
INSERT INTO `wp_nf3_form_meta` VALUES('3', '1', 'default_label_pos', 'above', 'default_label_pos', 'above');
INSERT INTO `wp_nf3_form_meta` VALUES('4', '1', 'conditions', 'a:0:{}', 'conditions', 'a:0:{}');
INSERT INTO `wp_nf3_form_meta` VALUES('5', '1', 'objectType', 'Form Setting', 'objectType', 'Form Setting');
INSERT INTO `wp_nf3_form_meta` VALUES('6', '1', 'editActive', '', 'editActive', '');
INSERT INTO `wp_nf3_form_meta` VALUES('7', '1', 'show_title', '1', 'show_title', '1');
INSERT INTO `wp_nf3_form_meta` VALUES('8', '1', 'clear_complete', '1', 'clear_complete', '1');
INSERT INTO `wp_nf3_form_meta` VALUES('9', '1', 'hide_complete', '1', 'hide_complete', '1');
INSERT INTO `wp_nf3_form_meta` VALUES('10', '1', 'wrapper_class', '', 'wrapper_class', '');
INSERT INTO `wp_nf3_form_meta` VALUES('11', '1', 'element_class', '', 'element_class', '');
INSERT INTO `wp_nf3_form_meta` VALUES('12', '1', 'add_submit', '1', 'add_submit', '1');
INSERT INTO `wp_nf3_form_meta` VALUES('13', '1', 'logged_in', '', 'logged_in', '');
INSERT INTO `wp_nf3_form_meta` VALUES('14', '1', 'not_logged_in_msg', '', 'not_logged_in_msg', '');
INSERT INTO `wp_nf3_form_meta` VALUES('15', '1', 'sub_limit_number', '', 'sub_limit_number', '');
INSERT INTO `wp_nf3_form_meta` VALUES('16', '1', 'sub_limit_msg', '', 'sub_limit_msg', '');
INSERT INTO `wp_nf3_form_meta` VALUES('17', '1', 'calculations', 'a:0:{}', 'calculations', 'a:0:{}');
INSERT INTO `wp_nf3_form_meta` VALUES('18', '1', 'formContentData', 'a:4:{i:0;a:2:{s:5:\"order\";s:1:\"0\";s:5:\"cells\";a:1:{i:0;a:3:{s:5:\"order\";s:1:\"0\";s:6:\"fields\";a:1:{i:0;s:4:\"name\";}s:5:\"width\";s:3:\"100\";}}}i:1;a:2:{s:5:\"order\";s:1:\"1\";s:5:\"cells\";a:1:{i:0;a:3:{s:5:\"order\";s:1:\"0\";s:6:\"fields\";a:1:{i:0;s:5:\"email\";}s:5:\"width\";s:3:\"100\";}}}i:2;a:2:{s:5:\"order\";s:1:\"2\";s:5:\"cells\";a:1:{i:0;a:3:{s:5:\"order\";s:1:\"0\";s:6:\"fields\";a:1:{i:0;s:7:\"message\";}s:5:\"width\";s:3:\"100\";}}}i:3;a:2:{s:5:\"order\";s:1:\"3\";s:5:\"cells\";a:1:{i:0;a:3:{s:5:\"order\";s:1:\"0\";s:6:\"fields\";a:1:{i:0;s:6:\"submit\";}s:5:\"width\";s:3:\"100\";}}}}', 'formContentData', 'a:4:{i:0;a:2:{s:5:\"order\";s:1:\"0\";s:5:\"cells\";a:1:{i:0;a:3:{s:5:\"order\";s:1:\"0\";s:6:\"fields\";a:1:{i:0;s:4:\"name\";}s:5:\"width\";s:3:\"100\";}}}i:1;a:2:{s:5:\"order\";s:1:\"1\";s:5:\"cells\";a:1:{i:0;a:3:{s:5:\"order\";s:1:\"0\";s:6:\"fields\";a:1:{i:0;s:5:\"email\";}s:5:\"width\";s:3:\"100\";}}}i:2;a:2:{s:5:\"order\";s:1:\"2\";s:5:\"cells\";a:1:{i:0;a:3:{s:5:\"order\";s:1:\"0\";s:6:\"fields\";a:1:{i:0;s:7:\"message\";}s:5:\"width\";s:3:\"100\";}}}i:3;a:2:{s:5:\"order\";s:1:\"3\";s:5:\"cells\";a:1:{i:0;a:3:{s:5:\"order\";s:1:\"0\";s:6:\"fields\";a:1:{i:0;s:6:\"submit\";}s:5:\"width\";s:3:\"100\";}}}}');
INSERT INTO `wp_nf3_form_meta` VALUES('19', '1', 'container_styles_background-color', '', 'container_styles_background-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('20', '1', 'container_styles_border', '', 'container_styles_border', '');
INSERT INTO `wp_nf3_form_meta` VALUES('21', '1', 'container_styles_border-style', '', 'container_styles_border-style', '');
INSERT INTO `wp_nf3_form_meta` VALUES('22', '1', 'container_styles_border-color', '', 'container_styles_border-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('23', '1', 'container_styles_color', '', 'container_styles_color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('24', '1', 'container_styles_height', '', 'container_styles_height', '');
INSERT INTO `wp_nf3_form_meta` VALUES('25', '1', 'container_styles_width', '', 'container_styles_width', '');
INSERT INTO `wp_nf3_form_meta` VALUES('26', '1', 'container_styles_font-size', '', 'container_styles_font-size', '');
INSERT INTO `wp_nf3_form_meta` VALUES('27', '1', 'container_styles_margin', '', 'container_styles_margin', '');
INSERT INTO `wp_nf3_form_meta` VALUES('28', '1', 'container_styles_padding', '', 'container_styles_padding', '');
INSERT INTO `wp_nf3_form_meta` VALUES('29', '1', 'container_styles_display', '', 'container_styles_display', '');
INSERT INTO `wp_nf3_form_meta` VALUES('30', '1', 'container_styles_float', '', 'container_styles_float', '');
INSERT INTO `wp_nf3_form_meta` VALUES('31', '1', 'container_styles_show_advanced_css', '0', 'container_styles_show_advanced_css', '0');
INSERT INTO `wp_nf3_form_meta` VALUES('32', '1', 'container_styles_advanced', '', 'container_styles_advanced', '');
INSERT INTO `wp_nf3_form_meta` VALUES('33', '1', 'title_styles_background-color', '', 'title_styles_background-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('34', '1', 'title_styles_border', '', 'title_styles_border', '');
INSERT INTO `wp_nf3_form_meta` VALUES('35', '1', 'title_styles_border-style', '', 'title_styles_border-style', '');
INSERT INTO `wp_nf3_form_meta` VALUES('36', '1', 'title_styles_border-color', '', 'title_styles_border-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('37', '1', 'title_styles_color', '', 'title_styles_color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('38', '1', 'title_styles_height', '', 'title_styles_height', '');
INSERT INTO `wp_nf3_form_meta` VALUES('39', '1', 'title_styles_width', '', 'title_styles_width', '');
INSERT INTO `wp_nf3_form_meta` VALUES('40', '1', 'title_styles_font-size', '', 'title_styles_font-size', '');
INSERT INTO `wp_nf3_form_meta` VALUES('41', '1', 'title_styles_margin', '', 'title_styles_margin', '');
INSERT INTO `wp_nf3_form_meta` VALUES('42', '1', 'title_styles_padding', '', 'title_styles_padding', '');
INSERT INTO `wp_nf3_form_meta` VALUES('43', '1', 'title_styles_display', '', 'title_styles_display', '');
INSERT INTO `wp_nf3_form_meta` VALUES('44', '1', 'title_styles_float', '', 'title_styles_float', '');
INSERT INTO `wp_nf3_form_meta` VALUES('45', '1', 'title_styles_show_advanced_css', '0', 'title_styles_show_advanced_css', '0');
INSERT INTO `wp_nf3_form_meta` VALUES('46', '1', 'title_styles_advanced', '', 'title_styles_advanced', '');
INSERT INTO `wp_nf3_form_meta` VALUES('47', '1', 'row_styles_background-color', '', 'row_styles_background-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('48', '1', 'row_styles_border', '', 'row_styles_border', '');
INSERT INTO `wp_nf3_form_meta` VALUES('49', '1', 'row_styles_border-style', '', 'row_styles_border-style', '');
INSERT INTO `wp_nf3_form_meta` VALUES('50', '1', 'row_styles_border-color', '', 'row_styles_border-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('51', '1', 'row_styles_color', '', 'row_styles_color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('52', '1', 'row_styles_height', '', 'row_styles_height', '');
INSERT INTO `wp_nf3_form_meta` VALUES('53', '1', 'row_styles_width', '', 'row_styles_width', '');
INSERT INTO `wp_nf3_form_meta` VALUES('54', '1', 'row_styles_font-size', '', 'row_styles_font-size', '');
INSERT INTO `wp_nf3_form_meta` VALUES('55', '1', 'row_styles_margin', '', 'row_styles_margin', '');
INSERT INTO `wp_nf3_form_meta` VALUES('56', '1', 'row_styles_padding', '', 'row_styles_padding', '');
INSERT INTO `wp_nf3_form_meta` VALUES('57', '1', 'row_styles_display', '', 'row_styles_display', '');
INSERT INTO `wp_nf3_form_meta` VALUES('58', '1', 'row_styles_show_advanced_css', '0', 'row_styles_show_advanced_css', '0');
INSERT INTO `wp_nf3_form_meta` VALUES('59', '1', 'row_styles_advanced', '', 'row_styles_advanced', '');
INSERT INTO `wp_nf3_form_meta` VALUES('60', '1', 'row-odd_styles_background-color', '', 'row-odd_styles_background-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('61', '1', 'row-odd_styles_border', '', 'row-odd_styles_border', '');
INSERT INTO `wp_nf3_form_meta` VALUES('62', '1', 'row-odd_styles_border-style', '', 'row-odd_styles_border-style', '');
INSERT INTO `wp_nf3_form_meta` VALUES('63', '1', 'row-odd_styles_border-color', '', 'row-odd_styles_border-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('64', '1', 'row-odd_styles_color', '', 'row-odd_styles_color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('65', '1', 'row-odd_styles_height', '', 'row-odd_styles_height', '');
INSERT INTO `wp_nf3_form_meta` VALUES('66', '1', 'row-odd_styles_width', '', 'row-odd_styles_width', '');
INSERT INTO `wp_nf3_form_meta` VALUES('67', '1', 'row-odd_styles_font-size', '', 'row-odd_styles_font-size', '');
INSERT INTO `wp_nf3_form_meta` VALUES('68', '1', 'row-odd_styles_margin', '', 'row-odd_styles_margin', '');
INSERT INTO `wp_nf3_form_meta` VALUES('69', '1', 'row-odd_styles_padding', '', 'row-odd_styles_padding', '');
INSERT INTO `wp_nf3_form_meta` VALUES('70', '1', 'row-odd_styles_display', '', 'row-odd_styles_display', '');
INSERT INTO `wp_nf3_form_meta` VALUES('71', '1', 'row-odd_styles_show_advanced_css', '0', 'row-odd_styles_show_advanced_css', '0');
INSERT INTO `wp_nf3_form_meta` VALUES('72', '1', 'row-odd_styles_advanced', '', 'row-odd_styles_advanced', '');
INSERT INTO `wp_nf3_form_meta` VALUES('73', '1', 'success-msg_styles_background-color', '', 'success-msg_styles_background-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('74', '1', 'success-msg_styles_border', '', 'success-msg_styles_border', '');
INSERT INTO `wp_nf3_form_meta` VALUES('75', '1', 'success-msg_styles_border-style', '', 'success-msg_styles_border-style', '');
INSERT INTO `wp_nf3_form_meta` VALUES('76', '1', 'success-msg_styles_border-color', '', 'success-msg_styles_border-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('77', '1', 'success-msg_styles_color', '', 'success-msg_styles_color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('78', '1', 'success-msg_styles_height', '', 'success-msg_styles_height', '');
INSERT INTO `wp_nf3_form_meta` VALUES('79', '1', 'success-msg_styles_width', '', 'success-msg_styles_width', '');
INSERT INTO `wp_nf3_form_meta` VALUES('80', '1', 'success-msg_styles_font-size', '', 'success-msg_styles_font-size', '');
INSERT INTO `wp_nf3_form_meta` VALUES('81', '1', 'success-msg_styles_margin', '', 'success-msg_styles_margin', '');
INSERT INTO `wp_nf3_form_meta` VALUES('82', '1', 'success-msg_styles_padding', '', 'success-msg_styles_padding', '');
INSERT INTO `wp_nf3_form_meta` VALUES('83', '1', 'success-msg_styles_display', '', 'success-msg_styles_display', '');
INSERT INTO `wp_nf3_form_meta` VALUES('84', '1', 'success-msg_styles_show_advanced_css', '0', 'success-msg_styles_show_advanced_css', '0');
INSERT INTO `wp_nf3_form_meta` VALUES('85', '1', 'success-msg_styles_advanced', '', 'success-msg_styles_advanced', '');
INSERT INTO `wp_nf3_form_meta` VALUES('86', '1', 'error_msg_styles_background-color', '', 'error_msg_styles_background-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('87', '1', 'error_msg_styles_border', '', 'error_msg_styles_border', '');
INSERT INTO `wp_nf3_form_meta` VALUES('88', '1', 'error_msg_styles_border-style', '', 'error_msg_styles_border-style', '');
INSERT INTO `wp_nf3_form_meta` VALUES('89', '1', 'error_msg_styles_border-color', '', 'error_msg_styles_border-color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('90', '1', 'error_msg_styles_color', '', 'error_msg_styles_color', '');
INSERT INTO `wp_nf3_form_meta` VALUES('91', '1', 'error_msg_styles_height', '', 'error_msg_styles_height', '');
INSERT INTO `wp_nf3_form_meta` VALUES('92', '1', 'error_msg_styles_width', '', 'error_msg_styles_width', '');
INSERT INTO `wp_nf3_form_meta` VALUES('93', '1', 'error_msg_styles_font-size', '', 'error_msg_styles_font-size', '');
INSERT INTO `wp_nf3_form_meta` VALUES('94', '1', 'error_msg_styles_margin', '', 'error_msg_styles_margin', '');
INSERT INTO `wp_nf3_form_meta` VALUES('95', '1', 'error_msg_styles_padding', '', 'error_msg_styles_padding', '');
INSERT INTO `wp_nf3_form_meta` VALUES('96', '1', 'error_msg_styles_display', '', 'error_msg_styles_display', '');
INSERT INTO `wp_nf3_form_meta` VALUES('97', '1', 'error_msg_styles_show_advanced_css', '0', 'error_msg_styles_show_advanced_css', '0');
INSERT INTO `wp_nf3_form_meta` VALUES('98', '1', 'error_msg_styles_advanced', '', 'error_msg_styles_advanced', '');
INSERT INTO `wp_nf3_form_meta` VALUES('99', '2', 'objectType', 'Form Setting', 'objectType', 'Form Setting');
INSERT INTO `wp_nf3_form_meta` VALUES('100', '2', 'editActive', '', 'editActive', '');
INSERT INTO `wp_nf3_form_meta` VALUES('101', '2', 'show_title', '1', 'show_title', '1');
INSERT INTO `wp_nf3_form_meta` VALUES('102', '2', 'clear_complete', '1', 'clear_complete', '1');
INSERT INTO `wp_nf3_form_meta` VALUES('103', '2', 'hide_complete', '1', 'hide_complete', '1');
INSERT INTO `wp_nf3_form_meta` VALUES('104', '2', 'default_label_pos', 'above', 'default_label_pos', 'above');
INSERT INTO `wp_nf3_form_meta` VALUES('105', '2', 'wrapper_class', '', 'wrapper_class', '');
INSERT INTO `wp_nf3_form_meta` VALUES('106', '2', 'element_class', '', 'element_class', '');
INSERT INTO `wp_nf3_form_meta` VALUES('107', '2', 'key', '', 'key', '');
INSERT INTO `wp_nf3_form_meta` VALUES('108', '2', 'add_submit', '1', 'add_submit', '1');
INSERT INTO `wp_nf3_form_meta` VALUES('109', '2', 'currency', '', 'currency', '');
INSERT INTO `wp_nf3_form_meta` VALUES('110', '2', 'unique_field_error', 'A form with this value has already been submitted.', 'unique_field_error', 'A form with this value has already been submitted.');
INSERT INTO `wp_nf3_form_meta` VALUES('111', '2', 'logged_in', '', 'logged_in', '');
INSERT INTO `wp_nf3_form_meta` VALUES('112', '2', 'not_logged_in_msg', '', 'not_logged_in_msg', '');
INSERT INTO `wp_nf3_form_meta` VALUES('113', '2', 'sub_limit_msg', 'The form has reached its submission limit.', 'sub_limit_msg', 'The form has reached its submission limit.');
INSERT INTO `wp_nf3_form_meta` VALUES('114', '2', 'calculations', 'a:0:{}', 'calculations', 'a:0:{}');
INSERT INTO `wp_nf3_form_meta` VALUES('115', '2', 'formContentData', 'a:5:{i:0;s:23:\"firstname_1552775186736\";i:1;s:19:\"email_1552775189847\";i:2;s:29:\"listmultiselect_1552775203930\";i:3;s:23:\"listradio_1552775226116\";i:4;s:20:\"submit_1552775239412\";}', 'formContentData', 'a:5:{i:0;s:23:\"firstname_1552775186736\";i:1;s:19:\"email_1552775189847\";i:2;s:29:\"listmultiselect_1552775203930\";i:3;s:23:\"listradio_1552775226116\";i:4;s:20:\"submit_1552775239412\";}');
/*!40000 ALTER TABLE `wp_nf3_form_meta` ENABLE KEYS */;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
