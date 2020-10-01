<?php
/**
 * Course overview thumbnail template
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( get_the_post_thumbnail( $course->ID, 'full' ) ) : ?>
	<a class="tg-CourseCard__figure" href="<?php echo get_permalink( $course->ID ); ?>">
		<?php echo get_the_post_thumbnail( $course->ID, 'full' ); ?>
	</a>
<?php endif; ?>
