<?php
$prev_lesson = lms_get_prev_lesson_link();
$next_lesson = lms_get_next_lesson_link();
?>
<div class="lms-next-prev-links">
	<?php if( $prev_lesson ){ ?>
        <a href="<?php echo $prev_lesson['link'];?>" class="lms-prev-lesson"><i class="fas fa-arrow-left"></i> <?php echo $prev_lesson['title'];?></a>
    <?php } ?>
    <?php if( $next_lesson ){ ?>
        <a href="<?php echo $next_lesson['link'];?>" class="lms-next-lesson"><?php echo $next_lesson['title'];?><i class="fas fa-arrow-right"></i></a>
    <?php } ?>
</div>