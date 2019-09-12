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
            $albumID = getAlbumID($dbConn, $albumName);
            $_SESSION["albumLoaded"] = $albumID;
            $authSuccess = true;
        }
        else {
            $authSuccess = false;
        } 

        return $authSuccess;
    }

?>