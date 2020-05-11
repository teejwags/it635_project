<style>
.shadow{
	background-color:grey;
}
table{
	border-collapse: collapse;
}
th, td{
	text-align: left;
	padding: 5px 8px 8px 8px;
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

switch($_POST["table"]){
	case "artists":
		echo "Table: artists<br><br>";
		$artist_name = length_check($_POST["aname"],ARTIST);
		$genre = length_check($_POST["agenre"],GENRE);
		if(execute_2("insert into artists values ('{PARAM_1}','{PARAM_2}');",array($artist_name,$genre))){
			echo "Record successfully entered. Here's what we got:<br><br>";
			echo "<table><tr><th>Artist Name</th><td>$artist_name</td></tr>";
			echo "<tr><th>Genre</th><td>$genre</td></tr></table><br><br>";
		}
		else{
			echo "Error encountered!<br>";
		}
		break;

	case "catalog":
		echo "Table: catalog<br><br>";
		$artist_name = length_check($_POST["caname"],ARTIST);
		$album_title = length_check($_POST["caalbum"],TITLE);
		$id = 0;
		if($_POST["catype"] == "song"){
			$type = "song";
			$song_title = length_check($_POST["casong"],TITLE);
			$year = NULL;
			$id = execute_4("insert into catalog(artist_name,type,song_title,album_title) values ('{PARAM_1}','{PARAM_2}','{PARAM_3}','{PARAM_4}');",array($artist_name,$type,$song_title,$album_title));
		}
		else{
			$type = "album";
			$song_title = $album_title;
			$year = $_POST["cayear"];
			$id = execute_4("insert into catalog(artist_name,type,song_title,album_title,year) values ('{PARAM_1}','{PARAM_2}','{PARAM_3}','{PARAM_4}','$year');",array($artist_name,$type,$song_title,$album_title));
		}
		if($id != 0){
			echo "Record successfully entered. Here's what we got:<br><br>";
			echo "<table><tr><th>ID</th><td>$id</td></tr>";
			echo "<tr><th>Artist Name</th><td>$artist_name</td></tr>";
			echo "<tr><th>Type</th><td>$type</td></tr>";
			echo "<tr><th>Song Title</th><td>$song_title";
			if($type=="album"){
				echo " (the album name is repeated here)";
			}
			echo "</td></tr><tr><th>Album Title</th><td>$album_title</td></tr>";
			echo "<tr><th>Year</th><td>$year";
			if($type=="song"){
				echo " (year is only stored for album types)";
			}
			echo "</td></tr></table><br><br>";
		}
		else{
			echo "Error encountered!<br>";
		}
		break;
	case "collaborations":
		echo "Table: collaborations<br><br>";
		$id = $_POST["coid"];
		$collab = length_check($_POST["cocollab"],ARTIST);
		if(execute_1("insert into collaborations values ('$id','{PARAM_1}');",array($collab))){
			$record = execute_0("select artist_name,song_title from catalog where id='$id';");
			while($reference = mysqli_fetch_array($record,MYSQLI_ASSOC)){
				echo "Record successfully entered. Here's what we got (reference information is shaded grey):<br><br>";
				echo "<table><tr><th>ID</th><td>$id</td></tr>";
				$artist = $reference["artist_name"];
				echo "<tr class=\"shadow\"><th>Artist Name</th><td>$artist</td></tr>";
				$song = $reference["song_title"];
				echo "<tr class=\"shadow\"><th>Song Title</th><td>$song</td></tr>";
				echo "<tr><th>Collaborator(s)</th><td>$collab</td</tr></table><br><br>";
			}
		}
		else{
			echo "Error encountered!<br>";
		}
		break;
	case "certifications":
		echo "Table: certifications<br><br>";
		$id = $_POST["ceid"];
		$cert = length_check($_POST["cecert"],CERT);
		if(execute_1("insert into certifications values ('$id','{PARAM_1}');",array($cert))){
			$record = execute_0("select artist_name,type,song_title from catalog where id='$id';");
			while($reference = mysqli_fetch_array($record,MYSQLI_ASSOC)){
				echo "Record successfully entered. Here's what we got (reference information is shaded grey):<br><br>";
				echo "<table><tr><th>ID</th><td>$id</td></tr>";
				$artist = $reference["artist_name"];
				echo "<tr class=\"shadow\"><th>Artist Name</th><td>$artist</td></tr>";
				$type = $reference["type"];
				echo "<tr class=\"shadow\"><th>Type</th><td>$type</td></tr>";
				$type = ucfirst($type);
				$title = $reference["song_title"];
				echo "<tr class=\"shadow\"><th>$type Title</th><td>$title</td></tr>";
				echo "<tr><th>Certification</th><td>$cert</td></tr></table><br><br>";
			}
		}
		else{
			echo "Error encountered!<br>";
		}
		break;
}
echo "<a href=\"./entry_request.html\">Return to Entry Page</a>";

mysqli_close($db);
?>
