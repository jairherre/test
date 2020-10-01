<?php
function lms_register_sidebars() {
    register_sidebar(
        array(
        'id' => 'lms_course_sidebar',
        'name' => __( 'Course Sidebar', 'lms' ),
        'description' => __( 'Sidebar to display in course pages.', 'lms'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    	)
    );
	 register_sidebar(
        array(
        'id' => 'lms_lesson_sidebar',
        'name' => __( 'Lesson Sidebar', 'lms' ),
        'description' => __( 'Sidebar to display in lesson pages.', 'lms' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    	)
    );
}