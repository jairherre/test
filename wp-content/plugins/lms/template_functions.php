<?php

/*
* mark lesson as complete form
* accepts - lesson id
* echo - HTML
*/
function the_mark_lesson_as_complete_from($lesson = '', $caption = '', $cc_caption = '')
{
	global $wpdb, $post;
	if (is_course_progress_disabled()) {
		return;
	}
	if (empty($lesson)) {
		$lesson_id = $post->ID;
	} else {
		$lesson_id = $lesson->ID;
	}

	if (!is_user_logged_in()) {
		return __('Please login!', 'lms');
	}
	$lmc = new class_lms_message;
	$lmc->show();

	do_action('the_mark_lesson_as_complete_top', $lesson);
	if (lms_is_lesson_marked_as_completed(get_current_user_id(), $lesson_id)) {
		if ($cc_caption == '') {
			$msg = __('Lesson is marked as completed!', 'lms');
		} else {
			$msg = $cc_caption;
		}
		include(LMS_DIR_PATH . '/view/front/lesson-completed-message.php');
	} else {
		if ($caption == '') {
			$msg = __('Mark complete', 'lms');
		} else {
			$msg = $caption;
		}

		include(LMS_DIR_PATH . '/view/front/lesson-complete-form.php');
	}
	do_action('the_mark_lesson_as_complete_bottom', $lesson);
}

/*
* display lessons in course page
* accepts - course id
* echo - HTML
*/
function the_lessons($course_id = '')
{
	global $post;
	if (empty($course_id)) {
		$course_id = $post->ID;
	}
	$lessons = lms_get_lessons_from_course($course_id);
	include(LMS_DIR_PATH . '/view/front/lesson-loop.php');
}

/*
* display lessons in section
* accepts - section id
* echo - HTML
*/
function the_lessons_on_section($section_id = '')
{
	if (empty($section_id)) {
		return;
	}
	$lessons = lms_get_lessons_from_section($section_id);
	include(LMS_DIR_PATH . '/view/front/section-lesson-loop.php');
}

/*
* display course complete percentage
* accepts - course id, ( true/false )
* echo - HTML
*/
function the_course_complete_percent_bar( $course_id = '', $args = array() ) {
	$args = wp_parse_args( $args, array(
		'class' => '',
		'show_text' => true,
	) );

	$args['class'] .= ' lms-CourseProgressbar';

	global $post;
	if ( empty( $course_id ) ) {
		$course_id = $post->ID;
	}

	$complete_data = lms_get_current_user_lesson_completion_data( $course_id );

	if ( empty( $complete_data ) ) {
		return;
	}

	if ( $args['show_text'] ) {
		printf( esc_html__( '%s % course is completed', 'lms' ), $complete_data['percentage'] );
	}
	?>
	<div class="<?php echo esc_attr( $args['class'] ); ?>">
		<div class="lms-CourseProgressbar__completed" style="width:<?php echo esc_attr( $complete_data['percentage'] ); ?>%"></div>
	</div>
	<?php
}

/**
 * Display the list of lesson resources
 *
 * @param integer $lesson_id
 * @return void
 */
function the_lms_resources( $lesson_id = 0 ) {
	global $post;

	$lesson_id = absint( $lesson_id );

	if ( empty( $lesson_id ) ) {
		$lesson_id = $post->ID;
	}

	$resource_data = lms_get_resource_data( $lesson_id );
	include( LMS_DIR_PATH . '/view/front/lesson-resource.php' );
}

/*
* display course complete percent widget
* accepts - na
* echo - HTML
*/
function the_course_complete_percent_widget()
{
	global $post;
	if (is_singular('lms_course')) {
		$course_id = $post->ID;
	} elseif (is_singular('lms_lesson')) {
		$lesson_id = $post->ID;
		$course_id = lms_get_probable_course_id_from_lesson_id($lesson_id);
	} else {
		return false;
	}
	$course_complete_data = lms_get_current_user_lesson_completion_data($course_id);
	include(LMS_DIR_PATH . '/view/front/course-complete-percent-widget.php');
}

/*
* lessons widget in course details page
* accepts - widget instance
* echo - HTML
*/
function the_lessons_widget($instance)
{
	global $post;
	if (is_singular('lms_course')) {
		$course_id = $post->ID;
	} elseif (is_singular('lms_lesson')) {
		$lesson_id = $post->ID;
		$course_id = lms_get_probable_course_id_from_lesson_id($lesson_id);
	} else {
		return false;
	}
	$lessons = lms_get_lessons_from_course($course_id);
	$wid_enable_collapsable_outlines = @$instance['wid_enable_collapsable_outlines'];
	$wid_enable_open_close_all = @$instance['wid_enable_open_close_all'];
	$classes = '';
	if ($wid_enable_collapsable_outlines) {
		$classes .= 'widget-section-header';
	}
	include(LMS_DIR_PATH . '/view/front/lessons-list-widget.php');
}

