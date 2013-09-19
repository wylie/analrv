<?php

	// LOCAL
	// $dbc = mysql_connect('localhost','root','root') or die ("could not connect to database");
	// LIVE
	$dbc = mysql_connect('localhost','wylie_rv','li8!mes.') or die ("could not connect to database");
	mysql_select_db('wylie_rv') or die ("could not select database");

?>