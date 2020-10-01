<?php
/**
 * Course overview title template
 */

defined( 'ABSPATH' ) || exit;
?>

<h2 class="tg-CourseCard__title">
	<a href="<?php echo get_permalink( $course->ID ); ?>"><?php echo tg_limit_text( $course->post_title, 20 ); ?></a>
</h2>
