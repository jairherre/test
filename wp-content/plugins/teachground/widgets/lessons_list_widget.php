<?php

class lessons_list_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'lessons_list_widget',
			'List of Lessons',
			array( 'description' => __( 'Display list of lessons', 'teachground' ), )
		);
	 }

	public function widget( $args, $instance ) {
		if ( !is_singular( 'tg_course' ) && !is_singular( 'tg_lesson' ) ) {
			return;
		}
		if ( !is_user_logged_in() ) {
			return;
		}
		echo $args['before_widget'];
		if ( ! empty( $instance['wid_title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['wid_title'] ) . $args['after_title'];
		}
		$cllw = new class_ll_widget;
		$cllw->view( $instance );
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['wid_title'] 							= strip_tags( $new_instance['wid_title'] );
		$instance['wid_enable_collapsable_outlines'] 	= sanitize_text_field( $new_instance['wid_enable_collapsable_outlines'] );
		$instance['wid_enable_open_close_all'] 			= sanitize_text_field( $new_instance['wid_enable_open_close_all'] );
		return $instance;
	}

	public function form( $instance ) {
		$wid_title = '';
		if(!empty($instance[ 'wid_title' ])){
			$wid_title = esc_html($instance[ 'wid_title' ]);
		}
		$wid_enable_collapsable_outlines = @$instance[ 'wid_enable_collapsable_outlines' ];
		$wid_enable_open_close_all = @$instance[ 'wid_enable_open_close_all' ];
		?>
		<p><label for="<?php echo $this->get_field_id('wid_title'); ?>"><?php _e('Title','teachground'); ?> </label>
        <input type="text" name="<?php echo $this->get_field_name('wid_title');?>" id="<?php echo $this->get_field_id('wid_title');?>" value="<?php echo $wid_title;?>" class="widefat">
		</p>
        <p><label for="<?php echo $this->get_field_id('wid_enable_collapsable_outlines'); ?>"><?php _e('Enable Course Outlines Collapsable','teachground'); ?> </label>
        <input class="checkbox" type="checkbox" <?php checked( $wid_enable_collapsable_outlines, 'on' ); ?> id="<?php echo $this->get_field_id( 'wid_enable_collapsable_outlines' ); ?>" name="<?php echo $this->get_field_name( 'wid_enable_collapsable_outlines' ); ?>" />
		</p>
        <p><label for="<?php echo $this->get_field_id('wid_enable_open_close_all'); ?>"><?php _e('Enable Open / Close All','teachground'); ?> </label>
        <input class="checkbox" type="checkbox" <?php checked( $wid_enable_open_close_all, 'on' ); ?> id="<?php echo $this->get_field_id( 'wid_enable_open_close_all' ); ?>" name="<?php echo $this->get_field_name( 'wid_enable_open_close_all' ); ?>" />
		</p>
		<?php 
	}
	
} 