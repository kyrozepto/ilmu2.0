<?php
	$host = 'localhost';
	$user = 'root';
	$pass ='';
	$db = 'db_ilmu';
	$conn = mysqLi_connect($host,$user, $pass, $db);
	if($conn){
	}
	mysqLi_select_db($conn,$db);
?>