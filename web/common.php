<?php
//Credentials for connecting to the database
$hostname = "db";
$username = "root";
$password = "root";
$database = "music";

//Constants, for use in calls to length_check
define("ARTIST", 50, false);
define("TITLE", 100, false);
define("GENRE",  20, false);
define("CERT",   30, false);

//Simple function to ensure that input data fits the database column sizes
function length_check($ref,$len){
	if(strlen($ref) > $len){
		return substr($ref,0,$len);
	}
	return $ref;
}
/**********************************************************************
* The following series of execute functions are to be called
* based on the number and type of user inputs that the query requires.
***********************************************************************/
function execute_0($query){
	global $db;
	$records = mysqli_query($db,$query) or die(mysqli_error($db));
	return $records;
}
function execute_1($query,$parameters){
	global $db;
	$param1 = mysqli_real_escape_string($db,$parameters[0]);
	$query = str_replace("{PARAM_1}",$param1,$query);
	$records = mysqli_query($db,$query) or die(mysqli_error($db));
	return $records;	
}
function execute_2($query,$parameters){
	global $db;
	$param1 = mysqli_real_escape_string($db,$parameters[0]);
	$param2 = mysqli_real_escape_string($db,$parameters[1]);
	$query = str_replace("{PARAM_1}",$param1,$query);
	$query = str_replace("{PARAM_2}",$param2,$query);
	$records = mysqli_query($db,$query) or die(mysqli_error($db));
	return $records;
}
/*
function execute_3($query,$parameters){
	global $db;
	$param1 = mysqli_real_escape_string($db,$parameters[0]);
	$param2 = mysqli_real_escape_string($db,$parameters[1]);
	$param3 = mysqli_real_escape_string($db,$parameters[2]);
	$query = str_replace("{PARAM_1}",$param1,$query);
	$query = str_replace("{PARAM_2}",$param2,$query);
	$query = str_replace("{PARAM_3}",$param3,$query);
	$records = mysqli_query($db,$query) or die(mysqli_error($db));
	return $records;
}
*/
function execute_4($query,$parameters){
	global $db;
	$param1 = mysqli_real_escape_string($db,$parameters[0]);
	$param2 = mysqli_real_escape_string($db,$parameters[1]);
	$param3 = mysqli_real_escape_string($db,$parameters[2]);
	$param4 = mysqli_real_escape_string($db,$parameters[3]);
	$query = str_replace("{PARAM_1}",$param1,$query);
	$query = str_replace("{PARAM_2}",$param2,$query);
	$query = str_replace("{PARAM_3}",$param3,$query);
	$query = str_replace("{PARAM_4}",$param4,$query);
	$records = mysqli_query($db,$query) or die(mysqli_error($db));
	return mysqli_insert_id($db);
}
?>
