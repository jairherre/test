<div class="lms-lesson-completed">
    <div class="lms-form">
        <form name="mark-lesson-uncomplete" id="mark-lesson-uncomplete" method="post">
            <input type="hidden" name="option" value="mark_lesson_uncomplete">
            <?php wp_nonce_field('lms_front_data_action', 'lms_front_data_field'); ?>
            <input type="hidden" name="l_id" id="l_id" value="<?php echo $post->ID; ?>">
            <input type="hidden" name="mark_uncomplete" value="Yes">

            <div class="lms-input">
                <input type="submit" name="submit" id="mark-lesson-uncomplete-submit" value="<?php echo $msg; ?>">
            </div>
        </form>
    </div>
</div>