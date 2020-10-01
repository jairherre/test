<?php
defined( 'ABSPATH' ) || exit;

if ( empty( $lessons ) ) {
	_e( 'No lessons found', 'teachground' );
	return;
}

foreach ( $lessons as $value ) :
	if ( empty( $value['s_id']['lessons'] ) && empty( $value['s_id']['id'] ) ) {
		continue;
	}
	?>

	<div class="tg-LessonListSection">
		<?php if ( $value['s_id']['id'] ) : ?>
			<h3 class="tg-LessonListTitle"><?php echo tg_get_section_name( $value['s_id']['id'] );?></h3>
		<?php endif; ?>

		<?php
		if ( ! empty( $value['s_id']['lessons'] ) ) :
			$lesson_count = count( $value['s_id']['lessons'] );
			$count = 1;
			?>

			<ol class="tg-LessonList">

			<?php
			foreach ( $value['s_id']['lessons'] as $lesson ) :
				$is_complete = tg_is_lesson_marked_as_completed( get_current_user_id(), $lesson );
				$status = tg_is_current_user_assigned_to_lesson( $lesson );
				$delay = tg_get_current_user_lesson_delay( $lesson );
				?>

				<li class="tg-LessonList__lesson">
					<?php if ( $status['status'] == true ) : ?>
						<a href="<?php echo get_permalink( $lesson );?>" class="tg-LessonList__lessonTitle">
					<?php else: ?>
						<a href="javascript:void(0);" class="tg-LessonList__lessonTitle">
					<?php endif; ?>

						<?php if ( $is_complete == true ) : ?>
							<i class="fas fa-check-square tg-LessonList__lessonIcon"></i>
						<?php else: ?>
							<i class="far fa-square tg-LessonList__lessonIcon"></i>
						<?php endif; ?>

						<?php echo get_the_title( $lesson ); ?>
					</a>

					<?php if ( $delay['status'] == true ) : ?>
						<span class="tg-LessonList__lessonDelay"><?php echo sprintf( __( 'Available in %s Days', 'teachground' ), $delay['msg'] );?></span>
					<?php endif; ?>

					<?php if ( is_lesson_free( $lesson) ) : ?>
						<span class="tg-LessonList__lessonFree"><?php _e( 'Free', 'teachground' );?></span>
					<?php endif ?>

					<?php if ( has_excerpt( $lesson ) ) : ?>
						<p class="tg-LessonList__lessonExcerpt"><?php tg_the_excerpt( $lesson, 140 ); ?></p>
					<?php endif; ?>
				</li>

				<?php
				$count++;
			endforeach;

			echo '</ol>';

		endif;

	echo '</div><!-- /.tg-LessonListWrap -->';

endforeach;
