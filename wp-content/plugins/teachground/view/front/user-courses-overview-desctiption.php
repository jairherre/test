<?php
/**
 * Course overview description template
 */

defined( 'ABSPATH' ) || exit;
?>

<p class="tg-CourseCard__excerpt"><?php tg_the_excerpt( $course->ID, 70 ); ?></p>
