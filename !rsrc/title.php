<?php

function title() {
	require('db_connect.php');
		
	$entry_id = $_GET['rv'];
	$tag = $_GET['tag'];

	if($dbc) {
		if($entry_id) {
			$query = "SELECT * FROM rvs WHERE entry_id='$entry_id'";
			if($r = mysql_query($query)) {
				while($row = mysql_fetch_array($r)) {
					require('db_variables.php');
					print 'The ' . $rvname;
				}
			}
		}
		if($tag) {
			print 'searched ' . $tag;
		}
	}
			
}

?>