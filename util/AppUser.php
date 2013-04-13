<?php
class AppUser {
	
	public $appUserId;
	public $uid;
	public $token; 
	
	public function __construct($appUserId, $uid, $token) {
		$this->appUserId = $appUserId;
		$this->uid = $uid;
		$this->token = $token;
	
	}

	public function toString() {
		echo "appUserId : ".$this->appUserId." uid : ".$this->uid." token : ".$this->token;
	
	}




}



?>