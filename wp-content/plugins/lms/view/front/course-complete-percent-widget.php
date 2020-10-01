<?php
if( !empty($course_complete_data)){
?>
    <div class="course-complete-percent-widget">
   		<div class="course-complete-percent-cont-widget">
    		<div class="course-complete-percent-bar-widget" style="width:<?php echo $course_complete_data['percentage'];?>%;"></div>
     	</div>
        <p><?php echo $course_complete_data['percentage'];?>% <?php _e('course is completed','lms');?></p>
     </div>
<?php
}

