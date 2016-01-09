@extends('app')
@section('content')
	@if($user['USER_TYPE'] =='0')
	    @if( $user['AUTHORIZE'] =='1')
	        APPROVE
	    @else
	        This Application only specified for eduction with advice and useful for students <br>
	        therefore wait admin institution's approved
	    @endif
    @else
    	<div class="panel-group">
	    	<div class="panel panel-default">
		    	<div class="panel-heading">
		          	<a class="collapseLink" data-toggle="collapse" href="#groupChatListDiv">
			        <h4 class="panel-title">
			        	<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			        	Groups
			        </h4>
					</a>
			    </div>
		    	<div id="groupChatListDiv" class="panel-collapse collapse">
			    	<div class="list-group">
			    		@foreach ($groupChatList as $groupChat)
						    <a href="chat/{{$groupChat['ID_GROUP']}}" class="list-group-item">
						    	<h4 class="list-group-item-heading">
						    		{{$groupChat['UNIVERSITY'][0]["NAME_THA"]}}
						    		<span class="label label-default label-badge">{{$groupChat['BADGE']}}</span>
						    	</h4>
						    	<p class="list-group-item-text">{{$groupChat['FACULTY'][0]["NAME_THA"]}}</p>
						    </a>
						@endforeach
					</div>
				</div>
				<div class="panel-heading">
		          	<a class="collapseLink" data-toggle="collapse" href="#userChatListDiv">
			        <h4 class="panel-title">
			        	<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
			        	Friend
			        </h4>
					</a>
			    </div>
				<div id="userChatListDiv" class="panel-collapse collapse">
			    	<div class="list-group">
			    		@foreach ($userChatList as $userChat)
						    <a href="chat/{{$userChat['ID_GROUP']}}" class="list-group-item">
						    	<div class="row">
							    	<div class="col-xs-1">
							    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{$userChat['USER2'][0]['ID_USER']}}.jpg" onerror='this.src="img/avatar.png"'>
							    	</div>
							    	<div class="col-xs-9">
							    		<h4 class="list-group-item-heading">
								    		{{$userChat['USER2'][0]['FIRST_NAME']}} {{$userChat['USER2'][0]['LAST_NAME']}}
								    	</h4>
								    	<p class="list-group-item-text">{{$userChat['USER2'][0]["POSITION"]}}</p>
							    	</div>
							    	<div class="col-xs-2">
							    		<span class="label label-default label-badge">{{$userChat['BADGE']}}</span>
							    	</div>
						    	</div>
						    </a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
    @endif
@endsection