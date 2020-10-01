<?php
if( !empty($course_complete_data)){
?>
	<?php echo $course_complete_data['percentage'];?>% <?php _e('course is completed','teachground');?>
    <div class="course-complete-percent-cont"><div class="course-complete-percent-bar" style="width:<?php echo $course_complete_data['percentage'];?>%;"></div></div>
<?php
}

