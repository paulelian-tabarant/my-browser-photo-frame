<?php
	// DB connection script
	include_once('../../htconfig/dbConfig.php'); 
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

		$imagesDir = "../albums";

		$data = json_decode(file_get_contents("php://input"));
		$data = (array) $data;

		$albumName = $data["albumName"];
		$albumPassword = $data["albumPassword"];

		if (!albumAuth($dbConn, $albumName, $albumPassword)) {
			// In order to log out from previously logged album
			if ($_SESSION["albumLoaded"]) {
				unset($_SESSION["albumLoaded"]);
			}

			http_response_code(403);
		}
		else {
			http_response_code(200);
		}
	}


?>
