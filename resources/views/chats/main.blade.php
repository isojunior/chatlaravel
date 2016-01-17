@extends('app')
@section('content')
@if( $user['AUTHORIZE'] =='0' && $user['USER_TYPE'] != '1')
	<div class="row">
		<div class="jumbotron">
			<h2>สวัสดี, {{$user['FIRST_NAME']}} {{$user['LAST_NAME']}} {{$user['ID_UNIVERSITY']}} {{$user['ID_FACULTY']}}</h2>
			@if( $user['ID_UNIVERSITY'] == '-1' || $user['ID_FACULTY'] == '-1')
		  	<p>แอพพลิเคชั่นนี้เป็นแอพพลิเคชั่นเฉพาะกลุ่มเพื่อสถาบันการศึกษาใช้ประโยชน์ในการแนะแนว
			      และพัฒนานักศึกษา เพราะฉะนั้น จำเป็นต้องรอการยืนยันตัวตนจากแอดมินของสถาบันของท่าน</p>
		  	<p><a class="btn btn-primary btn-lg" href="setupUniversity" role="button">คลิกเพื่อเลือกมหาวิทยาลัย</a></p>
			@else
			<p>แอพพลิเคชั่นนี้เป็นแอพพลิเคชั่นเฉพาะกลุ่มเพื่อสถาบันการศึกษา ใช้ประโยชน์ในการแนะแนว และพัฒนานักศึกษา 
			      เพราะฉะนั้น จำเป็นต้องรอการยืนยันตัวตนจากแอดมินของสถาบันของท่านแอดมินของท่านคือ<br>
			   Print AuthorisedUser List   	
		       <br>หากเกิน 2 วันทำการแล้วท่านยังไม่ได้รับการยืนยัน
		    </p>
		  	<p><a class="btn btn-primary btn-lg" href="setupUniversity" role="button">คลิกที่นี่</a></p>
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
								<a href="chatWith/{{$userChat['USER2'][0]['ID_USER']}}" class="list-group-item">
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
							@else
								<a href="chat/{{$userChat['ID_GROUP']}}" class="list-group-item">
									<h4 class="list-group-item-heading">
									{{$userChat['UNIVERSITY'][0]['NAME_THA']}}
									<span class="label label-default label-badge">{{$userChat['BADGE']}}</span>
									</h4>
									<p class="list-group-item-text">{{$userChat['FACULTY'][0]['NAME_THA']}}</p>
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
@endif
@endsection