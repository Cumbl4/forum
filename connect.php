<meta charset="utf-8">
<?php
	session_start();

	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$name = 'forum';

	$link = mysqli_connect($host, $user, $pass, $name);
	mysqli_query($link, "SET NAMES 'utf8'");
?>