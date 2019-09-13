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

    function userIsAlbumOwner($dbConn, $userID, $albumName) {
        $getOwnerID_SQL = "SELECT ownerID from tAlbums ";
        $getOwnerID_SQL .= "WHERE name='" . $albumName ."'";

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

?>