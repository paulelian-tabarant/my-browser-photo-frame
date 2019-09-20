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
        include_once('../phpFunctions/dbAlbums.php');
        include_once('../phpFunctions/dbPhotos.php');

        $albumName = $_GET["name"];
        $albumID = $_SESSION["albumLoaded"];
        $loggedUserID = $_SESSION["userLogged"];

        $reqAlbumID = getAlbumIDByName($dbConn, $albumName);

        // Check if the client has the right to access the album
        // (either logged to view the album or logged as the album owner)
        if (($reqAlbumID != $albumID) AND (!userIsAlbumOwner($dbConn, $loggedUserID, $reqAlbumID))) {
            http_response_code(401);
            echo 'Access to this album was not granted.';
        }
        else {
            $selectAlbum_SQL = "SELECT name, description, coverID FROM tAlbums ";
            $selectAlbum_SQL .= "WHERE ID = ".$reqAlbumID;

            $albumInfo = [];
            $selectAlbum_res = mysqli_query($dbConn, $selectAlbum_SQL);
            while ($row = mysqli_fetch_array($selectAlbum_res, MYSQLI_ASSOC)) {
                $albumInfo["name"] = $row["name"];
                $albumInfo["description"] = $row["description"];
                $albumInfo["cover"] = getPhotoNameByID($dbConn, $row["coverID"]);
            }

            echo json_encode($albumInfo);
        }
    }
    else {
        http_response_code(500);
    }

?>