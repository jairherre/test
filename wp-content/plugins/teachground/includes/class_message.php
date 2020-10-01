<?php
class class_tg_message {
	
	public $msg_var = 'tg_msg';
	
	public $msg_class_var = 'tg_msg_class';
	
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
				$GLOBALS[$this->msg_var][]		= '<font color="red">' . $msg . '</font>';
			} else {
				$GLOBALS[$this->msg_var][]		= $msg;
			}
			$GLOBALS[$this->msg_class_var] = $class;
		}
		 
		
	}
	
	public function show($unset = true){
		if( isset( $GLOBALS[$this->msg_var] ) ){
			echo '<div class="' . $GLOBALS[$this->msg_class_var] . '"><p>' . implode( '<br>', $GLOBALS[$this->msg_var] ) . '</p></div>';
			if($unset){
				unset( $GLOBALS[$this->msg_var] );
				unset( $GLOBALS[$this->msg_class_var] );
			}
		}

	}
	
}
