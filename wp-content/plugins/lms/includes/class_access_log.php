<?php

class lms_analytics_access_log_class {
    
	public $plugin_page;
	
	public $plugin_page_base;
	
   public  function __construct(){
      $this->plugin_page_base = 'lms_analytics';
	  $this->plugin_page = admin_url('edit.php?post_type=lms_course&page='.$this->plugin_page_base);
    }

	public function lists( $am_id = '', $user_id = '' ){
		global $wpdb;
		include( LMS_DIR_PATH . '/view/admin/access_log.php' );
	}
	
	public function start_wrap(){
		echo '<div class="wrap">';
	}
	
	public function end_wrap(){
		echo '</div>';
	}
	
    public function display_list( $am_id = '', $user_id = '' ) {
		$this->start_wrap();	
		$this->lists($am_id, $user_id);
		$this->end_wrap();
	}

}