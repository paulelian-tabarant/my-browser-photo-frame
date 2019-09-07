<?php
/**
 * Checks for image directory changes and notifies the client
 * when a change occurs.
 */
	include_once('functions.php');
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
	
	$prevContentStr = listDirContent('../images');
	while (1) {
		$lastContentStr = listDirContent('../images');
		if ($lastContentStr != $prevContentStr) {
			echo 'data: ' . PHP_EOL;
			echo PHP_EOL;

			ob_flush();
			flush();

			$prevContentStr = $lastContentStr;
		}

		sleep(2);
	}

?>
