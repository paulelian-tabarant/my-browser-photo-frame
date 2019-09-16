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
        include_once('../../htconfig/varConfig.php');
        include_once('../phpFunctions/dbPhotos.php');
        include_once('../phpFunctions/dbAlbums.php');

        $data = json_decode(file_get_contents("php://input"));
		$data = (array) $data;

		$fileName = $data["name"];

        if (!isset($fileName)) {
            http_response_code(400);
            die('Error: no file name specified.');
        }

        $albumID = getAlbumOfImage($dbConn, $fileName);
        $userID = $_SESSION["userLogged"];

        if (userIsAlbumOwner($dbConn, $userID, $albumID)) {
            $filePath = $UPLOAD_DIR . $fileName;

            if (unlink($filePath)) {
                // Remove database record of the photo
                deletePhoto($dbConn, $fileName);
            }
            else {
                http_response_code(500);
                echo 'Error deleting ' . $fileName . '.';
            }
        }
        else {
            http_response_code(401);
            echo 'Error: Album does not appear within your own list.';
        }
    }
    else {
        http_response_code(500);
    }
?>