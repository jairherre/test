<div>
    <div style="float:right; margin-left:5px;"><a href="javascript:void(0)" id="add_rules" class="preview button"><?php _e('Add Rules','lms');?></a></div>
</div>	
<div id="rules_list" style="clear:both; width:100%; float:left; margin-top:5px;"><?php echo $rules;?></div>
<div id="rules-assign-form" title="<?php _e('Assign Rules','lms');?>">
     <div class="lms-popup-form-inner">
        <p><select name="first_course_id" id="first_course_id" class="widefat">
            <?php echo $this->get_courses_selected();?>
        </select></p>
        <p> <?php _e('Must be completed before starting');?> </p>
        <p><select name="second_course_id" id="second_course_id" class="widefat">
            <?php echo $this->get_courses_selected();?>
        </select></p>
     </div>
</div>