/*
* get courses assigned to user
* accepts - na
* echo - HTML
*/
function lms_courses_assigned_to_user( $atts = array() ) {
	if ( ! is_user_logged_in() ) {
		$error_msg = __( 'Please login to view courses', 'lms' );
		include( LMS_DIR_PATH . '/view/front/user-course-error-message.php' );
		return;
	}

	$courses_data = lms_get_user_courses();

	if ( empty( $courses_data['status'] ) ) {
		$error_msg = $courses_data['msg'];
		include( LMS_DIR_PATH . '/view/front/user-course-error-message.php' );
		return;
	}

	$course_ids = $courses_data['data'];
	$orderby = sanitize_text_field( $atts['orderby'] );
	$order = sanitize_text_field( $atts['order'] );
	$args = array(
		'post_type' => 'lms_course',
		'numberposts' => -1,
		'orderby' => $orderby,
		'order'	=> $order,
		'include' => $course_ids,
	);

	$courses = get_posts( $args );

	include( LMS_DIR_PATH . '/view/front/user-courses.php' );
}

/*
* get all courses
* accepts - na
* echo - HTML
*/
function lms_all_courses( $atts = array() ) {
	$id = sanitize_text_field( $atts['id'] );
	$order = sanitize_text_field( $atts['order'] );
	$orderby = sanitize_text_field( $atts['orderby'] );

	$args = array(
		'post_type'   => 'lms_course',
		'numberposts' => -1,
		'orderby'     => $orderby,
		'order'       => $order,
	);

	if ( $id != '' ) {
		$args['include'] = $id;
	}

	$courses = get_posts( $args );
	include( LMS_DIR_PATH . '/view/front/all-courses.php' );
}

/*
* get course overview thumbnail
* accepts - course obj
* echo - HTML
*/
function the_course_overview_thumbnail( $course ) {
	include(LMS_DIR_PATH . '/view/front/user-courses-overview-thumbnail.php');
}

/*
* get course overview title
* accepts - course obj
* echo - HTML
*/
function the_course_overview_title( $course ) {
	include(LMS_DIR_PATH . '/view/front/user-courses-overview-title.php');
}

/*
* get course overview description
* accepts - course obj
* echo - HTML
*/
function the_course_overview_description( $course ) {
	include(LMS_DIR_PATH . '/view/front/user-courses-overview-desctiption.php');
}

/*
* get course overview author
* accepts - course obj
* echo - HTML
*/
function the_course_overview_author( $course ) {
	include(LMS_DIR_PATH . '/view/front/user-courses-overview-author.php');
}

/*
* get course overview percentage bar
* accepts - course obj
* echo - HTML
*/
function the_course_overview_percentage_bar( $course ) {
	the_course_complete_percent_bar( $course->ID, array(
		'show_text' => false,
		'class' => 'lms-CourseCard__progressbar',
	) );
}

/*
* get course overview percentage text
* accepts - course obj
* echo - HTML
*/
function the_course_overview_percentage( $course ) {
	include(LMS_DIR_PATH . '/view/front/user-courses-overview-percentage.php');
}

/*
* get course single page title
* accepts - course obj
* echo - HTML
*/
function the_course_single_title($course)
{
	do_action('the_course_single_title_top', $course);
	if (get_option('lms_cp_hide_course_title') != 'yes') {
		include(LMS_DIR_PATH . '/view/front/user-courses-single-title.php');
	}
	do_action('the_course_single_title_bottom', $course);
}

/*
* get course single page featured image
* accepts - course obj
* echo - HTML
*/
function the_course_single_featured_image($course)
{
	do_action('the_course_single_featured_image_top', $course);
	if (get_option('lms_cp_hide_feature_image') != 'yes') {
		include(LMS_DIR_PATH . '/view/front/user-courses-single-featured-image.php');
	}
	do_action('the_course_single_featured_image_bottom', $course);
}

/*
* get course single page content
* accepts - course obj
* echo - HTML
*/
function the_course_single_content($course)
{
	do_action('the_course_single_content_top', $course);
	if (get_option('lms_cp_hide_course_desc') != 'yes') {
		include(LMS_DIR_PATH . '/view/front/user-courses-single-content.php');
	}
	do_action('the_course_single_content_bottom', $course);
}

/*
* get course single page lessons
* accepts - course obj
* echo - HTML
*/
function the_course_single_lessons($course)
{
	do_action('the_course_single_lessons_top', $course);
	if (get_option('lms_cp_hide_lesson_list') != 'yes') {
		include(LMS_DIR_PATH . '/view/front/user-courses-single-lessons.php');
	}
	do_action('the_course_single_lessons_bottom', $course);
}

