<?php
class DBManager {

	private $mysql_host = "localhost";
	private $mysql_database = "kifech_quote";
	private $mysql_user = "kifech_quote";
	private $mysql_password = "Oussama_Bouraoui_123";
	private $mysqli;
	private $addUserStm;
	
	public function __construct() {
		$this->mysqli = mysqli_connect($this->mysql_host, $this->mysql_user, $this->mysql_password, $this->mysql_database);
		if (mysqli_connect_errno($mysqli)) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		} 
		
	}

	function fetchAppUser($uid) {
		$stm = "SELECT * FROM quote_app_users where uid like '".$uid."'";
		$res = mysqli_query($this->mysqli, $stm);
		if(isset($res)) {
			if($res->num_rows == 1) {
				$row = mysqli_fetch_assoc($res);
				return new AppUser($row['uid'], $row['token'], $row['user_name']);
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	
	function fetchAllAppUsers() {
		$appUsers = array();
		$stm = "SELECT * FROM quote_app_users where 1 ";
		$res = mysqli_query($this->mysqli, $stm);
		if($res != null && $res->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$user = new AppUser($row['uid'], $row['token'], $row['user_name']);
				array_push($appUsers, $user);
			}
			return $appUsers;
		} 
		else {
			return null;
		}
	}


	function addUser($uid, $token, $user_name) {
		if(isset($uid) && isset($token) && isset($user_name)) {
			$user = $this->fetchAppUser($uid);
			
			if($user == null) {
				$insertStm = "INSERT INTO quote_app_users(uid, token, user_name) VALUES('".$uid."', '".$token."', '".$user_name."')";
				$res = mysqli_query($this->mysqli, $insertStm);
				echo $res;
				if($res) {
					$user = $this->fetchAppUser($uid);
					return $user;
				} else {
					return null;
				}
				/*if($res->num_rows == 1) {
					$row = mysqli_fetch_assoc($res);
					return new AppUser($row['appUserId'], $row['uid'], $row['token']);
				} else {
					return null;
				}*/
			} else {
				return $user;
			}
			
		} else {
			echo "no";
			return null;
		}
	}
}


?>