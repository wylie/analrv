<?php

	$username = $_POST['username'];
	$rvname = $_POST['rvname'];
	$tags = $_POST['tags'];
	$description = $_POST['description'];
	$image = 'img/rvs/' . $_POST['image'];

	echo $username . ' ' . $rvname . ' ' . $tags . ' ' . $description . ' ' . $image;

	// $query = "UPDATE rvs SET picture_loc='$picture_loc' WHERE date_entered=NOW()";
	// $r = mysql_query($query);

	// $query_submit = "INSERT INTO rvs(entry_id, user, email, rvname, tags, description, picture_loc, date_entered) VALUES (0, '$user', '$email', '$rvname', '$tags', '$description', '$picture_loc', NOW())";
	// mysql_query($query_submit);


?>