<?php
/**
 * Course overview percentage template
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="tg-CourseCard__completed"><?php echo get_course_complete_percent_text( $course->ID );?>% <?php _e( 'Completed','teachground' );?></div>
