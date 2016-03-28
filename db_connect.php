<?php
// script to connect to mysql server

$server = 'ada.cc.gettysburg.edu';
$port	= 3306;
$user	='truodu01';
$pass	='blackdog';
$dbname ='ad_cs360';

try {
	$db = new PDO("mysql:host=$server;dbname=$dbname", $user, $pass);
}
catch(PDOException $ex) {
	die("MySQL connection error:".$ex->getMessage());
}

?>
