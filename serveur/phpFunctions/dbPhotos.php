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
?>