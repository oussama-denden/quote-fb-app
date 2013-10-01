<?php
class AppUser {
	
	public $uid;
	public $token;
	public $user_name; 
	
	public function __construct($uid, $token, $user_name) {
		$this->uid = $uid;
		$this->token = $token;
		$this->user_name = user_name;
	
	}

	public function __toString() {
		return "user_name : ".$this->user_name." uid : ".$this->uid." token : ".$this->token;
	
	}




}



?>