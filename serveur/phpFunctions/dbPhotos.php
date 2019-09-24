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

    function addPhotoToAlbum($dbConn, $fileName, $albumID) {
        $addPhoto_SQL = "INSERT INTO tPhotos (fileName, albumID) ";
        $addPhoto_SQL .= "VALUES ('" . $fileName . "', " . $albumID . ")";

        $addPhoto_res = mysqli_query($dbConn, $addPhoto_SQL);

        mysqli_free_result($addPhoto_res);
    }

    function deletePhoto($dbConn, $photoName) {
        $deletePhoto_SQL = "DELETE FROM tPhotos ";
        $deletePhoto_SQL .= " WHERE fileName = '" . $photoName . "'";

        $deletePhoto_res = mysqli_query($dbConn, $deletePhoto_SQL);

        mysqli_free_result($deletePhoto_res);
    }

    function getPhotoNameByID($dbConn, $photoID) {
        $getPhoto_SQL = "SELECT fileName FROM tPhotos ";
        $getPhoto_SQL .= "WHERE ID = " . $photoID;

        $getPhoto_res = mysqli_query($dbConn, $getPhoto_SQL);

        while ($row = mysqli_fetch_array($getPhoto_res, MYSQLI_ASSOC)) {
            $photoName = $row["fileName"];
        }

        mysqli_free_result($getPhoto_res);

        return $photoName;
    }
    
    function getPhotoIDByName($dbConn, $photoName) {
        $getPhoto_SQL = "SELECT ID FROM tPhotos ";
        $getPhoto_SQL .= "WHERE fileName = '" . $photoName . "'";

        $getPhoto_res = mysqli_query($dbConn, $getPhoto_SQL);

        while ($row = mysqli_fetch_array($getPhoto_res, MYSQLI_ASSOC)) {
            $photoID = $row["ID"];
        }

        mysqli_free_result($getPhoto_res);

        return $photoID;
    }
?>