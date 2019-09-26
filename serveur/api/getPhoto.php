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

        $name = $_GET["name"];

        $path = '../images/' . $name;
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

        $quality = $_GET["quality"];

        // Default quality = 75
        if (!isset($quality)) $quality = 75;

        imagejpeg($im, null, $quality);
        imagedestroy($im);
    }
    else {
        http_response_code(500);
    }
?>