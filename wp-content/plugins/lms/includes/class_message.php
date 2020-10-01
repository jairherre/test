<?php
class class_lms_message {
	
	public $msg_var = 'lms_msg';
	
	public $msg_class_var = 'lms_msg_class';
	
	public function __construct( $msg_var = '', $msg_class_var = '' ){
		if( $msg_var ){
			$this->msg_var = $msg_var;
		}
		if( $msg_class_var ){
			$this->msg_class_var = $msg_class_var;
		}
	}
	
	public function add( $msg = '', $class = '', $red = false ){
		if( $msg ){
			if($red == true){
				$_SESSION[$this->msg_var][]		= '<font color="red">' . $msg . '</font>';
			} else {
				$_SESSION[$this->msg_var][]		= $msg;
			}
			$_SESSION[$this->msg_class_var] = $class;
		}
	}
	
	public function show($unset = true){
		if( isset( $_SESSION[$this->msg_var] ) ){
			echo '<div class="' . $_SESSION[$this->msg_class_var] . '"><p>' . implode( '<br>', $_SESSION[$this->msg_var] ) . '</p></div>';
			if($unset){
				unset( $_SESSION[$this->msg_var] );
				unset( $_SESSION[$this->msg_class_var] );
			}
		}
	}
	
}
