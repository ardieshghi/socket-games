var PORT = process.env.PORT || 1337;
var server = require('net').createServer();

server.on('connection', function (socket) {

	socket.on('data', function(data) {
		if (data === 'exit') return socket.end('Goodbye...');

		console.log('Received data: ' + data);

		socket.write(data + "\n");
		socket.write("Thanks for talking to me\n");
		socket.end();
	});
});

server.listen(PORT, function() {
  	console.log('Socket server started listening to %s', PORT);
});
