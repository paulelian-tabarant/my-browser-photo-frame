<?php
	// DB connection script
	include_once('../phpFunctions/dbConnect.php');
	
	if ($dbSuccess) {
		include_once('../../storage-config.php');

		$name = $_GET["name"];
		$path = $UPLOAD_DIR . $name;
		$im = imagecreatefromjpeg($path);
		if (!$im) {
				http_response_code(404);
				die('Image file not found.');
		}

		include_once('../phpFunctions/dbPhotos.php');
		include_once('../phpFunctions/dbAlbums.php');

		$userID = $_SESSION["userLogged"];
		$loadedAlbumID = $_SESSION["albumLoaded"];
		$albumID = getAlbumOfImage($dbConn, $name);
		if (!userIsAlbumOwner($dbConn, $userID, $albumID) && $loadedAlbumID != $albumID) {
				http_response_code(403);
				die('You must be logged as the album owner to access its photos.');
		}

		header('Content-Type: image/jpeg');
		// Resizing with a 1/4 ratio
		list($width, $height) = getimagesize($path);
		$newWidth = $width * 0.25;
		$newHeight = $height * 0.25;
		$newImg = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($newImg, $im, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		imagejpeg($newImg);
		imagedestroy($im);
		imagedestroy($newImg);
	}
	else {
			http_response_code(500);
	}
?>
