<?php

class lms_analytics_class {
    
	public $plugin_page;
	
	public $plugin_page_base;
	
	public $table;
	
	public $sortable = array();
	
	public $column_count;
	
   public  function __construct(){
      $this->plugin_page_base = 'lms_analytics';
	  $this->plugin_page = admin_url('edit.php?post_type=lms_course&page='.$this->plugin_page_base);
	  $this->table = 'lms_orders';
    }
	
	public function get_table_colums(){
		$colums = array(
		'first_name' => __('Firstname','lms'),
		'last_name' => __('Lastname','lms'),
		'email' => __('Email','lms'),
		'last_login' => __('Last Login','lms'),
		'access' => __('Access Name','lms'),
		'gateway' => __('Gateway','lms'),
		'order_id' => __('Order ID','lms'),
		'order_date' => __('Order Date','lms'),
		);
		$this->column_count = count($colums);
		return $colums;
	}
	
	public function table_start(){
		return '<table class="wp-list-table widefat">';
	} 
    
	public function table_end(){
		return '</table>';
	}
	
	public function get_table_header(){
		$header = $this->get_table_colums();
		$ret = '';
		$ret .= '<thead>';
		$ret .= '<tr>';
		foreach($header as $key => $value){
			if( is_array($this->sortable) and in_array($key, $this->sortable) ){
				$ret .= '<td>';
				$ret .= '<strong><a href="'.$this->plugin_page.'&sort_on='.$key.'&'.$key.'_sort='.( @$_REQUEST[$key.'_sort'] == 'asc'?'desc':'asc' ).'">'.$value.'</a></strong>';
				if( isset($_REQUEST['sort_on']) and isset( $_REQUEST[$key.'_sort'] ) ){
					$sort_image = ( @$_REQUEST[$key.'_sort'] == 'asc'?'asc.png':'desc.png' );
					$ret .= '<img src="'.plugins_url( LMS_DIR_NAME . '/images/'.$sort_image ).'" style="vertical-align:middle;">';
				}
				$ret .= '</td>';
			} else {
				$ret .= '<td><strong>'.$value.'</strong></td>';
			}
		}
		$ret .= '</tr>';
		$ret .= '</thead>';
		return $ret;		
	}
	
	public function get_table_footer(){
		$header = $this->get_table_colums();
		$ret = '';
		$ret .= '<tfoot>';
		$ret .= '<tr>';
		foreach($header as $key => $value){
			if( is_array($this->sortable) and in_array($key, $this->sortable) ){
				$ret .= '<td>';
				$ret .= '<strong><a href="'.$this->plugin_page.'&sort_on='.$key.'&'.$key.'_sort='.( @$_REQUEST[$key.'_sort'] == 'asc'?'desc':'asc' ).'">'.$value.'</a></strong>';
				if( isset($_REQUEST['sort_on']) and isset( $_REQUEST[$key.'_sort'] ) ){
					$sort_image = ( @$_REQUEST[$key.'_sort'] == 'asc'?'asc.png':'desc.png' );
					$ret .= '<img src="'.plugins_url( LMS_DIR_NAME . '/images/'.$sort_image ).'" style="vertical-align:middle;">';
				}
				$ret .= '</td>';
			} else {
				$ret .= '<td><strong>'.$value.'</strong></td>';
			}
		}
		$ret .= '</tr>';
		$ret .= '</tfoot>';
		return $ret;		
	}
	
	public function table_td_column($values){
		$ret = '';
		$header = $this->get_table_colums();
		foreach($header as $key => $value){
			$ret .= $this->row_data($key,$values);
		}
		return $ret;
	}
		
	public function row_data( $key, $values ){
		$sh = false;
		switch ($key){
			case 'first_name':
			$user_info = get_userdata($values['user_id']);
			$v = $user_info->first_name;
			$sh = true;
			break;
			case 'last_name':
			$user_info = get_userdata($values['user_id']);
			$v = $user_info->last_name;
			$sh = true;
			break;
			case 'email':
			$user_info = get_userdata($values['user_id']);
			$v = $user_info->user_email;
			$sh = true;
			break;
			case 'last_login':
			$v = $this->get_last_login_data($values['user_id']);
			$sh = true;
			break;
			case 'access':
			$v = $this->get_access_names( $values );
			$sh = true;
			break;
			case 'gateway':
			$v = $values['payment_gateway'];
			$sh = true;
			break;
			case 'order_id':
			$v = $this->get_order_id_with_link( $values['payment_gateway_order_id'], $values['payment_gateway'] );
			$sh = true;
			break;
			case 'order_date':
			$v = $values['added_on'];
			$sh = true;
			break;
			default:
			//$v = $value; uncomment this line on your own risk
			break;
		}
		if($sh){
			return '<td>'.$v.'</td>';
		}
	}
	
