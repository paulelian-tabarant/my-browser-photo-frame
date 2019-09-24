<?php
	/**
	 * Checks for image directory changes and notifies the client
	 * when a change occurs.
	 */

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
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');

		$albumID = $_SESSION["albumLoaded"];
		// Temporary fix : connection should be closed on client side
		if (!isset($albumID)) {
			exit();
		}

		$lastContentArray = listPhotosInAlbum($dbConn, $albumID);
		// Condition for sending the event to the client
		if (sizeof($lastContentArray) != sizeof($_SESSION["photosDirContent"])) {
			echo 'data: ' . PHP_EOL;
			echo PHP_EOL;
		}

	}

	else {
		http_response_code(500);
	}

?>
