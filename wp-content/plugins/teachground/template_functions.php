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
		return __('Please login!', 'teachground');
	}

	$lmc = new class_tg_message;
	$lmc->show();

	do_action('the_mark_lesson_as_complete_top', $lesson);
	if (tg_is_lesson_marked_as_completed(get_current_user_id(), $lesson_id)) {
		if ($cc_caption == '') {
			$msg = __('Lesson is marked as completed!', 'teachground');
		} else {
			$msg = $cc_caption;
		}
		include(TG_DIR_PATH . '/view/front/lesson-completed-message.php');
	} else {
		if ($caption == '') {
			$msg = __('Mark complete', 'teachground');
		} else {
			$msg = $caption;
		}

		include(TG_DIR_PATH . '/view/front/lesson-complete-form.php');
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
	$lessons = tg_get_lessons_from_course($course_id);
	include(TG_DIR_PATH . '/view/front/lesson-loop.php');
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
	$lessons = tg_get_lessons_from_section($section_id);
	include(TG_DIR_PATH . '/view/front/section-lesson-loop.php');
}

/*
* display course complete percentage
* accepts - course id, ( true/false )
* echo - HTML
*/
function the_course_complete_percent_bar( $course_id = '', $args = [] ) {
	$args = wp_parse_args( $args, array(
		'class' => '',
		'show_text' => true,
	) );

	$args['class'] .= ' tg-CourseProgressbar';

	global $post;
	if ( empty( $course_id ) ) {
		$course_id = $post->ID;
	}

	$complete_data = tg_get_current_user_lesson_completion_data( $course_id );

	if ( empty( $complete_data ) ) {
		return;
	}

	if ( $args['show_text'] ) {
		printf(
			'<div class="tg-CourseProgressbar__text">%s</div>',
			sprintf(
				esc_html__( '%s course is completed', 'lms' ),
				$complete_data['percentage'] . '%'
			)
		);
	}
	?>
	<div class="<?php echo esc_attr( $args['class'] ); ?>">
		<div class="tg-CourseProgressbar__completed" style="width:<?php echo esc_attr( $complete_data['percentage'] ); ?>%"></div>
	</div>
	<?php
}

/**
 * Print lesson resources
 *
 * @param mixed|int $lesson_id
 * @return void
 */
function the_tg_resources( $lesson_id = '' ) {
	global $post;

	if ( empty( $lesson_id ) ) {
		$lesson_id = $post->ID;
	}

	$resource_data = tg_get_resource_data( $lesson_id );
	include TG_DIR_PATH . '/view/front/lesson-resource.php';
}

/*
* display course complete percent widget
* accepts - na
* echo - HTML
*/
function the_course_complete_percent_widget()
{
	global $post;
	if (is_singular('tg_course')) {
		$course_id = $post->ID;
	} elseif (is_singular('tg_lesson')) {
		$lesson_id = $post->ID;
		$course_id = tg_get_probable_course_id_from_lesson_id($lesson_id);
	} else {
		return false;
	}
	$course_complete_data = tg_get_current_user_lesson_completion_data($course_id);
	include(TG_DIR_PATH . '/view/front/course-complete-percent-widget.php');
}

/*
* lessons widget in course details page
* accepts - widget instance
* echo - HTML
*/
function the_lessons_widget( $instance ) {
	global $post;

	if ( is_singular( 'tg_course' ) ) {
		$course_id = $post->ID;
	} elseif ( is_singular( 'tg_lesson' ) ) {
		$lesson_id = $post->ID;
		$course_id = tg_get_probable_course_id_from_lesson_id( $lesson_id );
	} else {
		return false;
	}

	$lessons = tg_get_lessons_from_course( $course_id );
	$wid_enable_collapsable_outlines = @$instance['wid_enable_collapsable_outlines'];
	$wid_enable_open_close_all = @$instance['wid_enable_open_close_all'];
	$classes = '';

	if ( true ) {
		$classes .= 'widget-section-header';
	}

	include TG_DIR_PATH . '/view/front/lessons-list-widget.php';
}

/*
* get courses assigned to user
* accepts - na
* echo - HTML
*/
function courses_assigned_to_user($atts = array())
{
	if (is_user_logged_in()) {
		$courses_data = tg_get_user_courses();
		if ($courses_data['status'] == true) {
			$course_ids = $courses_data['data'];

			$orderby = sanitize_text_field($atts['orderby']);
			$order = sanitize_text_field($atts['order']);

			$args = array(
				'post_type' => 'tg_course',
				'numberposts' => -1,
				'orderby' => $orderby,
				'order'	=> $order,
				'include' => $course_ids,
			);

			if ( ! empty( $atts['categories'] ) ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'tg_course_category',
						'field'    => 'term_id',
						'terms'    => $atts['categories'],
					),
				);
			}
			
			$courses = get_posts($args);

			include(TG_DIR_PATH . '/view/front/user-courses.php');
		} else {
			$error_msg = $courses_data['msg'];
			include(TG_DIR_PATH . '/view/front/user-course-error-message.php');
		}
	} else {
		$error_msg = __('Please login to view courses', 'teachground');
		include(TG_DIR_PATH . '/view/front/user-course-error-message.php');
	}
}

/**
 * Render course list output
 *
 * @param array $args
 * @return void
 */
