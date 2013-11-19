
		<div id="ws-data"></div>
		<script type="text/javascript">
window.onload = function() {
	var ws = new WebSocket('ws://localhost:8080');

	ws.onopen = function() {
		console.log('Connected<br/>');
		ws.send('This is a WebSocket message fdfd');
	};

	ws.onmessage = function(message) {
		console.log('Message received: ' + message.data + '<br/>');
		ws.close();
	}

	ws.onclose = function() {
		console.log('Disconnected<br/>');
	}
}
		</script>
	