/*
* get lesson single page title
* accepts - lesson obj
* echo - HTML
*/
function the_lesson_single_title($lesson)
{
	do_action('the_lesson_single_title_top', $lesson);
	if (get_option('lms_lp_hide_lesson_title') != 'yes') {
		include(LMS_DIR_PATH . '/view/front/user-lesson-single-title.php');
	}
	do_action('the_lesson_single_title_bottom', $lesson);
}

/*
* get lesson single page video
* accepts - lesson obj
* echo - HTML
*/
function the_lesson_video($lesson)
{
	if (get_post_meta($lesson->ID, 'video_add_automatically_below_title', true) == 'yes') {
		do_action('the_lesson_video_top', $lesson);
		$video_url = get_post_meta($lesson->ID, 'video_url', true);
		$video_type = lms_video_type($video_url);
		$atts = array(
			'post_id' => $lesson->ID,
			//'width' => get_post_meta( $lesson->ID, 'video_width', true ),
			//'height' => get_post_meta( $lesson->ID, 'video_height', true )
		);
		if ($video_type == 'youtube') {
			lms_youtube_video_player($atts);
		} elseif ($video_type == 'vimeo') {
			lms_vimeo_video_player($atts);
		}
		do_action('the_lesson_video_bottom', $lesson);
	}
}

/*
* get lesson single page featured image
* accepts - lesson obj
* echo - HTML
*/
function the_lesson_single_featured_image($lesson)
{
	do_action('the_lesson_single_featured_image_top', $lesson);
	if (get_option('lms_lp_hide_feature_image') != 'yes') {
		include(LMS_DIR_PATH . '/view/front/user-lesson-single-featured-image.php');
	}
	do_action('the_lesson_single_featured_image_bottom', $lesson);
}

/*
* get lesson single page content
* accepts - lesson obj
* echo - HTML
*/
function the_lesson_single_content($lesson)
{
	do_action('the_lesson_single_content_top', $lesson);
	if (get_option('lms_lp_hide_lesson_desc') != 'yes') {
		include(LMS_DIR_PATH . '/view/front/user-lesson-single-content.php');
	}
	do_action('the_lesson_single_content_bottom', $lesson);
}

/*
* get lesson single page resources
* accepts - lesson obj
* echo - HTML
*/
function the_lesson_single_resources($lesson)
{
	do_action('the_lesson_single_resources_top', $lesson);
	if (get_option('lms_lp_hide_lesson_resource') != 'yes') {
		include(LMS_DIR_PATH . '/view/front/user-lesson-single-resources.php');
	}
	do_action('the_lesson_single_resources_bottom', $lesson);
}

/*
* get lesson single page next prev links
* accepts - lesson obj
* echo - HTML
*/
function the_lesson_single_next_prev_links($lesson)
{
	do_action('the_lesson_single_next_prev_links_top', $lesson);
	if (get_option('lms_lp_hide_lesson_prev_next_nav') != 'yes') {
		include(LMS_DIR_PATH . '/view/front/user-lesson-single-next-prev-links.php');
	}
	do_action('the_lesson_single_next_prev_links_bottom', $lesson);
}

/*
* get youtube video player
* accepts - array
* returns - youtube video
*/
function lms_youtube_video_player($atts = array())
{
	$post_id = $atts['post_id'];
	//$width = $atts['width'];
	//$height = $atts['height'];
	if (empty($post_id)) {
		return false;
	}
	$video_url = get_post_meta($post_id, 'video_url', true);
	if (empty($video_url)) {
		return false;
	}
	$percent = get_post_meta($post_id, 'video_minimum_percentage', true);
	$video_id = lms_youtube_video_id($video_url);
	include(LMS_DIR_PATH . '/view/front/youtube.php');
	include(LMS_DIR_PATH . '/youtube/script.php');
}

/*
* get vimeo video player
* accepts - array
* returns - vimeo video
*/
function lms_vimeo_video_player($atts = array())
{
	$post_id = $atts['post_id'];
	//$width = $atts['width'];
	//$height = $atts['height'];
	if (empty($post_id)) {
		return false;
	}
	$video_url = get_post_meta($post_id, 'video_url', true);
	if (empty($video_url)) {
		return false;
	}
	$percent = get_post_meta($post_id, 'video_minimum_percentage', true);
	$video_id = lms_vimeo_video_id($video_url);
	include(LMS_DIR_PATH . '/view/front/vimeo.php');
	include(LMS_DIR_PATH . '/vimeo/script.php');
}
