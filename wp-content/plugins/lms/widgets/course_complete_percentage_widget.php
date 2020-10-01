<?php

class course_complete_percentage_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'course_complete_percentage_widget',
			'Course Complete Percentage',
			array( 'description' => __( 'Display course completion percentage.', 'lms' ), )
		);
	 }

	public function widget( $args, $instance ) {
		if ( !is_singular( 'lms_course' ) && !is_singular( 'lms_lesson' ) ) {
			return;
		}
		if ( is_course_progress_disabled() ) {
			return;
		}
		if ( !is_user_logged_in() ) {
			return;
		}
		echo $args['before_widget'];
		if ( ! empty( $instance['wid_title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['wid_title'] ) . $args['after_title'];
		}
		$ccpw = new class_ccp_widget;
		$ccpw->view();
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['wid_title'] = strip_tags( $new_instance['wid_title'] );
		return $instance;
	}

	public function form( $instance ) {
		$wid_title = '';
		if(!empty($instance[ 'wid_title' ])){
			$wid_title = esc_html($instance[ 'wid_title' ]);
		}
		?>
		<p><label for="<?php echo $this->get_field_id('wid_title'); ?>"><?php _e('Title','lms'); ?> </label>
        <input type="text" name="<?php echo $this->get_field_name('wid_title');?>" id="<?php echo $this->get_field_id('wid_title');?>" value="<?php echo $wid_title;?>" class="widefat">
		</p>
		<?php 
	}
	
} 