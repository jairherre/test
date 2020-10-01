<?php
class class_tg_data_import{
	
	public $allowed_file_types = array( 'application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	
	public function __construct( $cls ){		
		if( $_FILES['import_data']['name']){
			if( in_array($_FILES["import_data"]["type"],$this->allowed_file_types) ){
				global $wpdb;
				
				include_once TG_DIR_PATH . '/excel_import/vendor/php-excel-reader/excel_reader2.php';
				include_once TG_DIR_PATH . '/excel_import/vendor/SpreadsheetReader.php';
				
				//echo '<pre>';
				
				$upload_dir = wp_upload_dir();
				$file_path = $upload_dir['basedir'] . '/' . 'teachground' . '/' . $_FILES['import_data']['name'];
				move_uploaded_file( $_FILES['import_data']['tmp_name'], $file_path );
				$reader = new SpreadsheetReader($file_path);
				$sheetcount = count($reader->sheets());
				$imported = false;
						
				for( $i = 0; $i < $sheetcount; $i++ ){
					$reader->ChangeSheet($i);
					$j = 0;
					$order = 1;
					
					foreach ($reader as $row){
						if($j==0){
							$j++;
							continue;
						}		
						$imported = true;
						// create course 
						$course_title = sanitize_text_field( $row[0] );
						if($course_title){
							$is_course_exists = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_title = %s AND post_type = %s",  $course_title, 'tg_course' ) );
							if( !$is_course_exists ){
								$new_course = array(
									'post_title' => $course_title,
									'post_content' => '',
									'post_status' => 'publish',
									'post_date' => date('Y-m-d H:i:s'),
									'post_type' => 'tg_course',
								);
								$course_id = wp_insert_post($new_course);
							} else {
								$course_id = $is_course_exists->ID; 
							}
						}
						// create course 
						
						// create section 
						$section_title = sanitize_text_field( $row[1] );
						if($section_title){
							$is_section_exists = $wpdb->get_row( $wpdb->prepare( "SELECT s_id FROM " . $wpdb->prefix . "tg_section WHERE s_name = %s AND c_id = %d",  $section_title, $course_id ) );
							if( !$is_section_exists ){
								$section_data = array( 'c_id' => $course_id, 's_name' => $section_title );
								$wpdb->insert( $wpdb->prefix.'tg_section', $section_data );
								$section_id = $wpdb->insert_id;
								
								// mapping //
								$lesson_mapping_data = array( 'c_id' => $course_id, 'l_id' => 0, 'm_type' => 'section', 's_id' => $section_id, 'm_order' => $order, 'l_delay' => 0 );
								$wpdb->insert( $wpdb->prefix.'tg_lesson_mapping', $lesson_mapping_data );
								$order++;
								// mapping //
								
							} else {
								$section_id = $is_section_exists->s_id; 
							}
						}
						// create section 
						
						// create lesson 
						$lesson_title = sanitize_text_field( $row[2] );
						if($lesson_title){
							$is_lesson_exists = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_title = %s AND post_type = %s",  $lesson_title, 'tg_lesson' ) );
							if( !$is_lesson_exists ){
								$new_lesson = array(
									'post_title' => $lesson_title,
									'post_content' => '',
									'post_status' => 'publish',
									'post_date' => date('Y-m-d H:i:s'),
									'post_type' => 'tg_lesson',
								);
								if( $row[3] or $row[4] ){
									$new_lesson['meta_input'] = array(
										'video_url' => sanitize_text_field( $row[3] ),
										'video_minimum_percentage' => sanitize_text_field( $row[4] ),
										'video_add_automatically_below_title' => 'yes'
									);
								}
								$lesson_id = wp_insert_post($new_lesson);
								
								// mapping //
								$lesson_mapping_data = array( 'c_id' => $course_id, 'l_id' => $lesson_id, 'm_type' => 'lesson', 's_id' => $section_id, 'm_order' => $order, 'l_delay' => 0 );
								$wpdb->insert( $wpdb->prefix.'tg_lesson_mapping', $lesson_mapping_data );
								$order++;
								// mapping //
								
							} else {
								$lesson_id = $is_lesson_exists->ID; 
							}
						}
						// create lesson
						
						// create resource box //
						$resource_box_title = sanitize_text_field( $row[5] );
						if($resource_box_title){
							$is_resource_box_exists = $wpdb->get_row( $wpdb->prepare( "SELECT m_id FROM " . $wpdb->prefix . "tg_resource_mapping WHERE r_title = %s AND l_id = %d",  $resource_box_title, $lesson_id ) );
							if( !$is_resource_box_exists ){
								$resource_box_data = array( 'l_id' => $lesson_id, 'r_id' => 0, 'r_title' => $resource_box_title, 'r_highlight' => 'no' );
								$wpdb->insert( $wpdb->prefix.'tg_resource_mapping', $resource_box_data );
								$resource_m_id = $wpdb->insert_id;
							} else {
								$resource_m_id = $is_resource_box_exists->m_id; 
							}
						}
						// create resource box //
						
						// create resource //
						$resource_title = sanitize_text_field( $row[6] );
						if($resource_title){
							$is_resource_exists = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_title = %s AND post_type = %s",  $resource_title, 'tg_resource' ) );
							if( !$is_resource_exists ){
								$new_resource = array(
									'post_title' => $resource_title,
									'post_content' => '',
									'post_status' => 'publish',
									'post_date' => date('Y-m-d H:i:s'),
									'post_type' => 'tg_resource',
								);
								$resource_id = wp_insert_post($new_resource);
								
								// create link items //
								$links = $row[7];
								$r_link = '';
								if($links){
									$links = explode(',', $links);
									if(is_array($links)){
										foreach($links as $key => $value){
											$link_item = explode('->', $value);
											$r_link = array( 'name' => sanitize_text_field($link_item[0]), 'url' => sanitize_text_field($link_item[1]) );
											$r_link = json_encode($r_link);
											// mapping //
												$resource_mapping_data = array( 'post_id' => $resource_id, 'att_id' => 0, 'r_link' => $r_link);
												$wpdb->insert( $wpdb->prefix.'tg_resource', $resource_mapping_data );
												$resource_m_id = $wpdb->insert_id;
											// mapping //
								
										}
									}
									$r_links = json_encode($r_links);
								}		
								// create link items //
								
								// mapping 2 //
								$resource_box_data = array( 'l_id' => $lesson_id, 'r_id' => $resource_id, 'r_title' => '', 'r_highlight' => 'no' );
								$wpdb->insert( $wpdb->prefix.'tg_resource_mapping', $resource_box_data );
								$resource_m2_id = $wpdb->insert_id;
								// mapping 2 //
								
							} else {
								$resource_id = $is_resource_exists->ID; 
							}
						}
						// create resource //
						
						
					} // end of foreach
				 }
				 if($imported){
				 	$cls->msg->add( 'Data imported successfully', 'updated' );
				 }else {
				 	$cls->msg->add( 'Some issues with reading the file. Please check the sample file for reference.', 'updated', true );
				 }
			} else { 
				$cls->msg->add( 'Invalid file. Please upload excel file.', 'updated', true );
			}
		}

		if(isset($_REQUEST['import_data_gs']) and $_REQUEST['import_data_gs'] != ''){
			
			global $wpdb;
			
			include_once TG_DIR_PATH . '/excel_import/vendor/php-excel-reader/excel_reader2.php';
			include_once TG_DIR_PATH . '/excel_import/vendor/SpreadsheetReader.php';
			
			//echo '<pre>';

			$upload_dir = wp_upload_dir();
			$gs_file = sanitize_text_field($_REQUEST['import_data_gs']);
			$file_path = $upload_dir['basedir'] . '/' . 'teachground' . '/' . basename($gs_file);

			file_put_contents( $file_path, file_get_contents($gs_file));
			
			$reader = new SpreadsheetReader($file_path);
			$sheetcount = count($reader->sheets());
			$imported = false;
					
			for( $i = 0; $i < $sheetcount; $i++ ){
				$reader->ChangeSheet($i);
				$j = 0;
				$order = 1;
				
				foreach ($reader as $row){
					if($j==0){
						$j++;
						continue;
					}		
					$imported = true;
					// create course 
					$course_title = sanitize_text_field( $row[0] );
					if($course_title){
						$is_course_exists = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_title = %s AND post_type = %s",  $course_title, 'tg_course' ) );
						if( !$is_course_exists ){
							$new_course = array(
								'post_title' => $course_title,
								'post_content' => '',
								'post_status' => 'publish',
								'post_date' => date('Y-m-d H:i:s'),
								'post_type' => 'tg_course',
							);
							$course_id = wp_insert_post($new_course);
						} else {
							$course_id = $is_course_exists->ID; 
						}
					}
					// create course 
					
					// create section 
					$section_title = sanitize_text_field( $row[1] );
					if($section_title){
						$is_section_exists = $wpdb->get_row( $wpdb->prepare( "SELECT s_id FROM " . $wpdb->prefix . "tg_section WHERE s_name = %s AND c_id = %d",  $section_title, $course_id ) );
						if( !$is_section_exists ){
							$section_data = array( 'c_id' => $course_id, 's_name' => $section_title );
							$wpdb->insert( $wpdb->prefix.'tg_section', $section_data );
							$section_id = $wpdb->insert_id;
							
							// mapping //
							$lesson_mapping_data = array( 'c_id' => $course_id, 'l_id' => 0, 'm_type' => 'section', 's_id' => $section_id, 'm_order' => $order, 'l_delay' => 0 );
							$wpdb->insert( $wpdb->prefix.'tg_lesson_mapping', $lesson_mapping_data );
							$order++;
							// mapping //
							
						} else {
							$section_id = $is_section_exists->s_id; 
						}
					}
					// create section 
					
					// create lesson 
					$lesson_title = sanitize_text_field( $row[2] );
					if($lesson_title){
						$is_lesson_exists = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_title = %s AND post_type = %s",  $lesson_title, 'tg_lesson' ) );
						if( !$is_lesson_exists ){
							$new_lesson = array(
								'post_title' => $lesson_title,
								'post_content' => '',
								'post_status' => 'publish',
								'post_date' => date('Y-m-d H:i:s'),
								'post_type' => 'tg_lesson',
							);
							if( $row[3] or $row[4] ){
								$new_lesson['meta_input'] = array(
									'video_url' => sanitize_text_field( $row[3] ),
									'video_minimum_percentage' => sanitize_text_field( $row[4] ),
									'video_add_automatically_below_title' => 'yes'
								);
							}
							$lesson_id = wp_insert_post($new_lesson);
							
							// mapping //
							$lesson_mapping_data = array( 'c_id' => $course_id, 'l_id' => $lesson_id, 'm_type' => 'lesson', 's_id' => $section_id, 'm_order' => $order, 'l_delay' => 0 );
							$wpdb->insert( $wpdb->prefix.'tg_lesson_mapping', $lesson_mapping_data );
							$order++;
							// mapping //
							
						} else {
							$lesson_id = $is_lesson_exists->ID; 
						}
					}
					// create lesson
					
					// create resource box //
					$resource_box_title = sanitize_text_field( $row[5] );
					if($resource_box_title){
						$is_resource_box_exists = $wpdb->get_row( $wpdb->prepare( "SELECT m_id FROM " . $wpdb->prefix . "tg_resource_mapping WHERE r_title = %s AND l_id = %d",  $resource_box_title, $lesson_id ) );
						if( !$is_resource_box_exists ){
							$resource_box_data = array( 'l_id' => $lesson_id, 'r_id' => 0, 'r_title' => $resource_box_title, 'r_highlight' => 'no' );
							$wpdb->insert( $wpdb->prefix.'tg_resource_mapping', $resource_box_data );
							$resource_m_id = $wpdb->insert_id;
						} else {
							$resource_m_id = $is_resource_box_exists->m_id; 
						}
					}
					// create resource box //
					
					// create resource //
					$resource_title = sanitize_text_field( $row[6] );
					if($resource_title){
						$is_resource_exists = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_title = %s AND post_type = %s",  $resource_title, 'tg_resource' ) );
						if( !$is_resource_exists ){
							$new_resource = array(
								'post_title' => $resource_title,
								'post_content' => '',
								'post_status' => 'publish',
								'post_date' => date('Y-m-d H:i:s'),
								'post_type' => 'tg_resource',
							);
							$resource_id = wp_insert_post($new_resource);
							
							// create link items //
							$links = $row[7];
							$r_link = '';
							if($links){
								$links = explode(',', $links);
								if(is_array($links)){
									foreach($links as $key => $value){
										$link_item = explode('->', $value);
										$r_link = array( 'name' => sanitize_text_field($link_item[0]), 'url' => sanitize_text_field($link_item[1]) );
										$r_link = json_encode($r_link);
										// mapping //
											$resource_mapping_data = array( 'post_id' => $resource_id, 'att_id' => 0, 'r_link' => $r_link);
											$wpdb->insert( $wpdb->prefix.'tg_resource', $resource_mapping_data );
											$resource_m_id = $wpdb->insert_id;
										// mapping //
							
									}
								}
								$r_links = json_encode($r_links);
							}		
							// create link items //
							
							// mapping 2 //
							$resource_box_data = array( 'l_id' => $lesson_id, 'r_id' => $resource_id, 'r_title' => '', 'r_highlight' => 'no' );
							$wpdb->insert( $wpdb->prefix.'tg_resource_mapping', $resource_box_data );
							$resource_m2_id = $wpdb->insert_id;
							// mapping 2 //
							
						} else {
							$resource_id = $is_resource_exists->ID; 
						}
					}
					// create resource //
					
					
				} // end of foreach
			}

			if($imported){
				$cls->msg->add( 'Data imported successfully', 'updated' );
			}else {
				$cls->msg->add( 'Some issues with reading the file. Please check the sample file for reference.', 'updated', true );
			}

		}
	}
}