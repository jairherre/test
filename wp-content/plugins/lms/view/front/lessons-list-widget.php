<div class="lessons-widget-cont">
	<?php

	//echo '<pre>';
	//print_r($lessons);

	if (!empty($lessons)) {
		$active_section_id = '';
		foreach ($lessons as $key => $value) {
	?>

			<?php if ($value['s_id']['id']) { ?>
				<h3 style="cursor: pointer" onclick="lmsOpenedSection('<?php echo $value['s_id']['id']; ?>')" class="wid-section-title <?php echo $classes; ?>"><?php echo lms_get_section_name($value['s_id']['id']); ?></h3>
			<?php } ?>

			<?php
			if (!empty($value['s_id']['lessons'])) {
				echo '<ul class="lms-lessons-widget sec-' . $value['s_id']['id'] . '">';
				foreach ($value['s_id']['lessons'] as $value1) {
					$is_complete = lms_is_lesson_marked_as_completed(get_current_user_id(), $value1);
					$status = lms_is_current_user_assigned_to_lesson($value1);
					$delay = lms_get_current_user_lesson_delay($value1);

					if (isset($lesson_id) && ($value1 == $lesson_id)) {
						$active_section_id = $value['s_id']['id'];
					}
			?>
					<li class="<?php echo ($is_complete == true ? 'lesson-completed' : ''); ?> <?php echo ($value1 == $post->ID ? 'lesson-active' : ''); ?>" title="<?php echo ($delay['status'] == true ? sprintf(__('This lesson will be made available in %s days', 'lms'), $delay['msg']) : ''); ?>"><?php echo ($is_complete == true ? '<i class="fas fa-check-square"></i>' : '<i class="far fa-square"></i>'); ?>

						<?php if ($status['status'] == true) { ?>
							<a href="<?php echo get_permalink($value1); ?>">
							<?php } ?>

							<?php echo get_the_title($value1); ?>

							<?php if ($status['status'] == true) { ?>
							</a>
						<?php } ?>

					</li>
		<?php
				}
				echo '</ul>';
			}
		} ?>

		<span onclick="lmsOpenedSection('open_all')"' class="toggle_all_secs"><?php echo  __('Toggle all', 'lms'); ?></span>
	<?php
	} else {
		echo '<p>' . __('No lessons found', 'lms') . '</p>';
	}
	?>

</div>

<?php if ($wid_enable_open_close_all) { ?>
	<div class="open-close-all"><button class="lessons-widget-openall" sec-data="<?php echo $active_section_id; ?>"><?php _e('Open All', 'lms'); ?> <i class="fas fa-angle-down"></i></button></div>
<?php } ?>

<script>
lmsOpenedSection(<?php echo $active_section_id; ?>); </script>