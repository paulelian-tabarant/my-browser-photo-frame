<?php

	// DB connection script
	include_once('../../db-config.php'); 
	$dbSuccess = false;
	$dbConn = mysqli_connect($db['hostname'],$db['username'],$db['password']);
	
	if ($dbConn) {		
		$dbSelected = mysqli_select_db($dbConn, $db['database']);
		if ($dbSelected) {
			$dbSuccess = true;
		} else {
			echo "DB Selection FAILed";
		}
	} 

	if ($dbSuccess) {
		include_once('../phpFunctions/dbAuth.php');

		$data = json_decode(file_get_contents("php://input"));
		$data = (array) $data;

		$albumName = $data["albumName"];
		$albumPassword = $data["albumPassword"];

		if (!albumAuth($dbConn, $albumName, $albumPassword)) {
			http_response_code(403);
		}
		else {
			http_response_code(200);
		}
	}


?>
