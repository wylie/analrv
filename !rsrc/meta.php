<?php

function metaDescription() {
	require('db_connect.php');
		
	$entry_id = $_GET['rv'];
	$tag = $_GET['tag'];

	if($dbc) {
		if($entry_id) {
			$query = "SELECT * FROM rvs WHERE entry_id='$entry_id'";
			if($r = mysql_query($query)) {
				while($row = mysql_fetch_array($r)) {
					require('db_variables.php');
					$meta = strip_tags($desc);
					print $meta;
				}
			}
		} else {
			echo "Anal RV is a simple game to play while in the car. As you drive around take the name of RV's that you see and add the word anal in front of it. Simple, right?";
		}
		if($tag) {
			print 'searched ' . $tag;
		}
	}
			
}

?>