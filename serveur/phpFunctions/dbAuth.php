<?php
    include_once('dbAlbums.php');

    function albumAuth($dbConn, $albumName, $albumPassword) {
			// Compute SHA 512 bytes hash of password
			$passwordSHA2 = hash("sha512", $albumPassword);

			$tAlbums_SQLselect = "SELECT password FROM tAlbums ";
			$tAlbums_SQLselect .= "WHERE name= '".$albumName."' ";

			$query_getAlbumData = mysqli_query($dbConn, $tAlbums_SQLselect);
			while ($row = mysqli_fetch_array($query_getAlbumData, MYSQLI_ASSOC)) {
				$passwordRetrieved = $row['password'];
			}

			mysqli_free_result($query_getAlbumData);

			if (!empty($passwordRetrieved) AND ($passwordSHA2 == $passwordRetrieved)) {
				// Store album name for getPhotos() further requests
				$albumID = getAlbumIDByName($dbConn, $albumName);
				$_SESSION["albumLoaded"] = $albumID;
				$authSuccess = true;
			}
			else {
				// In order to log out from previously logged album
				if (isset($_SESSION["albumLoaded"])) {
					unset($_SESSION["albumLoaded"]);
				}
				$authSuccess = false;
			} 

			return $authSuccess;
		}
		
		function createUser($dbConn, $username, $password) {
			$passwordSHA2 = hash("sha512", $password);
			
			$createUser_SQL = "INSERT INTO tUsers (name, password) ";
			$createUser_SQL .= "VALUES ('" . $username . "', '" . $passwordSHA2 . "') ";

			$createUser_res = mysqli_query($dbConn, $createUser_SQL);

			if (!$createUser_res) return false;

			$newUserID = getUserIDByName($dbConn, $username);
			if (isset($newUserID)) {
				$_SESSION["userLogged"] = $newUserID;
			}

			mysqli_free_result($createUser_res);
			// Confirm user creation
			return true;
		}

    function userAuth($dbConn, $username, $password) {
			$passwordSHA2 = hash("sha512", $password);

			$selectPassword_SQL = "SELECT ID, password FROM tUsers ";
			$selectPassword_SQL .= " WHERE name='" . $username . "' "; 

			$selectPassword_res = mysqli_query($dbConn, $selectPassword_SQL);
			while ($row = mysqli_fetch_array($selectPassword_res, MYSQLI_ASSOC)) {
				$IDRetrieved = $row["ID"];
				$passwordRetrieved = $row["password"];
			}

			mysqli_free_result($selectPassword_res);

			if (isset($passwordRetrieved) AND ($passwordSHA2 == $passwordRetrieved)) {
				$_SESSION["userLogged"] = $IDRetrieved;
				$authSuccess = true;
			}
			else {
				// Log out from previous user session if necessary
				if (isset($_SESSION["userLogged"])) {
						unset($_SESSION["userLogged"]);
				}
				$authSuccess = false;
			}

			return $authSuccess;
    }

    function getUserNameByID($dbConn, $userID) {
			$getUserName_SQL = "SELECT name FROM tUsers ";
			$getUserName_SQL .= "WHERE ID = " . $userID;

			$getUserName_res = mysqli_query($dbConn, $getUserName_SQL);

			while ($row = mysqli_fetch_array($getUserName_res, MYSQLI_ASSOC)) {
					$userName = $row["name"];
			}

			return $userName;
		}
		
		function getUserIDByName($dbConn, $username) {
			$getUserID_SQL = "SELECT ID FROM tUsers ";
			$getUserID_SQL .= "WHERE name = '" . $username . "'";

			$getUserID_res = mysqli_query($dbConn, $getUserID_SQL);

			$row = mysqli_fetch_array($getUserID_res, MYSQLI_ASSOC);
			return $row["ID"];
		}

?>