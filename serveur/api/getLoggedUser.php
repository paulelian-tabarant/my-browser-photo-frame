<?php
    // DB connection script
	include_once('../../db-config.php'); 
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