	public function get_table_body($data){
		$cnt = 0;
		$ret = '';
		if(is_array($data) and count($data)){
			$ret .= '<tbody id="the-list">';
			foreach($data as $k => $v){
				$ret .= '<tr class="'.($cnt%2==0?'alternate':'').'">';
				$ret .= $this->table_td_column($v);
				$ret .= '</tr>';
				$cnt++;
			}
			$ret .= '</tbody>';
		} else {
			$ret .= '<tbody id="the-list">';
			$ret .= '<tr>';
			$ret .= '<td align="center" colspan="'.$this->column_count.'">'.__('No records found','lms').'</td>';
			$ret .= '</tr>';
			$ret .= '</tbody>';
		}
		return $ret;
	}
	
	public function get_single_row_data($id){
		global $wpdb;
		$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$this->table." WHERE order_id = %d", $id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		return $result;
	}
	
	public function lists(){
		global $wpdb;
		$srch_extra = '';
		$sort_extra = '';
				
		// sort // 
		if(isset($_REQUEST['sort_on']) and isset($_REQUEST[$_REQUEST['sort_on'].'_sort']) ){
			$order_by = sanitize_text_field( $_REQUEST['sort_on'] );
			$order = sanitize_text_field( $_REQUEST[$_REQUEST['sort_on'].'_sort'] );
			$sort_extra .= " ORDER BY ".$order_by." ".$order."";
		} else {
			$sort_extra .= " ORDER BY added_on DESC";
		}
		// sort //
		
		$query = "SELECT * FROM ".$wpdb->prefix.$this->table." WHERE order_id <> 0 ".$sort_extra."" ;
		$ap = new ap_paginate(10);
		$data = $ap->initialize($query,sanitize_text_field(@$_REQUEST['paged']));
		
		echo '<h3>' . __('Analytics','lms') . '</h3>';
		
		echo $this->table_start();
		echo $this->get_table_header();
		echo $this->get_table_body($data);
		echo $this->get_table_footer();
		echo $this->table_end();
		
		echo '<div style="margin-top:10px;">';
		echo $ap->paginate();
		echo '</div>';
	}
	
	public function start_wrap(){
		echo '<div class="wrap">';
	}
	
	public function end_wrap(){
		echo '</div>';
	}
	
    public function display_list() {
		$this->start_wrap();	
		if(isset($_REQUEST['action']) and $_REQUEST['action'] == 'login_log'){
			$user_id = sanitize_text_field($_REQUEST['user_id']);
			$lll = new lms_analytics_login_log_class;
			$lll->display_list($user_id);
		} elseif(isset($_REQUEST['action']) and $_REQUEST['action'] == 'access_log'){
			$user_id = sanitize_text_field($_REQUEST['user_id']);
			$am_id = sanitize_text_field($_REQUEST['am_id']);
			$laml = new lms_analytics_access_log_class;
			$laml->display_list($am_id,$user_id);
		} else {
			$this->lists();
		}
		$this->end_wrap();
	}

	public function get_access_names( $data ){
		$user_id = $data['user_id'];
		$am_ids = lms_get_accesses_of_user($user_id);
		$ret = '';
		if( is_array($am_ids) and count($am_ids) ){
			foreach($am_ids as $value){
				$ret .= '<p><a href="'.admin_url('edit.php?post_type=lms_course&page='.$this->plugin_page_base.'&action=access_log&am_id='.$value.'&user_id='.$user_id).'">' . get_the_title($value) . '</a></p>';
			}
		} else {
			$ret .= __('No accesses found','lms');
		}
		return $ret;
	}

	public function get_last_login_data( $user_id ){
		global $wpdb;
		$query = $wpdb->prepare( "SELECT l_added FROM ".$wpdb->prefix."lms_login_log WHERE user_id = %d AND l_status = %s ORDER BY l_added DESC LIMIT 1", $user_id, 'success' );
		$result = $wpdb->get_row( $query );
		if($result){
			return '<a href="'.admin_url('edit.php?post_type=lms_course&page='.$this->plugin_page_base.'&action=login_log&user_id='.$user_id).'">'.$result->l_added.'</a>';
		} else {
			return 'NA';
		}
	}

	public function get_order_id_with_link( $order_id = '', $payment_gateway = '' ){
		if( $payment_gateway == 'woocommerce' ){
			return '<a href="'.admin_url("post.php?post={$order_id}&action=edit").'" target="_blank">'.$order_id.'</a>';
		} elseif( $payment_gateway == 'thrivecart' ){
			if( get_option('lms_thrivecart_id') ){
				return '<a href="https://thrivecart.com/'.get_option('lms_thrivecart_id').'/#/orders/view/'.$order_id.'/live/charges" target="_blank">'.$order_id.'</a>';
			} else {
				return $order_id;
			}
		} elseif( $payment_gateway == 'digistore24' ){
			return '<a href="https://www.digistore24-app.com/reports/transactions/order/'.$order_id.'" target="_blank">'.$order_id.'</a>';
		}
	}
	
}