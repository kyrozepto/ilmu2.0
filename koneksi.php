<?php
	$host = getenv('DATABASE_HOST');
	$user = getenv('DATABASE_USER');
	$pass = getenv('DATABASE_PASSWORD');
	$db = 'db_ilmu';
	$conn = mysqLi_connect($host,$user, $pass, $db);
	if($conn){
	}
	mysqLi_select_db($conn,$db);
?>
