<?php
	// DB connection script
	include_once('../phpFunctions/dbConnect.php');

	if ($dbSuccess) {
		include_once('../../storage-config.php');
		include_once('../phpFunctions/dbAlbums.php');
		include_once('../phpFunctions/dbPhotos.php');

		// Get album ID from last login attempt
		$albumID = $_SESSION["albumLoaded"];
		$userID = $_SESSION["userLogged"];
		$reqAlbumName = $_GET["album"];
		$reqAlbumID = getAlbumIDByName($dbConn, $reqAlbumName);

		// Condition : either logged in to view the album
		// or client is logged as a user owning this album
		if (($albumID == $reqAlbumID) OR userIsAlbumOwner($dbConn, $userID, $reqAlbumID)) {
			$photosArray = listPhotosInAlbum($dbConn, $reqAlbumID);
			if (!isset($photosArray)) {
					http_response_code(404);
					echo 'Album not found.';
			}
			else {
					// store the lastly delivered list of photos
					// to monitor changes in database content
					$_SESSION["photosDirContent"] = $photosArray;
					echo json_encode($photosArray);
			}
		}
		else {
				http_response_code(401);
				echo 'Access to this album was not granted.';
		}
	}
?>
