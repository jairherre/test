<?php

class tg_login_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'tg_login_widget',
			__('TG Login Widget','teachground'),
			array( 'description' => __( 'This is a simple login form in the widget.', 'teachground' ), )
		);
	 }

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['wid_title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['wid_title'] ) . $args['after_title'];
		}
		$tglf = new tg_login_form;
		$tglf->login_form( $args['widget_id'] );
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
		<p><label for="<?php echo $this->get_field_id('wid_title'); ?>"><?php _e('Title','teachground'); ?> </label>
        <?php form_class::form_input('text',$this->get_field_name('wid_title'),$this->get_field_id('wid_title'),$wid_title,'widefat');?>
		</p>
		<?php 
	}
	
} 