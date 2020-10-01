<?php

class lms_login_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'lms_login_widget',
			__('LMS Login Widget','lms'),
			array( 'description' => __( 'This is a simple login form in the widget.', 'lms' ), )
		);
	 }

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['wid_title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['wid_title'] ) . $args['after_title'];
		}
		$lmslf = new lms_login_form;
		$lmslf->login_form( $args['widget_id'] );
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
        <?php form_class::form_input('text',$this->get_field_name('wid_title'),$this->get_field_id('wid_title'),$wid_title,'widefat');?>
		</p>
		<?php 
	}
	
} 