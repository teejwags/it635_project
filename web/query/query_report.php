<style>
p.indigo{
	color: indigo;
	margin: 0;
}
table{
	border-collapse: collapse;
}
th, td{
	text-align: left;
	padding: 5px 8px 8px 8px;
}
th.artist{
	text-align: center;
}
tr:nth-child(even){
	background-color:lightgrey;
}
</style>
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors' , 1);

//Connect to MySQL
include("../common.php");
$db = mysqli_connect($hostname, $username, $password, $database);
if(mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
}
//print("Successfully connected to MySQL!<br>");

switch($_POST["query"]){
	case "query_10":
		echo "<p class=\"indigo\">Query: get artists</p><br>";
		echo "SQL: <i>select * from artists;</i><br>";
		$result=execute_0("select * from artists;");
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
			echo "<table><tr><th>Artist Name</th><th>Genre</th></tr>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$artist = $entry["artist_name"];
				$genre = $entry["genre"];
				echo "<tr><td>$artist</td><td>$genre</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "There are no artists in the database.<br><br>";
		}
		break;
	case "query_11":
		echo "<p class=\"indigo\">Query: get id</p><br>";
		$artist = length_check($_POST["artist_11"],ARTIST);
		$type = $_POST["type_11"];
		$title = length_check($_POST["title_11"],TITLE);
		echo "SQL: <i>select id from catalog where artist_name='$artist' and type='$type' and song_title='$title';</i><br>";
		$result = execute_2("select id from catalog where artist_name='{PARAM_1}' and type='$type' and song_title='{PARAM_2}';",array($artist,$title));
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
			echo "<table>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$id = $entry["id"];
				echo "<tr><th>ID</th><td><b>$id</b></td></tr>";
			}
			echo "<tr><th>Artist Name</th><td>$artist</td></tr>";
			echo "<tr><th>Type</th><td>$type</td></tr>";
			echo "<tr><th>Album/Song Title</th><td>$title</td></tr>";
			echo "</table><br><br>";
		}
		else{
			echo "No matching entry in <i>catalog</i> for that combination. Try again with different parametes.<br><br>";
		}
		break;
	case "query_12":
		echo "<p class=\"indigo\">Query: get entry by id</p><br>";
		$id = $_POST["id_12"];
		echo "SQL: <i>select * from catalog where id='$id';</i><br>";
		$result = execute_0("select * from catalog where id='$id';");
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
			echo "<table>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				echo "<tr><th>ID</th><td>$id</td></tr>";
				$artist = $entry["artist_name"];
				echo "<tr><th>Artist Name</th><td>$artist</td></tr>";
				$type = $entry["type"];
				echo "<tr><th>Type</th><td>$type</td></tr>";
				$song = $entry["song_title"];
				echo "<tr><th>Song Title</th><td>$song";
				if($type == "album"){
					echo " <i>(this is stored as the album title repeated)</i>";
				}
				echo "</td></tr>";
				$album = $entry["album_title"];
				echo "<tr><th>Album Title</th><td>$album</td></tr>";
				echo "<tr><th>Year</th><td>";
				if($type == "song"){
					echo "<i>(this is not stored for songs, only for albums)</i>";
				}
				else{
					$year = $entry["year"];
					echo "$year";
				}
				echo "</td></tr></table><br><br>";
			}
		}
		else{
			echo "No entry in <i>catalog</i> for that ID. Try again with a different ID.<br><br>";
		}
		break;
	case "query_13":
		echo "<p class=\"indigo\">Query: get album</p><br>";
		$artist = length_check($_POST["artist_13"],ARTIST);
		$song = length_check($_POST["song_13"],TITLE);
		echo "SQL: <i>select album_title from catalog where artist_name='$artist' and song_title='$song';</i><br>";
		$result = execute_2("select album_title from catalog where artist_name='{PARAM_1}' and song_title='{PARAM_2}';",array($artist,$song));
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
			echo "<table>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$album = $entry["album_title"];
				echo "<tr><th>Album Title</th><td><b>$album</b></td></tr>";
			}
			echo "<tr><th>Song Title</th><td>$song</td></tr>";
			echo "<tr><th>Artist Name</th><td>$artist</td></tr>";
			echo "</table><br><br>";
		}
		else{
			echo "No matching entry in <i>catalog</i> for that combination. Try again with different parameters.<br><br>";
		}
		break;
	case "query_14":
		echo "<p class=\"indigo\">Query: artist album discography</p><br>";
		$artist = length_check($_POST["artist_14"],ARTIST);
		echo "SQL: <i>select album_title, year from catalog where type='album' and artist_name='$artist';</i><br>";
		$result = execute_1("select album_title,year from catalog where type='album' and artist_name='{PARAM_1}';",array($artist));
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
			echo "<table><tr><th>Album Title</th><th>Year</th></tr>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$album = $entry["album_title"];
				$year  = $entry["year"];
				echo "<tr><td>$album</td><td>$year</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No albums in <i>catalog</i> by that artist. Try again with a different artist.<br>User Tip: execute the <i>get artists</i> query for a complete list of artists in the database.<br><br>";
		}
		break;
	case "query_15":
		echo "<p class=\"indigo\">Query: artist album tracklist</p><br>";
		$artist = length_check($_POST["artist_15"],ARTIST);
		$album = length_check($_POST["album_15"],TITLE);
		echo "SQL: <i>select catalog.song_title, catalog.type, catalog.year, collaborations.collaborator from catalog left join collaborations on catalog.id=collaborations.song_id where catalog.artist_name='$artist' and catalog.album_title='$album';</i><br>";
		$result = execute_2("select catalog.song_title,catalog.type,catalog.year,collaborations.collaborator from catalog left join collaborations on catalog.id=collaborations.song_id where catalog.artist_name='{PARAM_1}' and catalog.album_title='{PARAM_2}';",array($artist,$album));
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
			//OUTPUT: 1	TRACK (feat. COLLAB)
			$tn = 1;
			echo "<table><tr><th>Track Number</th><th>Title</th></tr>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$song = $entry["song_title"];
				$type = $entry["type"];
				$collab = $entry["collaborator"];
				if($type=="album"){
					$year = $entry["year"];
					echo "<tr><td>Album</td><th>$album ($year)</th></tr>";
				}
				else{
					echo "<tr><td>$tn</td><td>$song";
					if($collab != NULL){
						echo " (feat. $collab)";
					}
					echo "</td></tr>";
					$tn += 1;
				}
			}
			echo "</table><br><br>";
		}
		else{
			echo "No matching entries in <i>catalog</i> for that combination. Try again with different parameters.<br><br>";
		}
		break;
	case "query_16":
		echo "<p class=\"indigo\">Query: artist full discography</p><br>";
		$artist = length_check($_POST["artist_16"],ARTIST);
		echo "SQL: <i>select collaborations.collaborator, catalog.type, catalog.song_title, catalog.album_title, catalog.year from catalog left join collaborations on catalog.id=collaborations.song_id where catalog.artist_name='$artist';</i><br>";
		$result = execute_1("select collaborations.collaborator,catalog.type,catalog.song_title,catalog.album_title,catalog.year from catalog left join collaborations on catalog.id=collaborations.song_id where catalog.artist_name='{PARAM_1}';",array($artist));
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
		/****************************************************************************
		OUTPUT: _	ALBUM (year)		--> type=="album"
		OUTPUT: 1	TRACK (feat. collab)	--> type=="song",album_title == $ref
		OUTPUT:					--> type=="album",!$first
		OUTPUT: _	NEXT ALBUM (year)
		
		Three conditions:
		- Current Album album
		- Current Album song
		- Next Album album
		*****************************************************************************/
			echo "<table>";
			$first = true;
			while($entry = mysqli_fetch_array($result)){
				$collab = $entry["collaborator"];
				$type = $entry["type"];
				$song = $entry["song_title"];
				$album = $entry["album_title"];
				if($type=="album"){
					if(!$first){
						echo "<tr><td></td><td></td></tr>";
					}
					$ref = $album;
					$tn = 1;
					$first = false;
					$year = $entry["year"];
					echo "<tr><th></th><th>$album ($year)</th></tr>";
				}
				else{
					if($album == $ref){
						echo "<tr><td>$tn</td><td>$song";
						if($collab != NULL){
							echo " (feat. $collab)";
						}
						echo "</td></tr>";
						$tn += 1;
					}
				}
			}
			echo "</table><br><br>";
		}
		else{
			echo "No matching entries in <i>catalog</i> for that artist. Try again with a different artist.<br>User Tip: execute the <i>get artists</i> query for a complete list of artists in the database.<br><br>";
		}
		break;
	case "query_17":
		echo "<p class=\"indigo\">Query: album detail</p><br>";
		$artist = length_check($_POST["artist_17"],ARTIST);
		$album = length_check($_POST["album_17"],TITLE);
		echo "SQL: <i>select catalog.type, catalog.song_title, catalog.year, collaborations.collaborator, certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.artist_name='$artist' and catalog.album_title='$album';</i><br>";
		$result = execute_2("select catalog.type,catalog.song_title,catalog.year,collaborations.collaborator,certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.artist_name='{PARAM_1}' and catalog.album_title='{PARAM_2}';",array($artist,$album));
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
			//OUTPUT: 1	TRACK (feat. COLLAB)	CERT
			$tn = 1;
			echo "<table><tr><th>Track Number</th><th>Title</th><th>Certification</th></tr>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$title = $entry["song_title"];
				$type = $entry["type"];
				$collab = $entry["collaborator"];
				$cert = $entry["certification"];
				if($type == "album"){
					$year = $entry["year"];
					echo "<tr><td>Album</td><th>$album ($year)</th><td>";
					if($cert != NULL){
						echo "$cert";
					}
					echo "</td></tr>";
				}
				else{
					echo "<tr><td>$tn</td><td>$title";
					if($collab != NULL){
						echo " (feat. $collab)";
					}
					echo "</td><td>";
					if($cert != NULL){
						echo "$cert";
					}
					echo "</td></tr>";
					$tn += 1;
				}
			}
			echo "</table><br><br>";
		}
		else{
			echo "No matching entries for that combination. Try again with different parameters.<br><br>";
		}
		break;
	case "query_18":
		echo "<p class=\"indigo\">Query: artist detail</p><br>";
		$artist = length_check($_POST["artist_18"],ARTIST);
		echo "SQL: <i>select catalog.type, catalog.song_title, catalog.album_title, catalog.year, collaborations.collaborator, certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.artist_name='$artist';</i><br>";
		$result = execute_1("select catalog.type,catalog.song_title,catalog.album_title,catalog.year,collaborations.collaborator,certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.artist_name='{PARAM_1}';",array($artist));
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
		/**********************************************************************************
		OUTPUT: _	ALBUM (year)		CERT 	--> type=="album"
		OUTPUT: 1	TRACK (feat. collab	CERT	--> type=="song",album_title==$ref
		OUTPUT:						--> type=="album",!$first
		OUTPUT: _	NEXT ALBUM (year)	CERT	

		Three conditions:
		- Current Album album
		- Current Album song
		- Next Album album
		***********************************************************************************/
			echo "<table>";
			$first = true;
			while($entry = mysqli_fetch_array($result)){
				$type = $entry["type"];
				$song = $entry["song_title"];
				$album = $entry["album_title"];
				$collab = $entry["collaborator"];
				$cert = $entry["certification"];
				if($type=="album"){
					if(!$first){
						echo "<tr><td></td><td></td><td></td></tr>";
					}
					$ref = $album;
					$tn = 1;
					$first = false;
					$year = $entry["year"];
					echo "<tr><th>Track Number</th><th>Title</th><th>Certification</th></tr><tr><td>Album</td><th>$album ($year)</th><td>";
					if($cert != NULL){
						echo "$cert";
					}
					echo "</td></tr>";
				}
				else{
					if($album == $ref){
						echo "<tr><td>$tn</td><td>$song";
						if($collab != NULL){
							echo " (feat. $collab)";
						}
						echo "</td><td>";
						if($cert != NULL){
							echo "$cert";
						}
						echo "</td></tr>";
						$tn += 1;
					}
				}
			}
			echo "</table><br><br>";
		}
		else{
			echo "No matching entries found. Try again with a different artist.<br>User Tip: execute the <i>get artists</i> query for a complete list of artists in the database.<br><br>";
		}
		break;
	case "query_19":
		echo "<p class=\"indigo\">Query: dump</p><br>";
		echo "SQL: <i>select catalog.artist_name, catalog.type, catalog.song_title, catalog.album_title, catalog.year, collaborations.collaborator, certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id;</i><br>";
		$result = execute_0("select catalog.artist_name,catalog.type,catalog.song_title,catalog.album_title,catalog.year,collaborations.collaborator,certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id;");
		$number = mysqli_num_rows($result);
		echo "Number of entries: $number<br><br>";
		if($number != 0){
		/**********************************************************************************
		OUTPUT:		 	ARTIST NAME				--> colspan="3"
		OUTPUT:Track Number	Title			Certification	--> same as above
		OUTPUT: _		ALBUM(year)		CERT (not null)	--> same as above
		OUTPUT: 1		SONG (feat. COLLAB)	CERT (not null)	--> same as above
		OUTPUT:								--> blank line
		OUTPUT:			ARTIST NAME				--> next artist

		Three conditions:
		- Current Artist, Current Album
		- Current Artist, New Album
		- New Artist
		***********************************************************************************/
			echo "<table>";
			$first_artist=true;
			$ref_artist="";
			$first_album=true;
			$ref_album="";
			while($entry = mysqli_fetch_array($result)){
				$artist = $entry["artist_name"];
				$type = $entry["type"];
				$song = $entry["song_title"];
				$album = $entry["album_title"];
				$collab = $entry["collaborator"];
				$cert = $entry["certification"];
				if($artist != $ref_artist){
					if(!$first_artist){
						echo "<tr><td colspan=\"3\"></td></tr><tr><td colspan=\"3\"></td></tr>";
					}
					$ref_artist = $artist;
					$first_artist=false;
					$first_album=true;
					echo "<tr><th colspan=\"3\" class=\"artist\">$artist</th></tr>";			
				}
				if($type=="album"){
					if(!$first_album){
						echo "<tr><td colspan=\"3\"></td></tr>";
					}
					$ref_album = $album;
					$tn = 1;
					$first_album=false;
					$year = $entry["year"];
					echo "<tr><th>Track Number</th><th>Title</th><th>Certification</th></tr><tr><td>Album</td><th>$album ($year)</th><td>";
					if($cert != NULL){
						echo "$cert";
					}
					echo "</td></tr>";
				}
				else{
					if($album == $ref_album){
						echo "<tr><td>$tn</td><td>$song";
						if($collab != NULL){
							echo " (feat. $collab)";
						}
						echo "</td><td>";
						if($cert != NULL){
							echo "$cert";
						}
						echo "</td></tr>";
						$tn += 1;
					}
				}
			}
			echo "</table><br><br>";
		}
		else{
			echo "If you see this error, there is likely an error in the SQL that did not kill the program, or the database is empty, in which case it's a little strange you're dumping an empty database. Otherwise, you should never see this error, unless you are inspecting the source code, in which case, congratulations, you found an Easter egg! ^-^<br><br>";
		}
		break;
	
	case "query_20":
		echo "<p class=\"indigo\">Query: artist successes</p><br>";
		$artist = length_check($_POST["artist_20"],ARTIST);
		echo "SQL: <i>select catalog.song_title, catalog.type, collaborations.collaborator, certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.artist_name='$artist';</i><br>";
		$result = execute_1("select catalog.song_title,catalog.type,collaborations.collaborator,certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.artist_name='{PARAM_1}';",array($artist));
		$number = mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if($number != 0){
			echo "<table><tr><th>Type</th><th>Title</th><th>Certification</th></tr>";
			while($entry=mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$title = $entry["song_title"];
				$type = $entry["type"];
				$collab = $entry["collaborator"];
				$cert = $entry["certification"];
				echo "<tr><td>$type</td><td>$title";
				if($collab != NULL){
					echo " (feat. $collab)";
				}
				echo "</td><td>$cert</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No certifications found for this artist.<br><br>";
		}
		break;
	case "query_21":
		echo "<p class=\"indigo\">Query: artist successful solos</p><br>";
		$artist = length_check($_POST["artist_21"],ARTIST);
		echo "SQL: <i>select catalog.song_title, catalog.type, certifications.certification from catalog left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.id not in (select song_id from collaborations) and catalog.artist_name='$artist';</i><br>";
		$result = execute_1("select catalog.song_title,catalog.type,certifications.certification from catalog left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.id not in (select song_id from collaborations) and catalog.artist_name='{PARAM_1}';",array($artist));
		$number = mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if($number != 0){
			echo "<table><tr><th>Type</th><th>Title</th><th>Certification</th></tr>";
			while($entry=mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$title = $entry["song_title"];
				$type = $entry["type"];
				$cert = $entry["certification"];
				echo "<tr><td>$type</td><td>$title</td><td>$cert</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No certifications found for this artist.<br><br>";
		}
		break;
	case "query_22":
		echo "<p class=\"indigo\">Query: artist successful collabs</p><br>";
		$artist = length_check($_POST["artist_22"],ARTIST);
		echo "SQL: <i>select catalog.song_title, catalog.type, collaborations.collaborator, certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.id in (select song_id from collaborations) and catalog.artist_name='$artist';</i><br>";
		$result = execute_1("select catalog.song_title,catalog.type,collaborations.collaborator,certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.id in (select song_id from collaborations) and catalog.artist_name='{PARAM_1}';",array($artist));
		$number = mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if($number != 0){
			echo "<table><tr><th>Type</th><th>Title</th><th>Certification</th></tr>";
			while($entry=mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$title = $entry["song_title"];
				$type = $entry["type"];
				$collab = $entry["collaborator"];
				$cert = $entry["certification"];
				echo "<tr><td>$type</td><td>$title (feat. $collab)</td><td>$cert</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No certifications found for this artist.<br><br>";
		}
		break;
	case "query_23":
		echo "<p class=\"indigo\">Query: all successes</p><br>";
		echo "SQL: <i>select catalog.artist_name, collaborations.collaborator, catalog.type, catalog.song_title, certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id;</i><br>";
		$result = execute_0("select catalog.artist_name, collaborations.collaborator, catalog.type, catalog.song_title, certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id;");
		$number = mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if($number != 0){
		/**********************************************************************************
		OUTPUT:			ARTIST_NAME				--> colspan="3"
		OUTPUT:	Type		Title			Certification	--> header row
		OUTPUT:	TYPE		TITLE (feat. COLLAB)	CERT		--> as above
		OUTPUT:								--> blank line
		OUTPUT:			ARTIST_NAME				--> next

		Three conditions:
		- Current Artist artist
		- Current Artist cert
		- Next Artist artist
		***********************************************************************************/
			$first = true;
			$ref = "";
			echo "<table>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$artist = $entry["artist_name"];
				$type = $entry["type"];
				$title = $entry["song_title"];
				$collab = $entry["collaborator"];
				$cert = $entry["certification"];
				if($artist != $ref){
					if(!$first){
						echo "<tr><td colspan=\"3\"></td></tr><tr><td colspan=\"3\"></td></tr>";
					}	
					$first = false;
					$ref = $artist;
					echo "<tr><th colspan=\"3\" class=\"artist\">$artist</th></tr><tr><th>Type</th><th>Title</th><th>Certification</th></tr>";
				}
				echo "<tr><td>$type</td><td>$title";
				if($collab != NULL){
					echo " (feat. $collab)";
				}
				echo "</td><td>$cert</td></tr>";
			}	
			echo "</table><br><br>";
		}
		else{
			echo "No certification results found.<br><br>";
		}
		break;
	case "query_24":
		echo "<p class=\"indigo\">Query: all successful solos</p><br>";
		echo "SQL: <i>select catalog.artist_name, catalog.type, catalog.song_title, certifications.certification from catalog left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.id not in (select song_id from collaborations);</i><br>";
		$result = execute_0("select catalog.artist_name,catalog.type,catalog.song_title,certifications.certification from catalog left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.id not in (select song_id from collaborations);");
		$number=mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if ($number != 0){
		/**********************************************************************************
		OUTPUT: 		ARTIST_NAME				--> colspan="3"
		OUTPUT:	Type		Title			Certification	--> title row
		OUTPUT: TYPE		TITLE 			CERT		--> as above
		OUTPUT:								--> blank row
		OUTPUT:			ARTIST_NAME				--> class="artist"
		
		Three conditions:
		- Current Artist artist
		- Current Artist cert
		- Next Artist artist
		***********************************************************************************/
			$first = true;
			$ref = "";
			echo "<table>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$artist = $entry["artist_name"];
				$type = $entry["type"];
				$title = $entry["song_title"];
				$cert = $entry["certification"];
				if($artist != $ref){
					if(!$first){
						echo "<tr><td colspan=\"3\"></td></tr><tr><td colspan=\"3\"></td></tr>";
					}
					$first = false;
					$ref = $artist;
					echo "<tr><th colspan=\"3\" class=\"artist\">$artist</th></tr><tr><th>Type</th><th>Title</th><th>Certification</th></tr>";
				}
				echo "<tr><td>$type</td><td>$title</td><td>$cert</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No certification results found.<br><br>";
		}
		break;
	case "query_25":
		echo "<p class=\"indigo\">Query: all successful collabs</p><br>";
		echo "SQL: <i>select catalog.artist_name, catalog.type, catalog.song_title, collaborations.collaborator, certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.id in (select song_id from collaborations);</i><br>";
		$result = execute_0("select catalog.artist_name,catalog.type,catalog.song_title,collaborations.collaborator,certifications.certification from catalog left join collaborations on catalog.id=collaborations.song_id left join certifications on catalog.id=certifications.song_id where catalog.id=certifications.song_id and catalog.id in (select song_id from collaborations);");
		$number = mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if ($number != 0){
		/**********************************************************************************
		OUTPUT:			ARTIST_NAME				--> colspan="3"
		OUTPUT:	Type		Title			Certification	--> header row
		OUTPUT: TYPE		TITLE (feat. COLLAB)	CERT		--> as above
		OUTPUT:								--> blank rows
		OUTPUT:			ARTIST_NAME				--> class="artist"

		Three conditions:
		- Current Artist artist
		- Current Artist cert
		- Next Artist artist
		***********************************************************************************/
			$first = true;
			$ref = "";
			echo "<table>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$artist = $entry["artist_name"];
				$type = $entry["type"];
				$title = $entry["song_title"];
				$collab = $entry["collaborator"];
				$cert = $entry["certification"];
				if($artist != $ref){
					if(!$first){
						echo "<tr><td colspan=\"3\"></td></tr><tr><td colspan=\"3\"></td></tr>";
					}
					$first = false;
					$ref = $artist;
					echo "<tr><th colspan=\"3\" class=\"artist\">$artist</th></tr><tr><th>Type</th><th>Title</th><th>Certification</th></tr>";
				}
				echo "<tr><td>$type</td><td>$title (feat. $collab)</td><td>$cert</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No certification results found.<br><br>";
		}
		break;
	case "query_26":
		echo "<p class=\"indigo\">Query: comparative success</p><br>";
		echo "SQL: <i>select artist_name,count(*) from (select catalog.artist_name, certifications.certification from catalog, certifications where catalog.id=certifications.song_id) as certs_list group by artist_name;</i><br>";
		$result = execute_0("select artist_name,count(*) from (select catalog.artist_name,certifications.certification from catalog,certifications where catalog.id=certifications.song_id) as certs_list group by artist_name;");
		$number = mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if($number != 0){
			echo "<table><tr><th>Artist Name</th><th>Number of Certifications</th></tr>";
			while($entry = mysqli_fetch_array($result)){
				$artist = $entry["artist_name"];
				$certcount = $entry["count(*)"];
				echo "<tr><td>$artist</td><td>$certcount</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No certification results found.<br><br>";
		}
		break;
	case "query_27":
		echo "<p class=\"indigo\">Query: comparative success in genre</p><br>";
		$genre = length_check($_POST["genre_27"],GENRE);
		echo "SQL: <i>select artist_name, count(*) from (select catalog.artist_name, certifications.certification from catalog,artists,certifications where catalog.id=certifications.song_id and artists.artist_name=catalog.artist_name and artists.genre='$genre') as certs_list group by artist_name;</i><br>";
		$result = execute_1("select artist_name,count(*) from (select catalog.artist_name,certifications.certification from catalog,artists,certifications where catalog.id=certifications.song_id and artists.artist_name=catalog.artist_name and artists.genre='{PARAM_1}') as certs_list group by artist_name;",array($genre));
		$number = mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if($number != 0){
			echo "<table><tr><th>Artist Name</th><th>Number of Certifications</th></tr>";
			while($entry = mysqli_fetch_array($result)){
				$artist = $entry["artist_name"];
				$certcount = $entry["count(*)"];
				echo "<tr><td>$artist</td><td>$certcount</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No certification results found. Perhaps try again with a different genre.<br>User Tip: execute the <i>get artists</i> query for a complete list of genres in the database.<br><br>";
		}
		break;
	case "query_28":
		echo "<p class=\"indigo\">Query: comparative solo success</p><br>";
		echo "SQL: <i>select artist_name, count(*) from (select catalog.artist_name, certifications.certification from catalog,certifications where catalog.id=certifications.song_id and catalog.id not in (select song_id from collaborations)) as solo_certs group by artist_name;</i><br>";
		$result = execute_0("select artist_name,count(*) from (select catalog.artist_name,certifications.certification from catalog,certifications where catalog.id=certifications.song_id and catalog.id not in (select song_id from collaborations)) as solo_certs group by artist_name;");
		$number = mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if ($number != 0){
			echo "<table><tr><th>Artist Name</th><th>Number of Certifications</th></tr>";
			while ($entry = mysqli_fetch_array($result)){
				$artist = $entry["artist_name"];
				$certcount = $entry["count(*)"];
				echo "<tr><td>$artist</td><td>$certcount</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No certification results found.<br><br>";
		}
		break;
	case "query_29":
		echo "<p class=\"indigo\">Query: comparative solo success in genre</p><br>";
		$genre = length_check($_POST["genre_29"],GENRE);
		echo "SQL: <i>select artist_name, count(*) from (select catalog.artist_name, certifications.certification from catalog,artists,certifications where catalog.id=certifications.song_id and catalog.id not in (select song_id from collaborations) and catalog.artist_name=artists.artist_name and artists.genre='$genre') as solo_certs group by artist_name;</i><br>";
		$result = execute_1("select artist_name,count(*) from (select catalog.artist_name,certifications.certification from catalog,artists,certifications where catalog.id=certifications.song_id and catalog.id not in (select song_id from collaborations) and catalog.artist_name=artists.artist_name and artists.genre='{PARAM_1}') as solo_certs group by artist_name;",array($genre));
		$number = mysqli_num_rows($result);
		echo "Number of results: $number<br><br>";
		if($number != 0){
			echo "<table><tr><th>Artist Name</th><th>Number of Certifications</th></tr>";
			while($entry = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$artist = $entry["artist_name"];
				$certcount = $entry["count(*)"];
				echo "<tr><td>$artist</td><td>$certcount</td></tr>";
			}
			echo "</table><br><br>";
		}
		else{
			echo "No certification results found. Perhaps try again with a different genre.<br>User Tip: execute the <i>get artists</i> query for a complete list of genres in the database.<br><br>";
		}
		break;
}

echo "<a href=\"./report_request.html\">Return to Query Page</a>";

mysqli_close($db);
?>
