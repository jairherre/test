<?php
/**
 * Course overview thumbnail template
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( get_the_post_thumbnail( $course->ID, 'full' ) ) : ?>
	<figure class="lms-CourseCard__figure">
		<a href="<?php echo get_permalink( $course->ID ); ?>">
			<?php echo get_the_post_thumbnail( $course->ID, 'full' ); ?>
		</a>
	</figure>
<?php endif; ?>
