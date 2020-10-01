<?php
/**
 * Lesson index template
 */
defined( 'ABSPATH' ) || exit;

if ( empty( $lessons ) ) {
	echo '<p class="tg-not-found">' . __( 'No lessons found', 'teachground' ) . '</p>';
	return;
}
?>

<div class="tg-LessonIndexSections">
	<?php
	$active_section_id = '';
	foreach ( $lessons as $key => $value ) :
		// Ignore empty index
		if ( empty( $value['s_id']['id'] ) || empty( $value['s_id']['lessons'] ) ) {
			continue;
		}
		?>

		<div class="tg-LessonIndexSection">
			<h3 class="tg-LessonIndexTitle"><?php echo tg_get_section_name( $value['s_id']['id'] ); ?></h3>

			<ul class="tg-LessonIndex tg-LessonIndex--<?php echo $value['s_id']['id']; ?>">

				<?php foreach ( $value['s_id']['lessons'] as $_lesson ) :
					$is_complete = tg_is_lesson_marked_as_completed( get_current_user_id(), $_lesson );
					$status = tg_is_current_user_assigned_to_lesson( $_lesson );
					$delay = tg_get_current_user_lesson_delay( $_lesson );

					if ( isset( $lesson_id ) && ( $_lesson == $lesson_id ) ) {
						$active_section_id = $value['s_id']['id'];
					}

					$_classes = ['tg-LessonIndex__lesson'];
					$_icon = '<i class="far fa-square tg-LessonIndex__lessonIcon"></i>';

					if ( $is_complete == true ) {
						$_classes[] = 'tg-LessonIndex__lesson--complete';
						$_icon = '<i class="fas fa-check-square tg-LessonIndex__lessonIcon"></i>';
					}

					if ( $_lesson == $post->ID ) {
						$_classes[] = 'tg-LessonIndex__lesson--active';
					}
					?>

					<li class="<?php echo esc_attr( implode( ' ', $_classes ) ); ?>" title="<?php echo ($delay['status'] == true ? sprintf(__('This lesson will be made available in %s days', 'teachground'), $delay['msg']) : ''); ?>">
						<?php
						echo $_icon;

						if ( $status['status'] == true ) {
							printf(
								'<a class="tg-LessonIndex__lessonLink" href="%s">%s</a>',
								get_permalink( $_lesson ),
								get_the_title( $_lesson )
							);
						} else {
							echo get_the_title( $_lesson );
						}
						?>
					</li>

				<?php endforeach; ?>

			</ul>
		</div>

	<?php endforeach; ?>

	<!-- <span onclick="lmsOpenedSection('open_all')"' class="toggle_all_secs"><?php echo  __( 'Toggle all', 'teachground' ); ?></span> -->

</div>

<?php if ( $wid_enable_open_close_all ) : ?>
	<div class="open-close-all">
		<button class="lessons-widget-openall" sec-data="<?php echo $active_section_id; ?>"><?php _e('Open All', 'teachground'); ?> <i class="fas fa-angle-down"></i></button>
	</div>
<?php endif; ?>

<script>lmsOpenedSection(<?php echo $active_section_id; ?>); </script>
