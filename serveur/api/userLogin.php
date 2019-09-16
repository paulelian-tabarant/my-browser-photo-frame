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
        include_once('../../htconfig/varConfig.php');
		include_once('../phpFunctions/dbAuth.php');

		$data = json_decode(file_get_contents("php://input"));
		$data = (array) $data;

		$username = $data["username"];
		$password = $data["password"];

		if (!userAuth($dbConn, $username, $password)) {
			http_response_code(403);
		}
		else {
			http_response_code(200);
		}
    }

    else {
        http_response_code(500);
    }
    
?>