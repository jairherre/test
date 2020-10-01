<?php
/**
 * All shortcodes definations
 */

defined( 'ABSPATH' ) || exit;

/**
 * Lesson list shortcode
 *
 * Output formatted lesson list.
 *
 * Usage: [lms_lesson_list section="3,4"]
 *
 * @param array $atts
 * @return string
 */
function lms_lesson_list_shortcode( $atts = array() ) {
	$atts = shortcode_atts( array(
		'section' => '',
	), $atts );

	ob_start();

	$status = lms_is_current_user_assigned_to_course();

	if ( ! $status['status'] == true ) {

		if ( $atts['section'] == '') {

			the_lessons();

		} else {

			$section_ids = wp_parse_id_list( $atts['section'] );

			foreach ( $section_ids as $section_id ) {
				the_lessons_on_section( $section_id );
			}
		}

	} else {
		echo $status['msg'];
	}

	$data = ob_get_clean();
	return $data;
}

add_shortcode( 'lms_lesson_list', 'lms_lesson_list_shortcode' );

/*
display course complete percentage bar
parameters - NA
shortcode [lms_progress]
*/
add_shortcode('lms_progress', 'lms_progress_sc');

// display course progress percentage bar
function lms_progress_sc($atts)
{
	$atts = shortcode_atts(array(
		'post_id' => '',
	), $atts);
	ob_start();
	$status = lms_is_current_user_assigned_to_course($atts['post_id']);
	if ($status['status'] == true) {
		the_course_complete_percent_bar($atts['post_id']);
	} else {
		echo $status['msg'];
	}
	$data = ob_get_contents();
	ob_end_clean();
	return $data;
}

/*
display cousres assigned to user
parameters - orderby(date,title), order(desc,asc)
shortcode [lms_user_courses orderby="date" order="desc"]
*/
add_shortcode( 'lms_user_courses', 'lms_user_courses_shortcode' );

// display cousres assigned to user
function lms_user_courses_shortcode( $atts = array() ) {
	$atts = shortcode_atts( array(
		'orderby'    => 'date',
		'order'      => 'desc',
		'categories' => '',

		'show_featured_image' => 'yes',
		'show_title'          => 'yes',
		'show_excerpt'        => 'yes',
		'show_progressbar'    => 'yes',
		'show_author'         => 'yes',
		'show_completed'      => 'yes',
	), $atts );

	ob_start();
	lms_courses_assigned_to_user( $atts );
	$data = ob_get_clean();;
	return $data;
}

/*
display all cousres
parameters - orderby(date,title), order(desc,asc), id
shortcode [lms_all_courses orderby="date" order="desc" id="2"]
*/
add_shortcode( 'lms_all_courses', 'lms_all_courses_shortcode' );

// display all cousres
function lms_all_courses_shortcode( $atts = array() ) {
	$atts = shortcode_atts( array(
		'orderby'        => 'date',
		'order'          => 'desc',
		'id'             => '',
		'categories'     => '',
		'assigned_first' => 'no',

		'show_featured_image' => 'yes',
		'show_title'          => 'yes',
		'show_excerpt'        => 'yes',
		'show_progressbar'    => 'yes',
		'show_author'         => 'yes',
		'show_completed'      => 'yes',
	), $atts );

	ob_start();
	lms_all_courses( $atts );
	$data = ob_get_clean();
	return $data;
}

/*
display video
parameters - post_id
shortcode [lms_video post_id="2"]
*/
add_shortcode('lms_video', 'lms_video_sc');

// display video
function lms_video_sc($atts)
{
	if (is_user_logged_in()) {
		$atts = shortcode_atts(array(
			'post_id' => '',
			//'width' => 500,
			//'height' => 300
		), $atts);
		ob_start();
		$video_url = get_post_meta($atts['post_id'], 'video_url', true);
		$video_type = lms_video_type($video_url);
		if ($video_type == 'youtube') {
			lms_youtube_video_player($atts);
		} elseif ($video_type == 'vimeo') {
			lms_vimeo_video_player($atts);
		}
		$data = ob_get_contents();
		ob_end_clean();
		return $data;
	} else {
		return '<h5>Please login to view this content</h5>';
	}
}

/*
display lesson excerpt
parameters - post_id
shortcode [lms_lesson_excerpt post_id="2"]
*/
add_shortcode('lms_lesson_excerpt', 'lms_lesson_excerpt_sc');

// display lesson excerpt
function lms_lesson_excerpt_sc($atts)
{
	$atts = shortcode_atts(array(
		'post_id' => '',
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '15',
		'font-weight' => 'normal',
	), $atts);
	if ($atts['post_id']) {
		return '<span style="font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_excerpt($atts['post_id']) . '</span>';
	} else {
		return '<span style="font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_excerpt() . '</span>';
	}
}

/*
display lesson content
parameters - post_id
shortcode [lms_lesson_content post_id="2"]
*/
add_shortcode('lms_lesson_content', 'lms_lesson_content_sc');

