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

        // uploaded photos are stored into $_FILES array
        if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
            
            $fileName = $_FILES["photo"]["name"];
            $fileType = $_FILES["photo"]["type"];
            $fileSize = $_FILES["photo"]["size"];

            // Check file extension
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!array_key_exists($ext, $UPLOAD_ALLOWED_FORMATS)) {
                http_response_code(400);
                die("Error: Please select a valid file format.");
            }
            
            // Check file size
            $maxsize = $UPLOAD_MAXSIZE_MB * 1024 * 1024;
            if ($fileSize > $maxsize) {
                http_response_code(400);
                die("Error: File size is larger than the allowed limit.");
            }

            // Check if an album name was specified
            $albumName = $_POST["album"];
            if (!isset($albumName)) {
                http_response_code(400);
                die('Error: No album specified in the request.');
            }
            
            // Check file MIME type
            if (in_array($fileType, $UPLOAD_ALLOWED_FORMATS)) {
                // Register photo in the corresponding album of the database
                include_once('../phpFunctions/dbPhotos.php');
                include_once('../phpFunctions/dbAlbums.php');
                $userID = $_SESSION["userLogged"];
                $albumID = getAlbumIDByName($dbConn, $albumName);

                if (userIsAlbumOwner($dbConn, $userID, $albumID)) {
                    $uploadPath = $UPLOAD_DIR . $fileName;
                    // Just check if file was already uploaded before
                    // (or a file with same name already exists)
                    if (file_exists($uploadPath)) {
                        echo $fileName . " already exists.";
                    }
                    else {
                        // Hard drive photo storage
                        move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadPath);
                        chmod($uploadPath, 0666);
                        echo 'File successfully uploaded (' . $uploadPath . ').';
                    }
                    // Registration in database
                    $albumID = getAlbumIDByName($dbConn, $albumName);
                    addPhotoToAlbum($dbConn, $fileName, $albumID);
                }
                else {
                    http_response_code(401);
                    echo 'Error: User not allowed to publish photos into this album.';
                }
            }
            else {
                http_response_code(400);
                echo 'Error: File MIME type was not recognized. Try again.';
            }
        }
        else {
            http_response_code(500);
            echo 'Error: ' . $_FILES["photo"]["error"];
        }
    }
    else {
        http_response_code(500);
    }
?>