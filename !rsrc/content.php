<?php

function photo($picture_loc,$rvname) {
	if(!empty($picture_loc)) {
		?><img src="<?php print $picture_loc; ?>" title="<?php print $rvname; ?>" alt="<?php print $rvname; ?>" /><?php
	}
}

function tags($tags) {
		
	if(!in_array("",$tags)) {
		?><small class="tags"><?php
		foreach($tags as $single_tag) {
			$single_tag_trim = trim($single_tag);
			print '<a href="search.php?tag=' . $single_tag_trim . '">' . $single_tag_trim . '</a>';
		}
	?></small><?php
	}
}

function content() {
	require('db_connect.php');

	// get page stuff
	$pg = $_GET['pg'];
	
	if(empty($pg)) {
		$pg = 1;
	}
	// generate the higher number to query the DB with
	$pg_high = $pg * 5;
	// generate the lower number to query the DB with
	$pg_low = $pg_high - 5;

	if($dbc) {
		$query = "SELECT * FROM rvs ORDER BY rvs.entry_id DESC LIMIT $pg_low,5";
		if($r = mysql_query($query)) {
			while($row = mysql_fetch_array($r)) {
				require('db_variables.php');
				
				?>
				<div class="post">
					<h2><a href="one.php?rv=<?php print $entry_id; ?>" class="h2"><?php print $rvname; ?></a></h2>
					<?php photo($picture_loc,$rvname); ?>
					<p><?php print $desc; ?></p>
					<small class="user">This Anal RV was submitted by <?php print $user; ?> at <?php print $date; ?></small>
					<?php tags($tags); ?>
				</div>
				<?php
			} // end of while
		} // end of if($r = ...	
	} // end of if($dbc)
} // end of function

?>