function tg_course_list( $args = [] ) {
	$args = wp_parse_args( $args, [
		'orderby'          => 'date',
		'order'            => 'desc',
		'id'               => '',
		'categories'       => '',
		'show_image'       => 'yes',
		'show_title'       => 'yes',
		'show_excerpt'     => 'yes',
		'show_progressbar' => 'yes',
		'show_author'      => 'yes',
		'show_completed'   => 'yes',
		'assigned_first'   => 'no',
	] );

	$query_args = array(
		'post_type'   => 'tg_course',
		'numberposts' => -1,
		'orderby'     => $args['orderby'],
		'order'       => $args['order'],
	);

	if ( ! empty( $args['id'] ) ) {
		$query_args['include'] = $args['id'];
	}

	if ( ! empty( $args['categories'] ) ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'tg_course_category',
				'field'    => 'term_id',
				'terms'    => $args['categories'],
			),
		);
	}

	$courses = get_posts( $query_args );

	include TG_DIR_PATH . '/view/front/course-list.php';
}

/**
 * Render course thumbnail
 *
 * @param object $course
 * @return void
 */
function the_course_overview_thumbnail( $course ) {
	include TG_DIR_PATH . '/view/front/user-courses-overview-thumbnail.php';
}

/**
 * Render course title
 *
 * @param object $course
 * @return void
 */
function the_course_overview_title( $course ) {
	include TG_DIR_PATH . '/view/front/user-courses-overview-title.php';
}

/**
 * Render course description
 *
 * @param object $course
 * @return void
 */
function the_course_overview_description( $course ) {
	include TG_DIR_PATH . '/view/front/user-courses-overview-desctiption.php';
}

/**
 * Render course author name
 *
 * @param object $course
 * @return void
 */
function the_course_overview_author( $course ) {
	include TG_DIR_PATH . '/view/front/user-courses-overview-author.php';
}

/**
 * Render course percentage bar
 *
 * @param object $course
 * @return void
 */
function the_course_overview_percentage_bar( $course ) {
	the_course_complete_percent_bar( $course->ID, array(
		'show_text' => false,
		'class' => 'tg-CourseCard__progressbar',
	) );
}

/**
 * Render course percentage
 *
 * @param object $course
 * @return void
 */
function the_course_overview_percentage( $course ) {
	include TG_DIR_PATH . '/view/front/user-courses-overview-percentage.php';
}

/*
* get course single page title
* accepts - course obj
* echo - HTML
*/
function the_course_single_title($course)
{
	do_action('the_course_single_title_top', $course);
	if (get_option('tg_cp_hide_course_title') != 'yes') {
		include(TG_DIR_PATH . '/view/front/user-courses-single-title.php');
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
	if (get_option('tg_cp_hide_feature_image') != 'yes') {
		include(TG_DIR_PATH . '/view/front/user-courses-single-featured-image.php');
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
	if (get_option('tg_cp_hide_course_desc') != 'yes') {
		include(TG_DIR_PATH . '/view/front/user-courses-single-content.php');
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
	if (get_option('tg_cp_hide_lesson_list') != 'yes') {
		include(TG_DIR_PATH . '/view/front/user-courses-single-lessons.php');
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
	if (get_option('tg_lp_hide_lesson_title') != 'yes') {
		include(TG_DIR_PATH . '/view/front/user-lesson-single-title.php');
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
		$video_type = tg_video_type($video_url);
		$atts = array(
			'post_id' => $lesson->ID,
			//'width' => get_post_meta( $lesson->ID, 'video_width', true ),
			//'height' => get_post_meta( $lesson->ID, 'video_height', true )
		);
		if ($video_type == 'youtube') {
			tg_youtube_video_player($atts);
		} elseif ($video_type == 'vimeo') {
			tg_vimeo_video_player($atts);
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
	if (get_option('tg_lp_hide_feature_image') != 'yes') {
		include(TG_DIR_PATH . '/view/front/user-lesson-single-featured-image.php');
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
	if (get_option('tg_lp_hide_lesson_desc') != 'yes') {
		include(TG_DIR_PATH . '/view/front/user-lesson-single-content.php');
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
	if (get_option('tg_lp_hide_lesson_resource') != 'yes') {
		include(TG_DIR_PATH . '/view/front/user-lesson-single-resources.php');
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
	if (get_option('tg_lp_hide_lesson_prev_next_nav') != 'yes') {
		include(TG_DIR_PATH . '/view/front/user-lesson-single-next-prev-links.php');
	}
	do_action('the_lesson_single_next_prev_links_bottom', $lesson);
}

/**
 * Render lesson youtube video markeup
 *
 * @param array $args {
 * 			$post_id
 * 			}
 * @return void
 */
function tg_youtube_video_player( $args = [] ) {
	
	if ( empty( $args['post_id'] ) ) {
		return false;
	}

	$lesson_id = $args['post_id'];

	$video_url = get_post_meta( $lesson_id, 'video_url', true);
	if ( empty( $video_url ) ) {
		return false;
	}

	$percent = get_post_meta( $lesson_id, 'video_minimum_percentage', true);
	$video_id = tg_youtube_video_id( $video_url );

	include TG_DIR_PATH . '/view/front/youtube.php';
	include TG_DIR_PATH . '/youtube/script.php';
}

/**
 * Render lesson vimeo video markeup
 *
 * @param array $args {
 * 			$post_id
 * 			}
 * @return void
 */
function tg_vimeo_video_player( $args = [] ) {
	if ( empty( $args['post_id'] ) ) {
		return false;
	}

	$lesson_id = $args['post_id'];

	$video_url = get_post_meta( $lesson_id, 'video_url', true );
	if ( empty( $video_url ) ) {
		return false;
	}

	$percent = get_post_meta( $lesson_id, 'video_minimum_percentage', true );
	$video_id = tg_vimeo_video_id( $video_url );

	include(TG_DIR_PATH . '/view/front/vimeo.php');
	include(TG_DIR_PATH . '/vimeo/script.php');
}
