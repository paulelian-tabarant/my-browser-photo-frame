<?php

    function getAlbumID($dbConn, $name) {
        $getID_SQL = "SELECT ID FROM tAlbums WHERE name='".$name."'";
        $getID_res = mysqli_query($dbConn, $getID_SQL);

        while ($row = mysqli_fetch_array($getID_res, MYSQLI_ASSOC)) {
            $ID = $row["ID"];
        }

        mysqli_free_result($getID_res);

        return $ID;
    }

?>