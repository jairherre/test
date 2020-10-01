<div class="lms-form">
    <form name="mark-lesson-complete" id="mark-lesson-complete" method="post">
        <input type="hidden" name="option" value="mark_lesson_complete">
        <?php wp_nonce_field('lms_front_data_action', 'lms_front_data_field'); ?>
        <input type="hidden" name="l_id" id="l_id" value="<?php echo $post->ID; ?>">
        <input type="hidden" name="mark_complete" value="Yes">

        <div class="lms-input text-right">
            <input type="submit" name="submit" id="mark-lesson-complete-submit" value="<?php echo $msg; ?>">
        </div>
    </form>
</div>