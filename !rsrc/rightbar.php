<?php

function recent_rvs() {
	require('db_connect.php');
	
	// if you can connect to the DB
	if($dbc) {
		$query_recent = "SELECT * FROM rvs ORDER BY rvs.entry_id DESC LIMIT 5";
		if($r = mysql_query($query_recent)) {
			while($row = mysql_fetch_array($r)) {
				$DBdate = strtotime($row['date_entered']);
				$date = date('n/d/y', $DBdate);
				print "\t\t\t\t\t<li><a href=\"one.php?rv=" . $row['entry_id'] . "\">" . $row['rvname'] . "</a> - <small>" . $date . "</small></li>\n";
			}
		}
	}
}

function rightbar() {

?>

	<div id="rightbar">
		<h2>What is Anal RV?</h2>
		<p>It's a game to play while in the car. This site is a place to post the names and/or photos of the RV's you see.</p>

		<h2>How Do You Play?</h2>
		<p>It's simple, as you drive around take the name of any RV's that you may see and add the word <em>anal</em> in front of it. Simple, right?</p>

		<h2>Need an Example?</h2>
		<p>Okay, lets say you are see an RV whos name is the <em>Expedition</em>. Just take the name <em>Expedition</em> and add <em>Anal</em> in front of it. The new name for that RV is the <em>Anal Expedition</em>. Got it?</p>
		<hr/>
		
		<h2>Some Recent RVs</h2>
		<ul>
			<?php recent_rvs(); ?>
		</ul>
	</div>

<?php

}

?>