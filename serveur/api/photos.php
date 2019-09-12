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
    

        // Get album ID from last login attempt
        $albumID = $_SESSION["albumLoaded"];

        // We can recover album content from "tPhotos" database
        if (isset($albumID)) {

            $photosArray = listPhotosInAlbum($dbConn, $albumID);

            if (empty($photosArray)) {
                http_response_code(404);
                echo 'Album not found.';
            }
            else {
                // store the lastly delivered list of photos
                // to monitor changes in database content
                $_SESSION["lastContentArray"] = $photosArray;

                echo json_encode($photosArray);
            }
        }
        else {
            http_response_code(403);
            echo 'Access to this album was not granted.';
        }
    }
?>