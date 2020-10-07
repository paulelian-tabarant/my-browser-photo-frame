<?php
    // DB connection script
	include_once('../phpFunctions/dbConnect.php');

	if ($dbSuccess) {

			$userID = $_SESSION["userLogged"];

			if (!isset($userID)) {
					http_response_code(404);
					die('Logged user not found. Please sign in again.');
			}

			include_once("../phpFunctions/dbAuth.php");
			$userName = getUserNameByID($dbConn, $userID);

			echo json_encode($userName);
	}
	else {
			http_response_code(500);
	}
?>
