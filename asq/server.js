var socket = require('socket.io');
var express = require('express');
var https = require('https');
var http = require('http');
var logger = require('winston');

logger.remove(logger.transports.Console);
logger.add(logger.transports.Console, { colorize: true, timestamp: true});
logger.info('SocketIO > listening on port');


var app = express();
var http_server = http.createServer(app).listen(8081);

function emitNewOrder(server) {
	var io = socket.listen(server);

	io.sockets.on('connection', function(socket) {

		socket.on('message', function(data) {
			io.emit("message", data);
		});

	});
}

emitNewOrder(http_server);