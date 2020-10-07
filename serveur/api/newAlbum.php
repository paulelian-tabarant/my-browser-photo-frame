<?php
    // DB connection script
	include_once('../phpFunctions/dbConnect.php');

	if ($dbSuccess) {
		include_once('../phpFunctions/dbAlbums.php');

		$data = json_decode(file_get_contents("php://input"));
		$data = (array) $data;
		
		$albumName = $data["name"];
		$albumDescription = $data["description"];
		$albumPassword = $data["password"];
		
		$ownerID = $_SESSION["userLogged"];

		if (!isset($ownerID)) {
				http_response_code(401);
				die('No user logged.');
		}

		if (!isset($albumName) OR !isset($albumDescription) OR !isset($albumPassword)) {
				http_response_code(400);
				die('Bad request parameters.');
		}

		createNewAlbum($dbConn, $albumName, $albumDescription, $albumPassword, $ownerID);
		http_response_code(200);
	}
	else {
			http_response_code(500);
	}
?>
