<?php

function tag_search() {
	require('db_connect.php');
	
	$tag = $_GET['tag'];
	print '<h2>Search results for tag: <em>' . $tag . '</em></h2><hr/>';

	if($dbc) {
		// query the DB for the tag
		$query = "SELECT * FROM rvs ORDER BY rvs.entry_id DESC";

		if($r = mysql_query($query)) {
			while($row = mysql_fetch_array($r)) {
				require('db_variables.php');
				
				if(in_array($tag, $tags)) {
					?>
					<div class="post tags">
						<h3><a href="one.php?rv=<?php print $entry_id; ?>" class="h3"><?php print $rvname; ?></a></h3>
						<?php photo($picture_loc,$rvname); ?>
						<p><?php print $desc; ?></p>
						<small class="user">This Anal RV was submitted by <?php print $user; ?> at <?php print $date; ?></small>
						<?php tags($tags); ?>
					</div>
					<?php
				}

				// print '<hr/>';
			} // end of while
		} // end of if($r = ...
	} // end of if($dbc)
} // end of function

?>