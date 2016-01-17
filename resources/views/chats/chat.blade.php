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
			<div class="input-group">
				<input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here...">
				<span class="input-group-btn">
					<button class="btn btn-warning btn-sm" id="btn-chat">Send</button>
				</span>
			</div>
		</div>
</div>
</div>
@endsection
@section('scripts')
<link rel="stylesheet" type="text/css" href="{{ asset("css/chat.css") }}"/>
@endsection