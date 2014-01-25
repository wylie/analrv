<?php

	require('db_connect.php');
	if($dbc) {
		$query = "SELECT * FROM rvs ORDER BY rvs.entry_id ASC";
		if($r = mysql_query($query)) {
			while($row = mysql_fetch_array($r)) {
				require('db_variables.php');
				
				$datetime = strtotime($row[7]);
				$date = date("F j, Y, g:i a", $datetime);
				
				$filename = '../rvs.json';
				$rvs[] = array(
						'number'=> $row[0],
						'user'=> $row[1],
						'blank'=> $row[2],
						'tags'=> $row[3],
						'name'=> $row[4],
						'description'=> $row[5],
						'image'=> $row[6],
						'date'=> $date
				);
				
				$file = file_get_contents($filename);
				$response['rvs'] = $rvs;
				$fp = fopen($filename, 'w+');
				fwrite($fp, json_encode($response));
				fclose($fp);
					
			} // end of while
		} // end of if($r = ...	
	} // end of if($dbc)

?>