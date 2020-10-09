<?php
	$currentUserID = $_SESSION["userLogged"];

	if (isset($currentUserID)) {
		$unset($_SESSION["userLogged"]);
		echo "User successfully logged out.";
	}

	http_response_code(200);
?>