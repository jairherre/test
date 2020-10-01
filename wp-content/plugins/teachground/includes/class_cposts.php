<?php

class class_cposts {
	
	public $course_title = 'Course';
	public $course_title_plural = 'Courses';

	public $lesson_title = 'Lesson';
	public $lesson_title_plural = 'Lessons';

	public function __construct(){
		add_action( 'init', array( $this, 'codex_reg_access_management' ) );
		add_action( 'init', array( $this, 'codex_reg_course' ) );
		add_action( 'init', array( $this, 'codex_reg_lesson' ) );
		add_action( 'init', array( $this, 'codex_reg_tg_resource' ) );

		add_action( 'init', array( $this, 'codex_reg_course_tax' ) );

		//add_action('admin_head', array( $this, 'tg_hack_for_tax_menu' ) );

		if(get_option('tg_course_name')){
			$this->course_title = get_option('tg_course_name');
		}
		if(get_option('tg_course_name_plural')){
			$this->course_title_plural = get_option('tg_course_name_plural');
		}
		if(get_option('tg_lesson_name')){
			$this->lesson_title = get_option('tg_lesson_name');
		}
		if(get_option('tg_lesson_name_plural')){
			$this->lesson_title_plural = get_option('tg_lesson_name_plural');
		}

	}
	
	public function codex_reg_access_management() {
		$labels = array(
		'name'               => _x( 'Access Management', 'post type general name', 'teachground' ),
		'singular_name'      => _x( 'Access Management', 'post type singular name', 'teachground' ),
		'menu_name'          => _x( 'Access Management', 'admin menu', 'teachground' ),
		'name_admin_bar'     => _x( 'Access Management', 'add new on admin bar', 'teachground' ),
		'add_new'            => _x( 'Add New', 'Access Management', 'teachground' ),
		'add_new_item'       => __( 'Add New Access Management', 'teachground' ),
		'new_item'           => __( 'New Access Management', 'teachground' ),
		'edit_item'          => __( 'Edit Access Management', 'teachground' ),
		'view_item'          => __( 'View Access Managements', 'teachground' ),
		'all_items'          => __( 'All Access Managements', 'teachground' ),
		'search_items'       => __( 'Search Access Managements', 'teachground' ),
		'parent_item_colon'  => __( 'Parent Access Management:', 'teachground' ),
		'not_found'          => __( 'No Access Managements found.', 'teachground' ),
		'not_found_in_trash' => __( 'No Access Managements found in Trash.', 'teachground' )
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'show_in_rest'       => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 24,
			'supports'           => array( 'title', 'author' )
		);
	
		register_post_type( 'tg_access_mgmt', $args );
	}
	
