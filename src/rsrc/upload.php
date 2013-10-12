<?php

	$username = $_POST['username'];
	$rvname = $_POST['rvname'];
	$tags = $_POST['tags'];
	$description = $_POST['description'];
	$image = 'img/rvs/' . $_POST['image'];

	echo $username . ' ' . $rvname . ' ' . $tags . ' ' . $description . ' ' . $image;

?>