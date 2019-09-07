<?php

    function listDirContent($dir) {
        // Removes . and .. directories from the scandir return array
        $files = array_diff(scandir($dir), array('.', '..'));

        $stringArray = '[';
        foreach($files as $key => $fileName) {
            reset($files);
            $stringArray .= '"images/'.$fileName.'"';
            end($files);
            if (!($key ===  key($files))) {
                $stringArray .= ', ';
            }
        }
        $stringArray .= ']';
        return $stringArray;
    }

?>