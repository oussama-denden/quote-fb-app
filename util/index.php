<?php
require_once('util/AppUser.php');
require_once('util/DBManager.php');

$dbm = new DBManager();

$user = $dbm->addUser('test2', 'test2');
echo $user;
$user->toString;

?>