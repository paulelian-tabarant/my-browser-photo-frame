<?php
	// DB connection script
	include_once('../phpFunctions/dbConnect.php');

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
