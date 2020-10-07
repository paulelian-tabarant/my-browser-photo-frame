<?php

    function getAlbumIDByName($dbConn, $name) {
			$getID_SQL = "SELECT ID FROM tAlbums WHERE name='".$name."'";
			$getID_res = mysqli_query($dbConn, $getID_SQL);

			while ($row = mysqli_fetch_array($getID_res, MYSQLI_ASSOC)) {
				$ID = $row["ID"];
			}

			mysqli_free_result($getID_res);

			return $ID;
    }

    function userIsAlbumOwner($dbConn, $userID, $albumID) {
			$getOwnerID_SQL = "SELECT ownerID from tAlbums ";
			$getOwnerID_SQL .= "WHERE ID = " . $albumID;

			$getOwnerID_res = mysqli_query($dbConn, $getOwnerID_SQL);

			while ($row = mysqli_fetch_array($getOwnerID_res, MYSQLI_ASSOC)) {
				$ownerID = $row["ownerID"];
			}

			mysqli_free_result($getOwnerID_res);

			return isset($ownerID) AND ($userID == $ownerID);
    }

    function listAlbumsOfUser($dbConn, $userID) {
			$listAlbums_SQL = "SELECT name FROM tAlbums ";
			$listAlbums_SQL .= "WHERE ownerID=" . $userID;

			$listAlbums_res = mysqli_query($dbConn, $listAlbums_SQL);

			$albumsList = [];
			while ($row = mysqli_fetch_array($listAlbums_res, MYSQLI_ASSOC)) {
				array_push($albumsList, $row["name"]);
			}

			mysqli_free_result($listAlbums_res);

			return $albumsList;
    }

    function getCoverPhotoID($dbConn, $albumID) {
			$getCover_SQL = "SELECT coverID from tAlbums ";
			$getCover_SQL .= "WHERE ID = " . $albumID;

			$getCover_res = mysqli_query($dbConn, $getCover_SQL);

			while ($row = mysqli_fetch_array($getCover_res, MYSQLI_ASSOC)) {
				$coverID = $row["coverID"];
			}

			mysqli_free_result($getCover_res);

			return $coverID;
    }

    function createNewAlbum($dbConn, $name, $description, $password, $ownerID) {
			$passwordSHA512 = hash("sha512", $password);

			$newAlbum_SQL = "INSERT INTO tAlbums (name, description, password, ownerID) ";
			$newAlbum_SQL .= "VALUES ('" . $name . "', '" . $description . "', '" . $passwordSHA512 . "', " . $ownerID . ")";

			$newAlbum_res = mysqli_query($dbConn, $newAlbum_SQL);

			mysqli_free_result($newAlbum_res);
    }

    function setAlbumCoverID($dbConn, $albumID, $coverID) {
			$setCover_SQL = "UPDATE tAlbums SET ";
			$setCover_SQL .= "coverID = " . $coverID . " ";
			$setCover_SQL .= "WHERE ID = " . $albumID;
			
			$setCover_res = mysqli_query($dbConn, $setCover_SQL);

			mysqli_free_result($setCover_res);
		}
		
		function deleteAlbum($dbConn, $albumID) {
			$deleteAlbum_SQL = "DELETE FROM tAlbums ";
			$deleteAlbum_SQL .= "WHERE ID = " . $albumID;

			$deleteAlbum_res = mysqli_query($dbConn, $deleteAlbum_SQL);

			mysqli_free_result($deleteAlbum_res);
		}
?>