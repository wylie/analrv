<?php

	require('db_user_variables.php');
	$dbc = mysql_connect($server,$username,$password) or die ("could not connect to database");
	mysql_select_db($dbname) or die ("could not select database");

?>