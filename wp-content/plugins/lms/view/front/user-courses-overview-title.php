<?php
/**
 * Course overview title template
 */

defined( 'ABSPATH' ) || exit;
?>

<h2 class="lms-CourseCard__title">
	<a href="<?php echo get_permalink( $course->ID ); ?>"><?php echo lms_limit_text( $course->post_title, 20 ); ?></a>
</h2>
