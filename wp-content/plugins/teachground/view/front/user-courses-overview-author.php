<?php
/**
 * Course overview author template
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="tg-CourseCard__author"><?php echo get_the_author_meta( 'display_name', $course->post_author ); ?></div>
