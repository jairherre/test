<?php
/**
 * Course overview percentage template
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="lms-CourseCard__completed"><?php echo get_course_complete_percent_text( $course->ID );?>% <?php _e( 'Completed','lms' );?></div>
