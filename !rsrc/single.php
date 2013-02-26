<?php

function single() {
	require('db_connect.php');
	
	$entry_id = $_GET['rv'];
	
	if($dbc) {
		$query = "SELECT * FROM rvs WHERE entry_id='$entry_id'";
		if($r = mysql_query($query)) {
			while($row = mysql_fetch_array($r)) {

				require('db_variables.php');

			?>			
			<div class="post single">
				<h2><a href="one.php?rv=<?php print $entry_id; ?>" class="h2"><?php print $rvname; ?></a></h2>
				<?php photo($picture_loc,$rvname); ?>
				<p><?php print $desc; ?></p>
				<small class="user">This Anal RV was submitted by <?php print $user; ?> at <?php print $date; ?></small>
				<?php tags($tags); ?>
			</div>
			<?php
			
			}
		}
	}	
}

?>