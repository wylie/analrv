<?php

	$entry_id = $row['entry_id'];
	$user = $row['user'];
	$rvname = $row['rvname'];
	$tags = explode(',', $row['tags']);
	$desc = $row['description'];
	$picture_loc = $row['picture_loc'];
	$DBdate = strtotime($row['date_entered']);
	$date = date('g:i a \o\n F d, Y', $DBdate);

?>