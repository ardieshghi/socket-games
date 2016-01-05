<?php

function createSocketClient($host = 'localhost', $port = 80, Closure $callback, $timeout = 30) {

	try {

		$fp = stream_socket_client(sprintf("tcp://%s:%d", $host, $port), $errno, $errstr, $timeout);

		if (!$fp) {
			throw new Exception("$errstr ($errno)");
		}

		$callback(null, function($message, Closure $callback) use ($fp) {

			fwrite($fp, $message);
			$reply = '';

			while (!feof($fp)) {
        		$reply .= fgets($fp, 1024);
    		}

    		fclose($fp);

    		$callback($reply);
		});

	} catch(Exception $error) {

		return $callback($error);

	}
}

// Create a socket client
createSocketClient('localhost', 1337, function($err, Closure $sendMessage){

	if ($err) {
		print $err->getMessage();
		return;
	}

	$sendMessage('Cool TCP connection!', function($reply) {
		print 'Socket server reply: ' . $reply;
	});

});
