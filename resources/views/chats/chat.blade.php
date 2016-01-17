@extends('app')
@section('content')
<input type="hidden" id="idUser" value="{{$user['ID_USER']}}"/>
<input type="hidden" id="userFirstName" value="{{$user['FIRST_NAME']}}"/>
<input type="hidden" id="idGroup" value="{{$chat['ID_GROUP']}}"/>
<div class="row">
	<div class="panel panel-primary">
		<div class="panel-heading text-center">
			@if(isset($userWith))
				<h4 class="removeMargin">
					<span class="glyphicon glyphicon-user"></span> {{$userWith[0]['FIRST_NAME']}} {{$userWith[0]['LAST_NAME']}}
				</h4>
				<p  class="removeMargin">{{$userWith[0]["POSITION"]}}</p>
			@else
				<h4 class="removeMargin">
					<span class="glyphicon glyphicon-education"></span> {{$chat['UNIVERSITY'][0]['NAME_THA']}}
				</h4>
				<p  class="removeMargin">{{$chat['FACULTY'][0]['NAME_THA']}}</p>
			@endif
		</div>
		<div class="chat-panel-body">
			<ul class="chat">
				@if(isset($messages))
					@if(count($messages))
						@foreach ($messages as $message)
							<li class="{{$message['ID_USER']==$user['ID_USER']?'right':'left'}} clearfix">
								<span class="chat-img {{$message['ID_USER']==$user['ID_USER']?'pull-right':'pull-left'}}">
									<img class="img-responsive img-circle avatar imgUsr chatimageProfile" src="http://apps.jobtopgun.com/Mercury/photos/{{$message['USER'][0]['ID_USER']}}.jpg" onerror='this.src="img/avatar.png"'>
								</span>
								<div class="chat-body {{$message['ID_USER']==$user['ID_USER']?'pull-right text-right':'pull-left text-left'}}">
									<div class="messageHeader">
										<strong class="primary-font">{{$message['USER'][0]['FIRST_NAME']}}</strong>
									</div>
									<div class="talk-bubble tri-right round {{$message['ID_USER']==$user['ID_USER']?'right-in':'left-in'}}">
										<div class="talktext">
										{{ \App\Http\Utils::unicode_decode($message['MESSAGE']) }}
										</div>
									</div>
									<div class="message-time">
										<span class="glyphicon glyphicon-time"></span>{{$message['TIMESTRING']}}
									</div>
								</div>
							</li>
						@endforeach
					@endif
				@endif
			</ul>
		</div>
		<div class="panel-footer">
			<form id="send-message">
			<div class="input-group">

					<input id="message-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
					<span class="input-group-btn">
						<button class="btn btn-warning btn-sm">Send</button>
					</span>

			</div>
			</form>
		</div>
</div>
</div>
@endsection
@section('scripts')
<link rel="stylesheet" type="text/css" href="{{ asset("css/chat.css") }}"/>
<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
<script>
	var date = new Date();
	$(document).ready(function(){
		$(".chat-panel-body").prop({ scrollTop: $(".chat-panel-body").prop("scrollHeight") });

		var messageForm = $('#send-message');
        var messageBox = $('#message-input');
        var chat = $('ul.chat');
        var idUser = $('#idUser').val();
        var userFirstName = $('#userFirstName').val();
        var idGroup =$('#idGroup').val();

        // open a socket connection
        var socket = new io.connect('http://localhost:8890', {
            'reconnection': true,
            'reconnectionDelay': 1000,
            'reconnectionDelayMax' : 5000,
            'reconnectionAttempts': 5
        });

        messageForm.on('submit', function (e) {
            e.preventDefault();
            if(messageBox.val()){
            	socket.emit('chat.send.message',
            		{
            			messageText: messageBox.val(),
            			idUser:idUser,
            			userName:userFirstName,
            			channel:idGroup,
            			time:date.today()+" "+date.timeNow()
            		});
            	messageBox.val('');
            }
        });

        // wait for a new message and append into each connection chat window
        socket.on('chat.message', function (data) {
            message = JSON.parse(data);
            console.log(message);
            if(message.channel==idGroup){
            	console.log("inSide");
            	var messageContainer =
            		'<li class="'+(message.idUser==idUser?'right':'left')+' clearfix">'+
					'<span class="chat-img '+(message.idUser==idUser?'pull-right':'pull-left')+'">'+
					'	<img class="img-responsive img-circle avatar imgUsr chatimageProfile" src="http://apps.jobtopgun.com/Mercury/photos/'+message.idUser+'.jpg" onerror="this.src=\'img/avatar.png\'">'+
					'</span>'+
					'<div class="chat-body '+(message.idUser==idUser?'pull-right text-right':'pull-left text-left')+'">'+
					'	<div class="messageHeader">'+
					'		<strong class="primary-font">'+message.userName+'</strong>'+
					'	</div>'+
					'	<div class="talk-bubble tri-right round '+(message.idUser==idUser?'right-in':'left-in')+'">'+
					'		<div class="talktext">'+message.messageText+'</div>'+
					'	</div>'+
					'	<div class="message-time">'+
					'		<span class="glyphicon glyphicon-time"></span>'+message.time
					'	</div>'+
					'</div>'+
					'</li>';

				chat.append(messageContainer);
            }
        });
	});
</script>
@endsection