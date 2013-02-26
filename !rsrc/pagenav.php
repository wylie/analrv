<?php

function pagenav_main() {
	require('db_connect.php');
	
	if($dbc) {
		$query = "SELECT * FROM rvs ORDER BY rvs.entry_id DESC";
		if($r = mysql_query($query)) {
			$row = mysql_fetch_array($r);
			$last_id =  $row['entry_id'];
		}
		
		$posts = $last_id / 5;
		// print '$posts =' . $posts . '<br/>';
		$pages = ceil($posts);
		// print 'pages =' . $pages . '<br/>';
		
		$pg = $_GET['pg'];
		
		if(empty($pg)) {
			$pg = "1";
			$pg = $pg + "1";
			print '<div class="pagenav"><a href="index.php?pg=' . $pg . '" class="older">&lt;&lt; older</a></div>';
		} else {
			
			if(($pg != $pages) && ($pg != "1")) {
				$pg_older = $pg + "1";
				$pg_newer = $pg - "1";
				print '<div class="pagenav"><a href="index.php?pg=' . $pg_older . '" class="older">&lt;&lt; older</a><a href="index.php?pg=' . $pg_newer . '" class="newer">newer &gt;&gt;</a></div>';
			}
			
			if($pg == $pages) {
				$pg_newer = $pg - "1";
				print '<div class="pagenav"><a href="index.php?pg=' . $pg_newer . '" class="newer">newer &gt;&gt;</a></div>';
			}
			
			if($pg == "1") {
				$pg = $pg + "1";
				print '<div class="pagenav"><a href="index.php?pg=' . $pg . '" class="older">&lt;&lt; older</a></div>';
			}

		}
	}	
}

function pagenav_one() {
	require('db_connect.php');
	
	if($dbc) {
		$query = "SELECT entry_id FROM rvs ORDER BY rvs.entry_id DESC";
		if($r = mysql_query($query)) {
			$row = mysql_fetch_array($r);
			$last_id =  $row['entry_id'];
		}

		$id = $_GET['rv'];
		$id_newer = $id + "1";
		$id_older = $id - "1";

		if(($id < $last_id) & ($id != '1')) {
			print '<div class="pagenav"><a href="one.php?rv=' . $id_older . '" class="older"><< older</a><a href="one.php?rv=' . $id_newer . '" class="newer">newer >></a></div>';
		}
		if($id == $last_id) {
			print '<div class="pagenav"><a href="one.php?rv=' . $id_older . '" class="older"><< older</a></div>';
		}
		if($id == '1') {
			print '<div class="pagenav"><a href="one.php?rv=' . $id_newer . '" class="newer">newer >></a></div>';
		}
	}	
}

?>