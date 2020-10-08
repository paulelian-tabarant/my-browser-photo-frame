<?php
	// DB connection script
	include_once('../phpFunctions/dbConnect.php');

	if ($dbSuccess) {
		include_once('../phpFunctions/dbAuth.php');

		$data = (array) json_decode(file_get_contents("php://input"));

		$username = $data["username"];
		$password = $data["password"];

		if (!isset($username) OR !isset($password)) {
			http_response_code(400);
			die('Bad request : verify username and password fields have been provided.');
		}

		$userCreated = createUser($dbConn, $username, $password);
		if (!$userCreated) {
			http_response_code(500);
			die('User creation into database failed. Try again later.');
		}

		http_response_code(200);
	}
?>