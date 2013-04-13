<?php
class DBManager {

	private $mysql_host = "mysql17.000webhost.com";
	private $mysql_database = "a3512388_quotes";
	private $mysql_user = "a3512388_quotes";
	private $mysql_password = "azerty123";
	private $mysqli;
	private $addUserStm;
	
	public function __construct() {
		$this->mysqli = mysqli_connect($this->mysql_host, $this->mysql_user, $this->mysql_password, $this->mysql_database);
		if (mysqli_connect_errno($mysqli)) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		} 
		
	}

	function getAllQuotes() {
		$res = mysqli_query($this->mysqli, "SELECT * FROM quote");
		$row = mysqli_fetch_assoc($res);
		echo $row['quoteText'];
	}

	function fetchAppUser($uid, $token) {
		$stm = "SELECT * FROM appUser where uid like '".$uid."' and token like '".$token."'";
		$res = mysqli_query($this->mysqli, $stm);
		if(isset($res)) {
			if($res->num_rows == 1) {
				$row = mysqli_fetch_assoc($res);
				return new AppUser($row['appUserId'], $row['uid'], $row['token']);
			} else {
				return null;
			}
		} else {
			return null;
		}
	}


	function addUser($uid, $token) {
		if(isset($uid) && isset($token)) {
			$user = $this->fetchAppUser($uid, $token);
			
			if($user == null) {
				$insertStm = "INSERT INTO appUser(uid, token) VALUES('".$uid."', '".$token."')";
				$res = mysqli_query($this->mysqli, $insertStm);
				echo $res;
				if($res) {
					$user = $this->fetchAppUser($uid, $token);
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