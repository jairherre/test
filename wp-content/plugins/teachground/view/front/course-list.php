<?php
/**
 * Course list template
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $courses ) ) {
	return;
}
?>

<div class="tg-CourseList">
	<?php foreach ( $courses as $course ) : ?>
		<div class="tg-CourseList__item tg-CourseCard">
			<?php
			if ( $args['show_image'] === 'yes' ) {
				the_course_overview_thumbnail( $course );
			}
			if ( $args['show_title'] === 'yes' ) {
				the_course_overview_title( $course );
			}
			if ( $args['show_excerpt'] === 'yes' ) {
				the_course_overview_description( $course );
			}
			?>
			<div class="tg-CourseCard__meta">
				<?php
				if ( $args['show_progressbar'] === 'yes' ) {
					the_course_overview_percentage_bar( $course );
				}
				if ( $args['show_author'] === 'yes' ) {
					the_course_overview_author( $course );
				}
				if ( $args['show_completed'] === 'yes' ) {
					the_course_overview_percentage( $course );
				}
				?>
			</div>
		</div>

	<?php endforeach; ?>
</div>
