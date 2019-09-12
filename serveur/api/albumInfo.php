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
    
    $albumID = $_SESSION["albumLoaded"];

    if (!isset($albumID)) {
        http_response_code(403);
    }
    else {
        $selectAlbum_SQL = "SELECT name, description FROM tAlbums ";
        $selectAlbum_SQL .= "WHERE ID = ".$albumID;

        $albumInfo = [];
        $selectAlbum_res = mysqli_query($dbConn, $selectAlbum_SQL);
        while ($row = mysqli_fetch_array($selectAlbum_res, MYSQLI_ASSOC)) {
            $albumInfo["name"] = $row["name"];
            $albumInfo["description"] = $row["description"];
        }

        echo json_encode($albumInfo);
    }

?>