	public function codex_reg_course() {

		$course_slug = sanitize_title($this->course_title);

		$labels = array(
		'name'               => _x( $this->course_title, 'post type general name', 'teachground' ),
		'singular_name'      => _x( $this->course_title, 'post type singular name', 'teachground' ),
		'menu_name'          => _x( $this->course_title, 'admin menu', 'teachground' ),
		'name_admin_bar'     => _x( $this->course_title, 'add new on admin bar', 'teachground' ),
		'add_new'            => _x( 'Add New', $this->course_title, 'teachground' ),
		'add_new_item'       => __( 'Add New '. $this->course_title_plural, 'teachground' ),
		'new_item'           => __( 'New ' .  $this->course_title_plural, 'teachground' ),
		'edit_item'          => __( 'Edit ' . $this->course_title, 'teachground' ),
		'view_item'          => __( 'View ' . $this->course_title, 'teachground' ),
		'all_items'          => __( 'All ' . $this->course_title_plural, 'teachground' ),
		'search_items'       => __( 'Search ' . $this->course_title_plural, 'teachground' ),
		'parent_item_colon'  => __( 'Parent ' . $this->course_title, 'teachground' ),
		'not_found'          => __( 'No ' . $this->course_title_plural . ' found.', 'teachground' ),
		'not_found_in_trash' => __( 'No ' . $this->course_title_plural . ' found in Trash.', 'teachground' )
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_in_admin_bar'  => true,
			'query_var'          => true,
			'show_in_rest'       => true,
			'rewrite'            => array( 'slug' => $course_slug, 'with_front' => false ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'supports'           => array( 'title', 'author', 'editor', 'excerpt', 'thumbnail', 'page-attributes' )
		);
	
		register_post_type( 'tg_course', $args );
	}
	
	public function codex_reg_lesson() {

		$lesson_slug = sanitize_title($this->lesson_title);

		$labels = array(
		'name'               => _x( $this->lesson_title, 'post type general name', 'teachground' ),
		'singular_name'      => _x( $this->lesson_title, 'post type singular name', 'teachground' ),
		'menu_name'          => _x( $this->lesson_title, 'admin menu', 'teachground' ),
		'name_admin_bar'     => _x( $this->lesson_title, 'add new on admin bar', 'teachground' ),
		'add_new'            => _x( 'Add New', $this->lesson_title, 'teachground' ),
		'add_new_item'       => __( 'Add New ' . $this->lesson_title, 'teachground' ),
		'new_item'           => __( 'New ' . $this->lesson_title_plural, 'teachground' ),
		'edit_item'          => __( 'Edit ' . $this->lesson_title_plural, 'teachground' ),
		'view_item'          => __( 'View ' . $this->lesson_title, 'teachground' ),
		'all_items'          => __( 'All ' . $this->lesson_title_plural, 'teachground' ),
		'search_items'       => __( 'Search ' . $this->lesson_title_plural, 'teachground' ),
		'parent_item_colon'  => __( 'Parent ' . $this->lesson_title, 'teachground' ),
		'not_found'          => __( 'No ' . $this->lesson_title_plural . ' found.', 'teachground' ),
		'not_found_in_trash' => __( 'No ' . $this->lesson_title_plural . ' found in Trash.', 'teachground' )
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_in_admin_bar'  => true,
			'query_var'          => true,
			'show_in_rest'       => true,
			'rewrite'            => array( 'slug' => $lesson_slug, 'with_front' => false ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 21,
			'supports'           => array( 'title', 'author', 'editor', 'excerpt', 'thumbnail' )
		);
	
		register_post_type( 'tg_lesson', $args );
	}
	
	public function codex_reg_tg_resource() {
		$labels = array(
		'name'               => _x( 'Resource', 'post type general name', 'teachground' ),
		'singular_name'      => _x( 'Resource', 'post type singular name', 'teachground' ),
		'menu_name'          => _x( 'Resource', 'admin menu', 'teachground' ),
		'name_admin_bar'     => _x( 'Resource', 'add new on admin bar', 'teachground' ),
		'add_new'            => _x( 'Add New', 'Resource', 'teachground' ),
		'add_new_item'       => __( 'Add New Resource', 'teachground' ),
		'new_item'           => __( 'New Resources', 'teachground' ),
		'edit_item'          => __( 'Edit Resources', 'teachground' ),
		'view_item'          => __( 'View Resource', 'teachground' ),
		'all_items'          => __( 'All Resources', 'teachground' ),
		'search_items'       => __( 'Search Resources', 'teachground' ),
		'parent_item_colon'  => __( 'Parent Resource:', 'teachground' ),
		'not_found'          => __( 'No Resources found.', 'teachground' ),
		'not_found_in_trash' => __( 'No Resources found in Trash.', 'teachground' )
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'tg-resource', 'with_front' => false ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 22,
			'supports'           => array( 'title', 'author' )
		);
	
		register_post_type( 'tg_resource', $args );
	}

	public function codex_reg_course_tax() {
		$labels = array(
			'name'              => _x( 'Category', 'taxonomy general name' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Category' ),
			'all_items'         => __( 'All Category' ),
			'parent_item'       => __( 'Parent Category' ),
			'parent_item_colon' => __( 'Parent Category:' ),
			'edit_item'         => __( 'Edit Category' ),
			'update_item'       => __( 'Update Category' ),
			'add_new_item'      => __( 'Add New Category' ),
			'new_item_name'     => __( 'New Category' ),
			'menu_name'         => __( 'Category' ),
		);
	
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => 'course-category',
			'rewrite'           => array( 'slug' => 'course-category' ),
		);
	
		register_taxonomy( 'tg_course_category', array( 'tg_course' ), $args );
	}
	
	public function tg_hack_for_tax_menu(){
    	$screen = get_current_screen();
		if( $screen->base === 'edit-tags' && $screen->taxonomy === 'tg_course_category' ){
			wp_enqueue_script( 'tg-script-admin-menu', plugins_url( TG_DIR_NAME . '/js/tg-script-admin-menu.js' ) );
		}
	}
}



