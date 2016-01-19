@extends('app')
@section('content')
@if( $user['AUTHORIZE'] =='0' && $user['USER_TYPE'] != '1')
	<div class="row">
		<div class="jumbotron">
			<h2>สวัสดี, {{$user['FIRST_NAME']}} {{$user['LAST_NAME']}}</h2>
			@if( $user['ID_UNIVERSITY'] == '-1' || $user['ID_FACULTY'] == '-1')
		  	<p>แอพพลิเคชั่นนี้เป็นแอพพลิเคชั่นเฉพาะกลุ่มเพื่อสถาบันการศึกษาใช้ประโยชน์ในการแนะแนว
			      และพัฒนานักศึกษา เพราะฉะนั้น จำเป็นต้องรอการยืนยันตัวตนจากแอดมินของสถาบันของท่าน</p>
		  	<p><a class="btn btn-primary btn-lg" href="setupUniversity" role="button">คลิกเพื่อเลือกมหาวิทยาลัย</a></p>
			@else
				@if(Session::has('messageNotification'))
					<p>{{ Session::get('messageNotification') }}</p>
				@else
					<p>แอพพลิเคชั่นนี้เป็นแอพพลิเคชั่นเฉพาะกลุ่มเพื่อสถาบันการศึกษา ใช้ประโยชน์ในการแนะแนว และพัฒนานักศึกษา
						เพราะฉะนั้น จำเป็นต้องรอการยืนยันตัวตนจากแอดมินของสถาบันของท่านแอดมินของท่านคือ<br>
						{{--Print AuthorisedUser List--}}
						@if(isset($memberAuthorizedList))
							@if(count($memberAuthorizedList)>0)
								@foreach($memberAuthorizedList as $index=> $data)
									<ol>
										<li> คุณ  {{$data["FIRST_NAME"]}} {{$data["LAST_NAME"]}} <br></li>
									</ol>
								@endforeach
								@else
								ไม่พบ Admin
							@endif
						@endif
						<br>หากเกิน 2 วันทำการแล้วท่านยังไม่ได้รับการยืนยัน
					</p>
					<p><a class="btn btn-primary btn-lg" href="sendNotification" role="button" name="confirm_send"
						  onclick="return confirm('ต้องการที่จะสงคำร้องขอไปหาแอดมินของท่าน?')">คลิกที่นี่</a></p>
				@endif
			@endif
		</div>
	</div>
@elseif( $user['AUTHORIZE'] =='3' )
	<div class="row">
		<div class="jumbotron" style="margin-bottom:15px">
			<h2>สวัสดี, {{$user['FIRST_NAME']}} {{$user['LAST_NAME']}}</h2>
		  	<p>การอนุมัติเข้าร่วมกลุ่มของคุณมีความขัดข้อง กรุณาติดต่อแอดมินของสถาบันของท่าน แอดมินของท่าน</p>
		</div>
	</div>
	<div class="panel-group">
	  <div class="panel panel-default">
	  	@if(isset($memberAuthorizedList))
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#memberAuthorizedList">
					<h4 class="panel-title">
			        	<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			        	Groups
						<span class="label label-default label-badge-authorized">{{ count($memberAuthorizedList) }}</span></h4>
			        </h4>
				</a>
			</div>
			<div id="memberAuthorizedList" class="panel-collapse collapse in">
			  <ul class="list-group">
			  	@if(count($memberAuthorizedList)>0)
					@foreach ($memberAuthorizedList as $memberAuthorized)
						<a class="list-group-item">
							<h4 class="list-group-item-heading">
								{{ $memberAuthorized['FIRST_NAME'] }} {{ $memberAuthorized['LAST_NAME'] }}
							</h4>
							<p class="list-group-item-text">{{ $memberAuthorized['POSITION'] }}</p>
						</a>
					@endforeach
				@else
					<a class="list-group-item text-center"><h3>ไม่พบข้อมูล</h3></a>
				@endif
			  </ul>
			</div>
		@endif
		</div>
	</div>
@else
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#userChatListDiv">
					<h4 class="panel-title">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					Friend
					</h4>
				</a>
			</div>
			<div id="userChatListDiv" class="panel-collapse collapse in">
				<div class="list-group">
					@if(count($userChatList)>0)
						@foreach ($userChatList as $userChat)
							@if($userChat['IS_ADMIN']==3)
								<a href="chatWith/{{($userChat['USER1'][0]['ID_USER']==$user['ID_USER']?$userChat['USER2'][0]['ID_USER']:$userChat['USER1'][0]['ID_USER'])}}" class="list-group-item">
									<div class="row">
										<div class="col-xs-1">
											<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{($userChat['USER1'][0]['ID_USER']==$user['ID_USER']?$userChat['USER2'][0]['ID_USER']:$userChat['USER1'][0]['ID_USER'])}}.jpg" onerror='this.src="img/avatar.png"'>
										</div>
										<div class="col-xs-9">
											<h4 class="list-group-item-heading">
											{{($userChat['USER1'][0]['ID_USER']==$user['ID_USER']?$userChat['USER2'][0]['FIRST_NAME']:$userChat['USER1'][0]['FIRST_NAME'])}} {{($userChat['USER1'][0]['ID_USER']==$user['ID_USER']?$userChat['USER2'][0]['LAST_NAME']:$userChat['USER1'][0]['LAST_NAME'])}}
											</h4>
											<p class="list-group-item-text">{{($userChat['USER1'][0]['ID_USER']==$user['ID_USER']?$userChat['USER2'][0]['POSITION']:$userChat['USER1'][0]['POSITION'])}}</p>
										</div>
										<div class="col-xs-2">
											<span class="label label-default label-badge">{{$userChat['BADGE']}}</span>
										</div>
									</div>
								</a>
							@else
								<a href="chat/{{$userChat['ID_GROUP']}}" class="list-group-item">
									<h4 class="list-group-item-heading">
									@if($userChat['IS_ADMIN']==1 && $user['USER_TYPE'] != '1')
										บริษัท ท็อปกัน จำกัด
									@else
										{{$userChat['UNIVERSITY'][0]['NAME_THA']}}
									@endif
									<span class="label label-default label-badge">
										{{$userChat['BADGE']}}
									</span>
									</h4>
									<p class="list-group-item-text">
										@if($userChat['IS_ADMIN']==1)
											Top Gun Co.,Ltd.
										@else
											{{$userChat['FACULTY'][0]['NAME_THA']}}
										@endif
									</p>
								</a>
							@endif
						@endforeach
					@else
						<a class="list-group-item text-center"><h3>ไม่พบข้อมูล</h3></a>
					@endif
				</div>
			</div>
		</div>
	</div>

	<div id="dialog" title="Confirmation Required">
		ต้องการยืนยันใช้หรือไม่
	</div>
@endif
@endsection
@section('scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			$("#dialog").dialog({
				autoOpen: false,
				modal: true
			});
			$(".confirmLink").click(function(e) {
				e.preventDefault();
				var targetUrl = $(this).attr("href");
				$("#dialog").dialog({
					buttons : {
						"Confirm" : function() {
							window.location.href = targetUrl;
						},
						"Cancel" : function() {
							$(this).dialog("close");
						}
					}
				});
				$("#dialog").dialog("open");
			});
		}); // end of $(document).ready
	</script>
@endsection