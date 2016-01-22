@extends('app')
@section('content')
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
									<img class="img-responsive img-circle avatar imgUsr chatimageProfile" src="http://apps.jobtopgun.com/Mercury/photos/{{isset($message['USER'][0])?$message['USER'][0]['ID_USER']:-1}}.jpg" onerror='this.src="img/avatar.png"'>
								</span>
								<div class="chat-body {{$message['ID_USER']==$user['ID_USER']?'pull-right text-right':'pull-left text-left'}}">
									<div class="messageHeader">
										<strong class="primary-font">{{isset($message['USER'][0])?$message['USER'][0]['FIRST_NAME']:""}}</strong>
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
			<form id="sendMessage">
			<div class="input-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="idUser" value="{{$user['ID_USER']}}"/>
				<input type="hidden" id="userFirstName" value="{{$user['FIRST_NAME']}}"/>
				<input type="hidden" id="idGroup" name="idGroup" value="{{$chat['ID_GROUP']}}"/>
				<input id="message-input" name="message" type="text" class="form-control input-sm" placeholder="Type your message here..." autocomplete="off" />
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

		var messageForm = $('#sendMessage');
        var messageBox = $('#message-input');
        var chat = $('ul.chat');
        var idUser = $('#idUser').val();
        var userFirstName = $('#userFirstName').val();
        var idGroup =$('#idGroup').val();

        // open a socket connection
        var socket = new io.connect('http://apps.jobtopgun.com:8890/', {
            'reconnection': true,
            'reconnectionDelay': 1000,
            'reconnectionDelayMax' : 5000,
            'reconnectionAttempts': 5
        });

        messageForm.on('submit', function (e) {
            e.preventDefault();
            if($.trim(messageBox.val())){
            	$.ajax({
            		type: "POST",
					url: "chat/sendMessage",
					data: $("#sendMessage").serialize(),
					beforeSend: function(){
						var messageContainer =
		            		'<li class="right clearfix loadingMessage">'+
							'<span class="chat-img pull-right">'+
							'	<img class="img-responsive img-circle avatar imgUsr chatimageProfile" src="http://apps.jobtopgun.com/Mercury/photos/'+idUser+'.jpg" onerror="this.src=\'img/avatar.png\'">'+
							'</span>'+
							'<div class="chat-body pull-right text-right">'+
							'	<div class="messageHeader">'+
							'		<strong class="primary-font">'+userFirstName+'</strong>'+
							'	</div>'+
							'	<div class="talk-bubble tri-right round right-in">'+
							'		<div class="talktext"><img src="img/loading.gif" class="img-responsive center-block"/></div>'+
							'	</div>'+
							'</div>'+
							'</li>';
						chat.append(messageContainer);
						$(".chat-panel-body").animate({ scrollTop: $(".chat-panel-body").prop("scrollHeight") });
					},
					success: function(result){
						$('.loadingMessage').remove();
						if(result){
							socket.emit('chat.send.message',
		            		{
		            			messageText: messageBox.val(),
		            			idUser:idUser,
		            			userName:userFirstName,
		            			channel:idGroup,
		            			time:result[0].TIMESTRING
		            		});
		            		messageBox.val('');
						}
						else{
							alert("การส่งข้อความเกิดความขัดข้อง");
						}
			    	}
				});
            }
            else{
            	messageBox.val("");
            }
        });

        // wait for a new message and append into each connection chat window
        socket.on('chat.message', function (data) {
            message = JSON.parse(data);
            if(message.channel==idGroup){
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
				$(".chat-panel-body").animate({ scrollTop: $(".chat-panel-body").prop("scrollHeight") });
            }
        });
	});
</script>
@endsection