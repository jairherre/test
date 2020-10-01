<?php get_header(); ?>

<div id="primary" class="content-area col-md-8">
    <div class="lms-row">
	<?php
        if( have_posts() ){
            while (have_posts()) {
                the_post();
                the_lesson_single_title( $post );
				the_lesson_single_featured_image( $post );
				
                $status = lms_is_current_user_assigned_to_lesson();
                if( $status['status'] == true ){
					the_lesson_video( $post );
                    the_lesson_single_content( $post );
                    the_lesson_single_resources( $post );
                    the_mark_lesson_as_complete_from( $post );
                    the_lesson_single_next_prev_links( $post );
                } else {
                    echo $status['msg'];
                }
            }
        }
    ?>
    </div>
</div>
<?php get_sidebar();?>
<?php get_footer(); ?>
