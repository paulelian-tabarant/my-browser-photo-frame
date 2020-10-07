<?php
	// DB connection script
	include_once('../phpFunctions/dbConnect.php');

	if ($dbSuccess) {
        include_once('../../storage-config.php');
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
