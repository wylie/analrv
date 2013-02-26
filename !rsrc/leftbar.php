<?php

function submitrv() {

// include('rss.php');

	if(isset($_POST['submitted'])) {

		// check for a username
		if(empty($_POST['user'])) {
			print '<span class="red">Please enter your name.</span>';
			$problem = TRUE;
		}
	
		/*
		// check for a email
		if(empty($_POST['email'])) {
			print '<span class="red">Please enter a valid email.</span>';
			$problem = TRUE;
		}
		*/
			
		// check for a rv name
		if(empty($_POST['rvname'])) {
			print '<span class="red">Please enter the RV name.</span>';
			$problem = TRUE;
		}
	
		// check for a description
		if(empty($_POST['description'])) {
			print '<span class="red">Please enter a description.</span>';
			$problem = TRUE;
		}
		
		// RECAPTCHA STUFF
		require_once('recaptcha/recaptchalib.php');
		$privatekey = "6LfMdAsAAAAAANeAvteP9jzMDlEgIwT9TeGBACYt";
		$resp = recaptcha_check_answer ($privatekey,
		                                $_SERVER["REMOTE_ADDR"],
		                                $_POST["recaptcha_challenge_field"],
		                                $_POST["recaptcha_response_field"]);
		
		if (!$resp->is_valid) {
			die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $resp->error . ")");
			$problem = TRUE;
		}
		
		if(!$problem) {
			require('db_connect.php');
			
			// assign the variables from the form
			$user = $_POST['user'];
			$user = strip_tags($user); 

			$email = $_POST['email'];
			$email = strip_tags($email); 

			// start the tags
			if(!empty($_POST['tags'])) {
				function trim_value(&$value) { 
				    $value = trim($value); 
				}
				$tags = $_POST['tags'];
				$tags = explode("," & ", ",$tags);
				array_walk($tags, 'trim_value');
				$tags = implode(",",$tags);
			} else {
				$tags = '';
			}
			$rvname = $_POST['rvname'];
			$rvname = strip_tags($rvname); 

			$description = $_POST['description'];
			$description = strip_tags($description); 

			$date = date('gi-mdy');

			if($file = $date . $_FILES['image']['name']) {
				if(move_uploaded_file($_FILES['image']['tmp_name'], "!img/rvs/" . $date . "{$_FILES['image']['name']}")) {
					print '<p class="green">Your file has been uploaded!</p>';	
					// set the variable for the new picture location	
					$picture_loc = '!img/rvs/' . $file;
					// if($dbc) {
						$query = "UPDATE rvs SET picture_loc='$picture_loc' WHERE date_entered=NOW()";
						$r = mysql_query($query);
						
						if(mysql_affected_rows() == 1) {
							// print '<br/>success';
						} else {
							// print '<br/>bad';
						}
					} else { // problem!
						//print '<p class="red">Your file could not be uploaded:<br/>';
						// print message based on the error
						switch ($_FILES['image']['error']) {
							case 1:
								print 'The file exceeds the upload_max_filesize setting in pho.ini.';
							case 2:
								print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
							case 3:
								print 'The file was only partially uploaded.';
								break;
							case 4:
								print 'No file was uploaded.';
								break;
							case 6:
								print 'The temporary folder does not exist.';
								break;
							default:
								print 'Something unforseen happened.';
								break;
						}
						print '</p>'; // complete the paragraph
					} // end of the movie_uploaded_file() IF
				// if you can connect to the DB
				if($dbc) {
					// create the table
					/*
					$query_table = "CREATE TABLE rvs (
					entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					user TEXT NOT NULL,
					email TEXT NOT NULL,
					tags TEXT NOT NULL,
					rvname TEXT NOT NULL,
					description TEXT NOT NULL,
					picture_loc TEXT NOT NULL,
					date_entered DATETIME NOT NULL
					)";
					
					mysql_query($query_table);
					*/
	
					// add the info to the table
					$query_submit = "INSERT INTO rvs(entry_id, user, email, rvname, tags, description, picture_loc, date_entered) VALUES (0, '$user', '$email', '$rvname', '$tags', '$description', '$picture_loc', NOW())";
					mysql_query($query_submit);

					// START FEED INFORMATION
					// feed location
					$feed = 'feed.xml';
							
					$write1 = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>
				<rss version=\"2.0\">
					<channel>
			
						<title>Anal RV</title>
						<description>Anal RV is a simple game to play while in the car. As you drive around take the name of RV's that you see and add the word anal in front of it. Simple and fun, right?</description>
						<link>http://www.analrv.com/</link>
					    <category domain=\"www.dmoz.com\">Recreation/Travel/Image Galleries</category>
					    <copyright>Copyright 2010 Wylie Fisher</copyright>
					    <language>en-us</language>
					    <webMaster>wylie@dukeofcheese.com (Wylie)</webMaster>";
				
					$feed_open = fopen($feed,'w+');
					fwrite($feed_open,$write1);
					// fclose($feed_open);
					
					//if($dbc) {
						$query_feed = "SELECT * FROM rvs ORDER BY rvs.entry_id DESC LIMIT 10";
						if($r = mysql_query($query_feed)) {
							while($row = mysql_fetch_array($r)) {
								include('db_variables.php');
				
								// make the date perty for the feed
								$DBdate = strtotime($row['date_entered']);
								$date = date('D, d M y H:i:s O', $DBdate);
					
								// write the entries
								$write2 = "
						<item>
							<title>" . $rvname . "</title>
							<link>http://www.analrv.com/one.php?rv=" . $entry_id . "</link>
							<guid>http://www.analrv.com/one.php?rv=" . $entry_id . "</guid>
							<pubDate>" . $date . "</pubDate>
							<description>&lt;img src=&quot;http://www.analrv.com/" . $picture_loc . "&quot; width=&quot;500&quot; alt=&quot;&quot;&gt;&lt;br/&gt;&lt;br/&gt;" . $desc . "</description>
						</item>";
				
								// $feed_open = fopen($feed,'w+');
								fwrite($feed_open,$write2);
								// fclose($feed_open);
							}
						}
					//}
					
					// write the closing bit of the feed
					$write3 = "
					</channel>
				</rss>";
				
					fwrite($feed_open,$write3);
					fclose($feed_open); // close the file
					// END FEED INFORMATION

					mysql_close(); // close the database connection
					
				} else { // if you cant connect to the DB
					print 'bad<br/>';
				}
			
			
			} else { // end of file upload if
			
				// if you can connect to the DB
				if($dbc) {
					// create the table
					/*
					$query_table = "CREATE TABLE rvs (
					entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					user TEXT NOT NULL,
					email TEXT NOT NULL,
					tags TEXT NOT NULL,
					rvname TEXT NOT NULL,
					description TEXT NOT NULL,
					picture_loc TEXT NOT NULL,
					date_entered DATETIME NOT NULL
					)";
					
					mysql_query($query_table);
					*/
	
					// add the info to the table
					$query_submit = "INSERT INTO rvs(entry_id, user, email, rvname, tags, description, date_entered) VALUES (0, '$user', '$email', '$rvname', '$tags', '$description', NOW())";
					mysql_query($query_submit);
					
					// START FEED INFORMATION
					// feed location
					$feed = 'feed.xml';
							
					$write1 = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>
					<rss version=\"2.0\">
						<channel>
				
							<title>Anal RV</title>
							<description>Anal RV is a simple game to play while in the car. As you drive around take the name of RV's that you see and add the word anal in front of it. Simple and fun, right?</description>
							<link>http://www.analrv.com/</link>
						    <category domain=\"www.dmoz.com\">Recreation/Travel/Image Galleries</category>
						    <copyright>Copyright 2010 Wylie Fisher</copyright>
						    <language>en-us</language>
						    <webMaster>wylie@dukeofcheese.com</webMaster>";
				
					$feed_open = fopen($feed,'w+');
					fwrite($feed_open,$write1);
					// fclose($feed_open);
					
					//if($dbc) {
						$query_feed = "SELECT * FROM rvs ORDER BY rvs.entry_id DESC LIMIT 10";
						if($r = mysql_query($query_feed)) {
							while($row = mysql_fetch_array($r)) {
								include('db_variables.php');
				
								// make the date perty for the feed
								$DBdate = strtotime($row['date_entered']);
								$date = date('D, d M Y G:i:s O', $DBdate);
					
								// write the entries
								$write2 = "
							<item>
								<title>" . $rvname . "</title>
								<link>http://www.analrv.com/one.php?rv=" . $entry_id . "</link>
								<guid>http://www.analrv.com/one.php?rv=" . $entry_id . "</guid>
								<pubDate>" . $date . "</pubDate>
								<description>" . $desc . "</description>
							</item>";
				
								// $feed_open = fopen($feed,'w+');
								fwrite($feed_open,$write2);
								// fclose($feed_open);
							}
						}
					//}
					
					// write the closing bit of the feed
					$write3 = "
						</channel>
					</rss>
				</xml>";
				
					fwrite($feed_open,$write3);
					fclose($feed_open); // close the file
					// END FEED INFORMATION

					mysql_close(); // close the database connection
					
				} else { // if you cant connect to the DB
					print 'bad<br/>';
				}
			}

		} // end of no form problems
	} // end of isset($_POST['submitted'])
} // end of submitrv()