// display lesson content
function lms_lesson_content_sc($atts)
{
	$atts = shortcode_atts(array(
		'post_id' => '',
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '15',
		'font-weight' => 'normal',
		'align' => 'left',
	), $atts);
	if ($atts['post_id']) {
		return '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_content($atts['post_id']) . '</span>';
	} else {
		return '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_content() . '</span>';
	}
}

/*
display lesson title
parameters - post_id
shortcode [lms_lesson_title post_id="2"]
*/
add_shortcode('lms_lesson_title', 'lms_lesson_title_sc');

// display lesson title
function lms_lesson_title_sc($atts)
{
	$atts = shortcode_atts(array(
		'post_id' => '',
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '20',
		'font-weight' => 'normal',
		'align' => 'left',
	), $atts);
	if ($atts['post_id']) {
		return '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_title($atts['post_id']) . '</span>';
	} else {
		return '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_title() . '</span>';
	}
}

/*
display course content
parameters - post_id
shortcode [lms_course_content post_id="2"]
*/
add_shortcode('lms_course_content', 'lms_course_content_sc');

// display course content
function lms_course_content_sc($atts)
{
	$atts = shortcode_atts(array(
		'post_id' => '',
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '20',
		'font-weight' => 'normal',
		'align' => 'left',
	), $atts);
	if ($atts['post_id']) {
		return '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_content($atts['post_id']) . '</span>';
	} else {
		return '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_content() . '</span>';
	}
}

/*
display course title
parameters - post_id
shortcode [lms_course_title post_id="2"]
*/
add_shortcode('lms_course_title', 'lms_course_title_sc');

// display course title
function lms_course_title_sc($atts)
{
	$atts = shortcode_atts(array(
		'post_id' => '',
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '20',
		'font-weight' => 'normal',
		'align' => 'left',
	), $atts);
	if ($atts['post_id']) {
		return  '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_title($atts['post_id']) . '</span>';
	} else {
		return  '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_title() . '</span>';
	}
}

// display lesson resources
function lms_resources_shortcode( $atts = array() ) {
	$atts = shortcode_atts( array(
		'lesson_id' => 0,
	), $atts );

	ob_start();

	$lesson_id = trim( $atts['lesson_id'] );

	the_lms_resources( $lesson_id );

	$data = ob_get_clean();

	return $data;
}

/*
display lesson resources
parameters - post_id
shortcode [lms_resources post_id="2"]
*/
add_shortcode( 'lms_resources', 'lms_resources_shortcode' );

/*
display lesson mark complete form
parameters - post_id
shortcode [lms_button post_id="2"]
*/
add_shortcode('lms_button', 'lms_button_sc');

// display lesson mark complete form
function lms_button_sc($atts)
{
	$atts = shortcode_atts(array(
		'post_id' => '',
		'caption' => '',
		'cc_caption' => ''
	), $atts);
	ob_start();
	if ($atts['post_id']) {
		$lesson = get_post($atts['post_id']);
		the_mark_lesson_as_complete_from($lesson, $atts['caption'], $atts['cc_caption']);
	} else {
		the_mark_lesson_as_complete_from(null, $atts['caption'], $atts['cc_caption']);
	}
	$data = ob_get_contents();
	ob_end_clean();
	return $data;
}


/*
display list of lessons widget
parameters - post_id
shortcode [lms_navigation_widget enable_collapsable_outlines="on" enable_open_close_all="on"]
*/
add_shortcode('lms_navigation_widget', 'lms_navigation_widget_sc');

// display list of lessons widget
function lms_navigation_widget_sc($atts)
{
	$atts = shortcode_atts(array(
		'enable_collapsable_outlines' => '',
		'enable_open_close_all' => ''
	), $atts);

	if (!is_singular('lms_course') && !is_singular('lms_lesson')) {
		return;
	}
	if (!is_user_logged_in()) {
		return;
	}

	ob_start();
	$instance = array('wid_enable_collapsable_outlines' => $atts['enable_collapsable_outlines'], 'wid_enable_open_close_all' => $atts['enable_open_close_all']);
	the_lessons_widget($instance);
	$data = ob_get_contents();
	ob_end_clean();
	return $data;
}

/*
display next lesson link
parameters - course_ids, link_text, not_found_text
shortcode [lms_next_lesson_link courses="2,5" link_text="Go to next lesson" not_found_text="All are done :)"]
*/
add_shortcode( 'lms_next_lesson_link', 'lms_next_lesson_link_sc' );

// display next lesson link
function lms_next_lesson_link_sc( $atts ){
	$atts = shortcode_atts( array(
		'courses' => '',
		'link_text' => '',
		'not_found_text' => __('All are completed','lms')
	), $atts );
	ob_start();

	if(is_user_logged_in()){
		$ret = get_global_next_lesson_link($atts);
		if($ret['status'] == true){
			$lesson_id = $ret['lesson_id'];
			echo '<a href="'.get_permalink($lesson_id).'" class="next-lesson-global-link">'.
			($atts['link_text']!=''?$atts['link_text']:get_the_title($lesson_id))
			.'</a>';
		} else{
			echo $atts['not_found_text'];
		}
	}

	$data = ob_get_contents();
	ob_end_clean();
	return $data;
}
