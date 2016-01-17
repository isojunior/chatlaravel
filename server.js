/**
 * Created by iso on 13/01/2016.
 */
var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();


var port =8890,users=nicknames= {};
//
server.listen(port,function(){
    console.log('Listening on *:' +port);
});


//server.listen(8890);
console.log('Express server started on port %s', server.address().port);
io.on('connection', function (socket) {

    console.log("new client connected");
    var redisClient = Redis.createClient();

    socket.on('join',function(user){
        console.info('New client connected (id=' + user.id + ' (' + user.name + ') => socket=' + socket.id + ').');
        socket.userId   = user.id;
        socket.nickname = user.name;

        users[user.id] = socket;

        nicknames[user.id] = {
            'nickname': user.name,
            'socketId': socket.id,
        };
    });

    socket.on('subscribe',function(msg)
    {
        console.log("Subscription request:"+msg.channel);
       // redis.punsubscribe("*");
        //redis.subscribe(msg.channel);
    });

    function updateNicknames() {
        // send connected users to all sockets to display in nickname list
        io.sockets.emit('chat.users', nicknames);
    }

    updateNicknames();


    redis.subscribe(['chat.message', 'chat.private'], function (err, count) {

    });

    socket.on('chat.send.message', function (message) {
        console.log('Receive message ' + message.msg + ' from user in channel chat.message');
        //console.log("MEssage:"+io.sockets);
        io.sockets.emit('chat.message', JSON.stringify(message));
    });


    redisClient.subscribe('message');

    redisClient.on("message", function(channel, message) {
        console.log("mew message in queue "+ message + "channel");
        socket.emit(channel, message);
    });

    socket.on('disconnect', function() {
        redisClient.quit();
    });

});