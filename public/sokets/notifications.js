var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
redis.subscribe('notifications', function(err, count) {});
redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log(message);
    io.emit('notifications', message.type, message.site_id, message.count);
});
http.listen(3002, function(){
    console.log('Listening on Port 3002');
});