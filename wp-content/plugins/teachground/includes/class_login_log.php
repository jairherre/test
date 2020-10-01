<?php

class tg_analytics_login_log_class {
    
	public $plugin_page;
	
	public $plugin_page_base;
	
	public $table;
	
	public $sortable = array();
	
	public $column_count;
	
   public  function __construct(){
      $this->plugin_page_base = 'tg_analytics';
	  $this->plugin_page = admin_url('edit.php?post_type=tg_course&page='.$this->plugin_page_base);
	  $this->table = 'tg_login_log';
    }
	
	public function get_table_colums(){
		$colums = array(
		'user_id' => __('User','teachground'),
		'ip' => __('IP','teachground'),
		'msg' => __('Status','teachground'),
		'l_added' => __('Date','teachground'),
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
					$ret .= '<img src="'.plugins_url( TG_DIR_NAME . '/images/'.$sort_image ).'" style="vertical-align:middle;">';
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
					$ret .= '<img src="'.plugins_url( TG_DIR_NAME . '/images/'.$sort_image ).'" style="vertical-align:middle;">';
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
			case 'user_id':
			$user_info = get_userdata($values['user_id']);
			$v = $user_info->first_name . ' ' . $user_info->last_name;
			$sh = true;
			break;
			case 'ip':
			$v = $values['ip'];
			$sh = true;
			break;
			case 'msg':
			$v = $values['msg'];
			$sh = true;
			break;
			case 'l_added':
			$v = $values['l_added'];
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
			$ret .= '<td align="center" colspan="'.$this->column_count.'">'.__('No records found','teachground').'</td>';
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

	public function lists( $user_id ){
		global $wpdb;
		$srch_extra = '';
		$sort_extra = '';
				
		// sort // 
		if(isset($_REQUEST['sort_on']) and isset($_REQUEST[$_REQUEST['sort_on'].'_sort']) ){
			$order_by = sanitize_text_field( $_REQUEST['sort_on'] );
			$order = sanitize_text_field( $_REQUEST[$_REQUEST['sort_on'].'_sort'] );
			$sort_extra .= " ORDER BY ".$order_by." ".$order."";
		} else {
			$sort_extra .= " ORDER BY l_added DESC";
		}
		// sort //

		$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$this->table." WHERE user_id = %d " . $sort_extra, $user_id );
		$ap = new ap_paginate(10);
		$data = $ap->initialize($query,sanitize_text_field(@$_REQUEST['paged']));
		
		echo '<h3>' . __('Login log of user ','teachground') . '#' . $user_id . '</h3>';
		
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
	
    public function display_list( $user_id = '' ) {
		$this->start_wrap();	
		$this->lists($user_id);
		$this->end_wrap();
	}

}