var evtSource = new EventSource("photosDirChanged.php");

evtSource.onmessage = function(e) {
	console.log('Received server notification.');
}
