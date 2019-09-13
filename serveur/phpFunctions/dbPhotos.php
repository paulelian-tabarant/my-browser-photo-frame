<?php
    function listPhotosInAlbum($dbConn, $albumID) {
        $listPhotos_SQL = "SELECT fileName, description FROM tPhotos WHERE ";
        $listPhotos_SQL .= "albumID = ".$albumID;

        $listPhotos_res = mysqli_query($dbConn, $listPhotos_SQL);

        $photosArray = [];
        while ($row = mysqli_fetch_array($listPhotos_res, MYSQLI_ASSOC)) {
            $fileName = $row["fileName"];
            // description is not considered for the moment

            array_push($photosArray, $fileName);
        }

        mysqli_free_result($listPhotos_res);

        return $photosArray;
    }

    function getAlbumOfImage($dbConn, $imageFileName) {
        $albumID_SQL = "SELECT albumID from tPhotos WHERE ";
        $albumID_SQL .= "fileName = '" . $imageFileName . "'";

        $albumID_res = mysqli_query($dbConn, $albumID_SQL);

        while ($row = mysqli_fetch_array($albumID_res, MYSQLI_ASSOC)) {
            $albumID = $row['albumID'];
        }

        mysqli_free_result($albumID_res);

        return $albumID;
    }
?>