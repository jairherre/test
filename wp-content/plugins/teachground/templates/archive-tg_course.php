<?php get_header(); ?>

<div id="primary" class="content-area col-md-8">
    <div class="tg-row">
	<?php
        if( have_posts() ){				
            while (have_posts()) { 
                the_post();		
                ?>
                <header class="entry-header">
                    <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php
                        /* translators: %s: Name of current post */
                        the_content( sprintf(
                            __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'aldehyde' ),
                            the_title( '<span class="screen-reader-text">"', '"</span>', false )
                        ) );
                    ?>

                    <?php
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . __( 'Pages:', 'aldehyde' ),
                            'after'  => '</div>',
                        ) );
                    ?>
                </div>

                <?php 
            }
        }
        wp_reset_postdata();
    ?>		
    </div>
</div>
<?php get_sidebar();?>
<?php get_footer(); ?>				