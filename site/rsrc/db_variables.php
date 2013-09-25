<?php
	// set the default timezone to use. Available since PHP 5.1
	date_default_timezone_set("EST - 5");

	$entry_id = $row['entry_id'];
	$user = $row['user'];
	$rvname = $row['rvname'];
	$tags = explode(',', $row['tags']);
	$desc = $row['description'];
	$picture_loc = $row['picture_loc'];
	$DBdate = strtotime($row['date_entered']);
	$date = date('g:i a \o\n F d, Y', $DBdate);

?>