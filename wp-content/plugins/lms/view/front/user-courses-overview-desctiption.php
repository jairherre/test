<?php
/**
 * Course overview description template
 */

defined( 'ABSPATH' ) || exit;
?>

<p class="lms-CourseCard__excerpt"><?php lms_the_excerpt( $course->ID, 70 ); ?></p>
