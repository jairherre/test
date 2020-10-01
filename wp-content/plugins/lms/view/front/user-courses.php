<?php
/**
 * User courses template
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $courses ) ) {
	return;
}
?>

<div class="lms-CoursesList">
<?php
foreach ( $courses as $course ) : setup_postdata( $course );
	?>

	<div class="lms-CoursesList__item lms-CourseCard">
		<?php
		if ( $atts['show_featured_image'] === 'yes' ) {
			the_course_overview_thumbnail( $course );
		}
		if ( $atts['show_title'] === 'yes' ) {
			the_course_overview_title( $course );
		}
		if ( $atts['show_excerpt'] === 'yes' ) {
			the_course_overview_description( $course );
		}
		?>
		<div class="lms-CourseCard__meta">
			<?php
			if ( $atts['show_progressbar'] === 'yes' ) {
				the_course_overview_percentage_bar( $course );
			}
			if ( $atts['show_author'] === 'yes' ) {
				the_course_overview_author( $course );
			}
			if ( $atts['show_completed'] === 'yes' ) {
				the_course_overview_percentage( $course );
			}
			?>
		</div>
	</div>

	<?php
endforeach; wp_reset_postdata();
?>
</div>
