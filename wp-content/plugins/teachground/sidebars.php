<?php
function tg_register_sidebars() {
    register_sidebar(
        array(
        'id' => 'tg_course_sidebar',
        'name' => __( 'Course Sidebar', 'teachground' ),
        'description' => __( 'Sidebar to display in course pages.', 'teachground'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    	)
    );
	 register_sidebar(
        array(
        'id' => 'tg_lesson_sidebar',
        'name' => __( 'Lesson Sidebar', 'teachground' ),
        'description' => __( 'Sidebar to display in lesson pages.', 'teachground' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    	)
    );
}