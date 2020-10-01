<table width="100%" border="0">
<tr>
  <td width="200"><h3><?php _e('Course Overview','lms');?></h3></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_co_hide_feature_image" value="yes" <?php echo ($lms_co_hide_feature_image == 'yes'?'checked':'');?>> <?php _e('Hide Feature Image','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_co_hide_course_title" value="yes" <?php echo ($lms_co_hide_course_title == 'yes'?'checked':'');?>> <?php _e('Hide Course Title','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_co_hide_course_desc" value="yes" <?php echo ($lms_co_hide_course_desc == 'yes'?'checked':'');?>> <?php _e('Hide Course Description','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_co_hide_progress_bar" value="yes" <?php echo ($lms_co_hide_progress_bar == 'yes'?'checked':'');?>> <?php _e('Hide Progress Bar','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_co_hide_author" value="yes" <?php echo ($lms_co_hide_author == 'yes'?'checked':'');?>> <?php _e('Hide Author Name','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_co_hide_progress_percentage" value="yes" <?php echo ($lms_co_hide_progress_percentage == 'yes'?'checked':'');?>> <?php _e('Hide Progress %','lms');?></label></td>
</tr>
<tr>
  <td width="200"><h3><?php _e('Course Pages','lms');?></h3></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_cp_hide_feature_image" value="yes" <?php echo ($lms_cp_hide_feature_image == 'yes'?'checked':'');?>> <?php _e('Hide Feature Image','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_cp_hide_course_title" value="yes" <?php echo ($lms_cp_hide_course_title == 'yes'?'checked':'');?>> <?php _e('Hide Course Title','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_cp_hide_course_desc" value="yes" <?php echo ($lms_cp_hide_course_desc == 'yes'?'checked':'');?>> <?php _e('Hide Course Description','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_cp_hide_lesson_list" value="yes" <?php echo ($lms_cp_hide_lesson_list == 'yes'?'checked':'');?>> <?php _e('Hide Lesson List','lms');?></label></td>
</tr>
<tr>
  <td width="200"><h3><?php _e('Lesson Pages','lms');?></h3></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_lp_hide_feature_image" value="yes" <?php echo ($lms_lp_hide_feature_image == 'yes'?'checked':'');?>> <?php _e('Hide Feature Image','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_lp_hide_lesson_title" value="yes" <?php echo ($lms_lp_hide_lesson_title == 'yes'?'checked':'');?>> <?php _e('Hide Lesson Title','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_lp_hide_lesson_desc" value="yes" <?php echo ($lms_lp_hide_lesson_desc == 'yes'?'checked':'');?>> <?php _e('Hide Lesson Description','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_lp_hide_lesson_resource" value="yes" <?php echo ($lms_lp_hide_lesson_resource == 'yes'?'checked':'');?>> <?php _e('Hide Lesson Resource','lms');?></label></td>
</tr>
<tr>
  <td><label><input type="checkbox" name="lms_lp_hide_lesson_prev_next_nav" value="yes" <?php echo ($lms_lp_hide_lesson_prev_next_nav == 'yes'?'checked':'');?>> <?php _e('Hide Previous/Next Lesson Navigation','lms');?></label></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Submit','lms');?>"></td>
</tr>
</table>