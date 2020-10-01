<?php get_header(); ?>

<div id="primary" class="content-area col-md-8">
    <div class="lms-row">
	<?php
        if( have_posts() ){				
            while (have_posts()) { 
                the_post();		
                the_course_single_title( $post );
                the_course_single_featured_image( $post );
				$status = lms_does_course_has_rules( $post );
				if( $status['status'] == true ){
                	the_course_single_content( $post );
                	the_course_single_lessons( $post );
				} else {
					echo $status['msg'];
				}
            }
        }
        wp_reset_postdata();
    ?>		
    </div>
</div>
<?php get_sidebar();?>
<?php get_footer(); ?>				