function leftbar() {

ob_start();

?>

	<div id="leftbar">

		<h2>Add Your Sighting</h2>
		<form action="index.php" method="post" enctype="multipart/form-data">
			<p><strong class="asterix red">*</strong> Your Name:<br/><input type="text" name="user" tabindex="1" /></p>
			<p><strong class="asterix red">*</strong> The RV Name:<br/><input type="text" name="rvname" value="Anal " tabindex="3" /></p>
			<p>Tags:<br/><input type="text" name="tags" tabindex="4" /></p>
			<p><strong class="asterix red">*</strong> A Description:<br/><textarea name="description" tabindex="5" rows="" cols=""></textarea></p>
			<p>An Image of the RV:<br/><input class="file" type="file" name="image" tabindex="6" /></p>

			<!-- RECAPTCHA -->
			<div id="recaptcha_widget" style="display:none">
				<div id="recaptcha_image"></div>
				<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>
				<span class="recaptcha_only_if_image">Enter the words above:</span>
				<span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>
				<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
				<div><a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a></div>
				<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
				<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
				<div><a href="javascript:Recaptcha.showhelp()">Help</a></div>
				<script type="text/javascript" src="http://api.recaptcha.net/challenge?k=6LfMdAsAAAAAAHsQetCEVLyoCJjnJ_Ap1TfyQ86Y">
				</script>
				<noscript>
					<iframe src="http://api.recaptcha.net/noscript?k=6LfMdAsAAAAAAHsQetCEVLyoCJjnJ_Ap1TfyQ86Y" height="300" width="500" frameborder="0"></iframe><br>
					<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
					<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
				</noscript>
			</div>
			<!-- END RECAPTCHA -->

			<p>
				<input type="submit" name="submit" value="Add Your Sighting" class="submit" tabindex="8" />
				<input type="hidden" name="MAX_FILE_SIZE" value="900000" />
				<input type="hidden" name="submitted" value="true" />
			</p>
			<p><?php submitrv(); ?></p>
			<p class="required"><strong class="red">*</strong> = Required fields.<br/><strong>1.</strong> Separate tags with commas.<br/><strong>2.</strong> Images should be jpg, gif, or png files and should be smaller than 1MB. For best results, have your image be wider than 500 pixels.</p>
		</form>

	</div>

<?php

ob_end_flush();

}

?>