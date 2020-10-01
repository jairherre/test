<?php
defined( 'ABSPATH' ) || exit;

if ( empty( $lessons ) ) {
	_e( 'No lessons found', 'lms' );
	return;
}

foreach ( $lessons as $value ) :
	if ( empty( $value['s_id']['lessons'] ) && empty( $value['s_id']['id'] ) ) {
		continue;
	}
	?>

	<div class="lms-LessonsListSection">
		<?php if ( $value['s_id']['id'] ) : ?>
			<h3 class="lms-LessonsListTitle"><?php echo lms_get_section_name( $value['s_id']['id'] );?></h3>
		<?php endif; ?>

		<?php
		if ( ! empty( $value['s_id']['lessons'] ) ) :
			$lesson_count = count( $value['s_id']['lessons'] );
			$count = 1;
			?>

			<ol class="lms-LessonsList">

			<?php
			foreach ( $value['s_id']['lessons'] as $lesson ) :
				$is_complete = lms_is_lesson_marked_as_completed( get_current_user_id(), $lesson );
				$status = lms_is_current_user_assigned_to_lesson( $lesson );
				$delay = lms_get_current_user_lesson_delay( $lesson );
				?>

				<li class="lms-LessonsList__lesson">
					<?php if ( $status['status'] == true ) : ?>
						<a href="<?php echo get_permalink( $lesson );?>" class="lms-LessonsList__lessonTitle">
					<?php else: ?>
						<a href="javascript:void(0);" class="lms-LessonsList__lessonTitle">
					<?php endif; ?>

						<?php if ( $is_complete == true ) : ?>
							<i class="fas fa-check-square lms-LessonsList__lessonIcon"></i>
						<?php else: ?>
							<i class="far fa-square lms-LessonsList__lessonIcon"></i>
						<?php endif; ?>

						<?php echo get_the_title( $lesson ); ?>
					</a>

					<?php if ( $delay['status'] == true ) : ?>
						<span class="lms-LessonsList__lessonDelay"><?php echo sprintf( __( 'Available in %s Days', 'lms' ), $delay['msg'] );?></span>
					<?php endif; ?>

					<?php if ( is_lesson_free( $lesson) ) : ?>
						<span class="lms-LessonsList__lessonFree"><?php _e( 'Free', 'lms' );?></span>
					<?php endif ?>

					<?php if ( has_excerpt( $lesson ) ) : ?>
						<p class="lms-LessonsList__lessonExcerpt"><?php lms_the_excerpt( $lesson, 140 ); ?></p>
					<?php endif; ?>
				</li>

				<?php
				$count++;
			endforeach;

			echo '</ol>';

		endif;

	echo '</div><!-- /.lms-LessonsListWrap -->';

endforeach;
