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
        include_once('../phpFunctions/dbPhotos.php');
        include_once('../phpFunctions/dbAlbums.php');

        $data = json_decode(file_get_contents("php://input"));
        $data = (array) $data;
        
        $albumName = $data["album"];
        $photoName = $data["photo"];
        if (!isset($albumName) OR !isset($photoName)) {
            http_response_code(400);
        }

        $albumID = getAlbumIDByName($dbConn, $albumName);
        $photoID = getPhotoIDByName($dbConn, $photoName);
        if (!isset($albumID) OR !isset($photoID)) {
            http_response_code(404);
            die('Photo not found in specified album.');
        }

        setAlbumCoverID($dbConn, $albumID, $photoID);

    }
    else {
        http_response_code(500);
    }
?>