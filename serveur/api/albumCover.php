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

        include_once('../phpFunctions/dbAlbums.php');
        include_once('../phpFunctions/dbPhotos.php');

        $userID = $_SESSION["userLogged"];
        $reqAlbumName = $_GET["name"];
        $reqAlbumID = getAlbumIDByName($reqAlbumName);

        if (!isset($userID)) {
            http_response_code(401);
            die('Not logged into any account.');
        }

        if (!isset($reqAlbumID)) {
            http_response_code(404);
            die('Album not found.');
        }

        if (!userIsAlbumOwner($dbConn, $userID, $reqAlbumID)) {
            http_response_code(401);
            die('User with ID ' . $userID . 'does not own this album.');
        }

        $coverID = getCoverPhotoID($dbConn, $reqAlbumID);
        $photoName = getPhotoNameByID($dbConn, $coverID);

        echo $photoName;

    }
    else {
        http_response_code(500);
    }
?>