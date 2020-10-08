<?php
	// DB connection script
	include_once('../phpFunctions/dbConnect.php');

	if (!$dbSuccess) {
		http_response_code(500);
		die('Server could not access the database.');
	}

	if ($dbSuccess) {
		include_once('../../storage-config.php');
		include_once('../phpFunctions/dbAlbums.php');
		include_once('../phpFunctions/dbPhotos.php');

		$data = json_decode(file_get_contents("php://input"));
		$data = (array)$data;
		$albumName = $data["name"];
		if (!isset($albumName)) {
			http_response_code(400);
			die('Error: no album name specified.');
		}

		$albumID = getAlbumIDByName($dbConn, $albumName);
		if (!isset($albumID)) {
			http_response_code(404);
			die('Album not found.');
		}

		$userID = $_SESSION["userLogged"];
		if (!userIsAlbumOwner($dbConn, $userID, $albumID)) {
			http_response_code(403);
			die('You are not allowed to delete this album.');
		}

		// First, delete all pictures from local storage and database
		$photosArray = listPhotosInAlbum($dbConn, $albumID);
		foreach($photosArray as $photoName) {
			$photoPath = $UPLOAD_DIR . $photoName;
			// Remove file and database record
			if (unlink($photoPath)) {
				deletePhoto($dbConn, $photoName);
			}
		}
		// Delete album record in database
		deleteAlbum($dbConn, $albumID);

		http_response_code(200);
	}
?>