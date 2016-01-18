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
		@if($user['USER_TYPE'] == 1)
			<div class="panel-group">
			  <div class="panel panel-default">
			  	@if(isset($groupList))
				<div class="panel-heading">
					<a class="collapseLink" data-toggle="collapse" href="#groupList">
						<h4 class="panel-title">
				        	<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
				        	Groups
				        </h4>
					</a>
				</div>
				<div id="groupList" class="panel-collapse collapse">
				  <ul class="list-group">
					@foreach ($groupList as $group)
						<a href="#" class="list-group-item link" data-toggle="modal" data-target="#myModal" data-group='["{{ $group['UNIVERSITY'][0]['ID_UNIVERSITY'] }}","{{ $group['FACULTY'][0]['ID_FACULTY'] }}"]'>
							<h4 class="list-group-item-heading universityName">
								{{ $group['UNIVERSITY'][0]['NAME_THA'] }}
							</h4>
							<p class="list-group-item-text facultyName">{{ $group['FACULTY'][0]['NAME_THA'] }}</p>
						</a>
					@endforeach
				  </ul>
				</div>
				@endif
				@if(isset($adminList))
				<div class="panel-heading">
					<a class="collapseLink" data-toggle="collapse" href="#adminList">
						<h4 class="panel-title">
				        	<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				        	Administrators
				        </h4>
					</a>
				</div>
				<div id="adminList" class="panel-collapse collapse">
				  <ul class="list-group">
					@foreach ($adminList as $admin)
							@if ($user['ID_USER'] != $admin['ID_USER'])
								<a href="#" class="list-group-item link" data-toggle="modal" data-target="#myModal" data-id="{{$admin['ID_USER']}}" data-telephone="{{$admin['TELEPHONE']}}" data-email="{{$admin['EMAIL']}}">
							    	<div class="row">
								    	<div class="col-xs-1">
								    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $admin['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
								    	</div>
								    	<div class="col-xs-9">
								    		<h4 class="list-group-item-heading fullname">
									    		{{ $admin['FIRST_NAME'] }} {{ $admin['LAST_NAME'] }}
									    	</h4>
									    	<p class="list-group-item-text company">Top Gun Co.,Ltd.</p>
								    	</div>
							    	</div>
							    </a>
							@endif
					@endforeach
				  </ul>
				</div>
				@endif
			  </div>
			</div
			<!-- Container inside modal -->
			<div class="memberContainer">
				<div class="panel-group">
				  <div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a data-toggle="collapse" href="#collapsePanel"></a>
					  </h4>
					</div>
					<div id="collapsePanel" class="panel-collapse collapse">
					  <div class="panel-body">Panel Body</div>
					  <div class="panel-footer">Panel Footer</div>
					</div>
				  </div>
				</div>
			</div>
		@else
			@if($user['AUTHORIZE']==3)
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
			  	@if(isset($unAuthorizeList))
					<div class="panel-heading">
						<a class="collapseLink" data-toggle="collapse" href="#unAuthorizeList">
							<h4 class="panel-title">
					        	<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
					        	คำร้องขอ
								<span class="label label-default label-badge-authorized">{{ count($unAuthorizeList) }}</span></h4>
					        </h4>
						</a>
					</div>
					<div id="unAuthorizeList" class="panel-collapse collapse">
					  <ul class="list-group">
					  	@if(count($unAuthorizeList)>0)
							@foreach ($unAuthorizeList as $unAuthorize)
								<a class="list-group-item link"
								        data-id="{{$unAuthorize['ID_USER']}}" data-telephone="{{$unAuthorize['TELEPHONE']}}" data-email="{{$unAuthorize['EMAIL']}}"
										data-university-th="{{ $unAuthorize['UNIVERSITY'][0]['NAME_THA'] }}" data-university-en="{{ $unAuthorize['UNIVERSITY'][0]['NAME_ENG'] }}"
									    data-faculty-th="{{ $unAuthorize['FACULTY'][0]['NAME_THA'] }}" data-faculty-en="{{ $unAuthorize['FACULTY'][0]['NAME_ENG'] }}">
							    	<div class="row">
								    	<div class="col-xs-1">
								    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $unAuthorize['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
								    	</div>
								    	<div class="col-xs-9">
								    		<h4 class="list-group-item-heading fullname">
									    		{{ $unAuthorize['FIRST_NAME'] }} {{ $unAuthorize['LAST_NAME'] }}
									    	</h4>
									    	<p class="list-group-item-text position">{{ $unAuthorize['POSITION'] }}</p>
									    	<button onclick="window.location = 'authorizedUser/2/{{$unAuthorize["ID_USER"]}}'" class="btn btn-info btn-sm group">เพิ่มเข้ากลุ่ม</button>
									    	<button onclick="window.location = 'authorizedUser/3/{{$unAuthorize["ID_USER"]}}'" class="btn btn-warning btn-sm reject">ปฏิเสธ</button>
							    		</div>
							    	</div>
							    </a>
							@endforeach
						@else
							<a class="list-group-item text-center"><h3>ไม่พบข้อมูล</h3></a>
						@endif
					  </ul>
					</div>
				@endif

				@if(isset($adminGroupChatList)||isset($primaryGroupChatList))
					<div class="panel-heading">
						<a class="collapseLink" data-toggle="collapse" href="#groupChatList">
							<h4 class="panel-title">
					        	<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
					        	Groups
								<span class="label label-default label-badge-authorized">{{ count($adminGroupChatList) + count($primaryGroupChatList) }}</span></h4>
					        </h4>
						</a>
					</div>
					<div id="groupChatList" class="panel-collapse collapse">
					  <ul class="list-group">
					  	@if(isset($adminGroupChatList))
							@foreach ($adminGroupChatList as $adminGroup)
								<a class="list-group-item adminGroupChat link" data-id="{{$adminGroup['ID_GROUP']}}">
									<h4 class="list-group-item-heading">
										บริษัท ท็อปกัน จำกัด
										<span class="label label-default label-badge">{{$adminGroup['TOTAL']}}</span>
									</h4>
									<p class="list-group-item-text">Top Gun Co.,Ltd.</p>
								</a>
							@endforeach
						@endIf
						@if(isset($primaryGroupChatList))
							@foreach ($primaryGroupChatList as $primaryGroup)
								<a class="list-group-item primaryGroupChat link" data-id="{{$primaryGroup['ID_GROUP']}}">
									<h4 class="list-group-item-heading">
										{{$primaryGroup['UNIVERSITY'][0]['NAME_THA']}}
										<span class="label label-default label-badge">{{$primaryGroup['TOTAL']}}</span>
									</h4>
									<p class="list-group-item-text">{{$primaryGroup['FACULTY'][0]['NAME_THA']}}</p>
								</a>
							@endforeach
						@endif
					  </ul>
					</div>
				@endif

				@if(isset($adminList))
					<div class="panel-heading">
						<a class="collapseLink" data-toggle="collapse" href="#adminList">
							<h4 class="panel-title">
					        	<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
					        	Administrators
								<span class="label label-default label-badge-authorized">{{ count($adminList) }}</span></h4>
					        </h4>
						</a>
					</div>
					<div id="adminList" class="panel-collapse collapse">
					  <ul class="list-group">
						@foreach ($adminList as $admin)
							<a href="#" class="list-group-item link" data-toggle="modal" data-target="#myModal" data-id="{{$admin['ID_USER']}}" data-telephone="{{$admin['TELEPHONE']}}" data-email="{{$admin['EMAIL']}}">
						    	<div class="row">
							    	<div class="col-xs-1">
							    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $admin['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
							    	</div>
							    	<div class="col-xs-9">
							    		<h4 class="list-group-item-heading fullname">
								    		{{ $admin['FIRST_NAME'] }} {{ $admin['LAST_NAME'] }}
								    	</h4>
								    	<p class="list-group-item-text position">Top Gun Co.,Ltd.</p>
							    	</div>
						    	</div>
						    </a>
						@endforeach
					  </ul>
					</div>
				@endif
				@if(isset($memberList))
					<div class="panel-heading">
						<a class="collapseLink" data-toggle="collapse" href="#memberList">
							<h4 class="panel-title">
					        	<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					        	Friend
								<span class="label label-default label-badge-authorized">{{ count($memberList) }}</span></h4>
					        </h4>
						</a>
					</div>
					<div id="memberList" class="panel-collapse collapse">
					  <ul class="list-group">
					  	@if(count($memberList)>0)
							@foreach ($memberList as $member)
								<a class="list-group-item link" data-toggle="modal" data-target="#myModal"
								        data-id="{{$member['ID_USER']}}" data-telephone="{{$member['TELEPHONE']}}" data-email="{{$member['EMAIL']}}"
										data-university-th="{{ $member['UNIVERSITY'][0]['NAME_THA'] }}" data-university-en="{{ $member['UNIVERSITY'][0]['NAME_ENG'] }}"
									    data-faculty-th="{{ $member['FACULTY'][0]['NAME_THA'] }}" data-faculty-en="{{ $member['FACULTY'][0]['NAME_ENG'] }}">
							    	<div class="row">
								    	<div class="col-xs-1">
								    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $member['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
								    	</div>
								    	<div class="col-xs-9">
								    		<h4 class="list-group-item-heading fullname">
									    		{{ $member['FIRST_NAME'] }} {{ $member['LAST_NAME'] }}
									    	</h4>
									    	<p class="list-group-item-text position">{{ $member['POSITION'] }}</p>
								    	</div>
							    	</div>
							    </a>
							@endforeach
						@else
							<a class="list-group-item text-center"><h3>ไม่พบข้อมูล</h3></a>
						@endif
					  </ul>
					</div>
				@endif
				@if(isset($rejectList))
					<div class="panel-heading">
						<a class="collapseLink" data-toggle="collapse" href="#rejectList">
							<h4 class="panel-title">
					        	<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
					        	ผู้ที่ถูกปฏิเสธเข้าร่วมกลุ่ม
								<span class="label label-default label-badge-authorized">{{ count($rejectList) }}</span></h4>
					        </h4>
						</a>
					</div>
					<div id="rejectList" class="panel-collapse collapse">
					  <ul class="list-group">
					  	@if(count($rejectList)>0)
							@foreach ($rejectList as $reject)
								<a href class="list-group-item link" data-toggle="modal" data-target="#myModal"
								        data-id="{{$reject['ID_USER']}}" data-telephone="{{$reject['TELEPHONE']}}" data-email="{{$reject['EMAIL']}}"
										data-university-th="{{ $reject['UNIVERSITY'][0]['NAME_THA'] }}" data-university-en="{{ $reject['UNIVERSITY'][0]['NAME_ENG'] }}"
									    data-faculty-th="{{ $reject['FACULTY'][0]['NAME_THA'] }}" data-faculty-en="{{ $reject['FACULTY'][0]['NAME_ENG'] }}">
							    	<div class="row">
								    	<div class="col-xs-1">
								    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $reject['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
								    	</div>
								    	<div class="col-xs-9">
								    		<h4 class="list-group-item-heading fullname">
									    		{{ $reject['FIRST_NAME'] }} {{ $reject['LAST_NAME'] }}
									    	</h4>
									    	<p class="list-group-item-text position">{{ $reject['POSITION'] }}</p>
								    	</div>
							    	</div>
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
		@endif
	@endif
@endif
<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header panel">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title universityName">
				</h4>
				<p class="list-group-item-text facultyName"></p>
			  </div>
			  <div class="modal-body">
				<p id="modal-data"></p>
			  </div>
			</div>
		  </div>
		</div>
@endsection
@section('scripts')
<script>
	$(document).ready(function(){
		var memberAuthorization = {};
		memberAuthorization.init
			= function(){
				var groupList = $("#groupList .link"); // Groups for admin role
				var groupChatList = $("#groupChatList .link");
				var adminList = $("#adminList .link"); // Administrator
				var otherList = $("#unAuthorizeList, #rejectList, #memberList").find(".link"); // Unauthorized, High User, Reject
				var modal = $("#modal-data");
				memberAuthorization.handler(groupList, groupChatList, adminList, otherList, modal);
			};

		memberAuthorization.handler
			= function(groupList, groupChatList, adminList, otherList, modal){
				groupList.click(function(){
					var data = $(this).data("group");
					var universityName = $(this).find(".universityName").text();
					var facultyName = $(this).find(".facultyName").text();
					$("#myModal .universityName").text(universityName);
					$("#myModal .facultyName").text(facultyName);

					$.ajax({
						url: "authorizedList",
						type: 'get',
						data: { 'data': data },
						dataType: 'html',
						beforeSend: function() {
					        modal.html("<img src='img/preload_horizontal.gif' class='img-responsive center-block'/>");
					    },
						success: function(result){
							modal.html(result);
							modal.slideDown(300);
							initGroupChatButton();
						},
						error: function(){
							return false;
						}
					});
				});

				adminList.click(function(){
					var idAdmin		= $(this).data("id"); 					// Get admin userid for 1-1 chat
					var fullName	= $(this).find(".fullname").text();
					var companyName = $(this).find(".company").text();
					var telephone	= $(this).data("telephone");
					var email 		= $(this).data("email");
					var imgSource 	= $(this).find('img').attr('src');

					var root		= $("#myModal #modal-data");
					var container	= '<div class="row"><img class="img-responsive img-circle avatar imgUsr imgAdmin"><div class="col-xs-9 text-center info"><h4 class="list-group-item-heading fullname"></h4><p class="list-group-item-heading company"></p><p class="list-group-item-heading email"></p><p class="list-group-item-heading telephone"></p><a class="btn btn-md btn-info">CHAT</a></div></div>';

					root.empty(); 											// To clear previously content
					root.append(container);

					root.find('.avatar').attr('src',imgSource);
					root.find('.fullname').text(fullName);
					root.find('.company').text(companyName);
					root.find('.email').text("Email. "+email);
					root.find('.telephone').text("Tel. "+telephone);
					root.find('a').attr('href','chatWith/'+idAdmin);
				});

				otherList.click(function(){
					var idUser			= $(this).data("id"); 					// Get admin userid for 1-1 chat
					var userRole		= $(this).parent().parent().attr('id'); // unAuthorizeList, memberList, rejectList
					var fullName		= $(this).find(".fullname").text();
					var position 		= $(this).find(".position").text();
					var telephone		= $(this).data("telephone");
					var email 			= $(this).data("email");
					var universityTh	= $(this).data("university-th");
					var facultyTh		= $(this).data("faculty-th");
					var imgSource 		= $(this).find('img').attr('src');

					var root		= $("#myModal #modal-data");
					var container	= '<div class="row"><img class="img-responsive img-circle avatar imgUsr imgAdmin"><div class="col-xs-9 text-center info"><h4 class="list-group-item-heading fullname"></h4><p class="list-group-item-heading position"></p><p class="list-group-item-heading email"></p><p class="list-group-item-heading telephone"></p><h4 class="list-group-item-heading">มหาวิทยาลัย</h4><p class="list-group-item-heading universityTh"></p><p class="list-group-item-heading universityEn"></p><h4 class="list-group-item-heading">คณะ</h4><p class="list-group-item-heading facultyTh"></p><p class="list-group-item-heading"></p><a class="btn btn-md btn-info">CHAT</a></div></div>';

					root.empty(); 											// To clear previously content
					root.append(container);
					$(".universityTh, .universityEn, .facultyTh").addClass('blue');

					root.find('.avatar').attr('src',imgSource);
					root.find('.fullname').text(fullName);
					root.find('.position').text(position);
					root.find('.email').text("Email "+email);
					root.find('.telephone').text("Tel. "+telephone);
					root.find('.universityTh').text(universityTh);
					root.find('.facultyTh').text(facultyTh);
					root.find('a').attr('href','chatWith/'+idUser);
				});

			};

		memberAuthorization.init();
	});

	function addToAuthorized(idUser){
		if(confirm("กดตกลงเพื่อยืนยันการเปลี่ยนสถานะ")){
			var url ="authorizedUser/1/"+idUser;
			callAjaxAuthorized(url);
		}
	}

	function addToGroup(idUser){
		if(confirm("กดตกลงเพื่อยืนยันการเปลี่ยนสถานะ")){
			var url ="authorizedUser/2/"+idUser;
			callAjaxAuthorized(url);
		}
	}

	function cancelAuthorized(idUser){
		if(confirm("กดตกลงเพื่อยืนยันการเปลี่ยนสถานะ")){
			var url ="authorizedUser/0/"+idUser;
			callAjaxAuthorized(url);
		}
	}

	function reject(idUser){
		if(confirm("กดตกลงเพื่อยืนยันการปฏิเสธ")){
			var url ="authorizedUser/3/"+idUser;
			callAjaxAuthorized(url);
		}
	}

	function initGroupChatButton() {
		$(".chat-group").click(function() {
		});
	}

	function callAjaxAuthorized(url){
		$.ajax({
			url: url,
			type: 'get',
			dataType: 'html',
			beforeSend: function() {
		        $("#modal-data").html("<img src='img/preload_horizontal.gif' class='img-responsive center-block'/>");
		    },
			success: function(result){
				$("#modal-data").html(result);
				$("#modal-data").slideDown(300);
			},
			error: function(){
				return false;
			}
		});
	}
</script>
@endsection