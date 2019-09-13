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

        $userID = $_SESSION['userLogged'];
        if (isset($userID)) {
            include_once('../phpFunctions/dbAlbums.php');
            $albumsList = listAlbumsOfUser($dbConn, $userID);

            if (!empty($albumsList)) {
                echo json_encode($albumsList);
            }
            else {
                http_response_code(404);
            }
        }
        else {
            http_response_code(403);
        }

    }
    else {
        http_response_code(500);
    }

?>