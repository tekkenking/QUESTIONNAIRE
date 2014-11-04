<?php namespace libs\Ajaxalert;

class Ajaxalert
{
	//private static $ini = false;
	private $alertData = array();
	private $alertTypes = array('success', 'error', 'info', 'warning', 'lite');
	
	public function __call($method, $msg=''){
		
		if( !in_array( $method, $this->alertTypes ) ){
		//tt($msg);
			tt('ERROR: Unknown Alert Type = ' . $method);
			return false;
		}
		
		//Bootstrap doesn't use ERROR as red alert. Instead they used DANGER as red alert
		//So we have to change the error key to danger
		if( $method === 'error' ){
			$method = 'danger';
		}
		
		$this->alertData['status'] = $method;	
		
		if( $msg !== '' ){
			$msg = array_shift($msg);
			return ( is_array($msg) ) ? $this->arrayMessage($msg) : $this->message($msg);
		}
		
		return $this;
	}
	
	public function message($msg){
		$this->alertData['message'] = $msg;
		return $this;
	}
	
	public function arrayMessage(Array $msg){
		return $this->message($msg);
	}
	
	public function url($url){
		$this->alertData['url'] = $url;
		return $this;
	}
	
	public function get(){
		return $this->alertData;
	}
}