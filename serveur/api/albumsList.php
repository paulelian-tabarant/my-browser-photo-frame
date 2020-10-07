<?php
	// DB connection script
	include_once('../phpFunctions/dbConnect.php');
	
	if ($dbSuccess) {
		$userID = $_SESSION["userLogged"];
		if (isset($userID)) {
			include_once('../phpFunctions/dbAlbums.php');
			$albumsList = listAlbumsOfUser($dbConn, $userID);
			echo json_encode($albumsList);
		}
		else {
			http_response_code(401);
		}
	}
	else {
			http_response_code(500);
	}
?>
