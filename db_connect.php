<?php
/**
 * db_connect.php
 * Script to connect to the mysql server
 */

$server = 'ada.cc.gettysburg.edu';
$port = 3306;
$user = 'dhakam01';
$pass = 'Testpassword1';
$dbname = 'ad_cs360';

try {
    $db = new PDO("mysql:host=$server;dbname=$dbname", $user, $pass);
} catch (PDOException $ex) {
    die("MySQL connection error:" . $ex->getMessage());
}

?>
