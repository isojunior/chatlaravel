@extends('app')
@section('content')
@if( $user['AUTHORIZE'] =='0' && $user['USER_TYPE'] != '1')
	<div class="row">
		<div class="jumbotron">
			<h2>สวัสดี, {{$user['FIRST_NAME']}} {{$user['LAST_NAME']}}</h2>
		  	<p>แอพพลิเคชั่นนี้เป็นแอพพลิเคชั่นเฉพาะกลุ่มเพื่อสถาบันการศึกษาใช้ประโยชน์ในการแนะแนว
และพัฒนานักศึกษา เพราะฉะนั้น จำเป็นต้องรอการยืนยันตัวตนจากแอดมินของสถาบันของท่าน</p>
		  	<p><a class="btn btn-primary btn-lg" href="setupUniversity" role="button">คลิกเพื่อเลือกมหาวิทยาลัย</a></p>
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
							<a href="#" class="list-group-item link">			<!-- Change href -->
						    	<div class="row">
							    	<div class="col-xs-1">
							    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $admin['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
							    	</div>
							    	<div class="col-xs-9">
							    		<h4 class="list-group-item-heading">
								    		{{ $admin['FIRST_NAME'] }} {{ $admin['LAST_NAME'] }}
								    	</h4>
								    	<p class="list-group-item-text">Top Gun Co.,Ltd.</p>
							    	</div>
						    	</div>
						    </a>
						@endif
				@endforeach
			  </ul>
			</div>
			@endif
		  </div>
		</div>

		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
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
				<div class="jumbotron">
					<h2>สวัสดี, {{$user['FIRST_NAME']}} {{$user['LAST_NAME']}}</h2>
				  	<p>การอนุมัติเข้าร่วมกลุ่มของคุณมีความขัดข้อง กรุณาติดต่อแอดมินของสถาบันของท่าน แอดมินข
องท่าน</p>
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
					        </h4>
						</a>
					</div>
					<div id="memberAuthorizedList" class="panel-collapse collapse">
					  <ul class="list-group">
					  	@if(count($unAuthorizeList)>0)
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
					        </h4>
						</a>
					</div>
					<div id="unAuthorizeList" class="panel-collapse collapse">
					  <ul class="list-group">
					  	@if(count($unAuthorizeList)>0)
							@foreach ($unAuthorizeList as $unAuthorize)
								<a href="#" class="list-group-item link"><!-- Change href -->
							    	<div class="row">
								    	<div class="col-xs-1">
								    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $unAuthorize['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
								    	</div>
								    	<div class="col-xs-9">
								    		<h4 class="list-group-item-heading">
									    		{{ $unAuthorize['FIRST_NAME'] }} {{ $unAuthorize['LAST_NAME'] }}
									    	</h4>
									    	<p class="list-group-item-text">{{ $unAuthorize['POSITION'] }}</p>
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
				@if(isset($adminList))
					<div class="panel-heading">
						<a class="collapseLink" data-toggle="collapse" href="#adminList">
							<h4 class="panel-title">
					        	<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
					        	Administrators
					        </h4>
						</a>
					</div>
					<div id="adminList" class="panel-collapse collapse">
					  <ul class="list-group">
						@foreach ($adminList as $admin)
							<a href="#" class="list-group-item link"><!-- Change href -->
						    	<div class="row">
							    	<div class="col-xs-1">
							    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $admin['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
							    	</div>
							    	<div class="col-xs-9">
							    		<h4 class="list-group-item-heading">
								    		{{ $admin['FIRST_NAME'] }} {{ $admin['LAST_NAME'] }}
								    	</h4>
								    	<p class="list-group-item-text">Top Gun Co.,Ltd.</p>
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
					        </h4>
						</a>
					</div>
					<div id="memberList" class="panel-collapse collapse">
					  <ul class="list-group">
					  	@if(count($memberList)>0)
							@foreach ($memberList as $member)
								<a href="#" class="list-group-item link"><!-- Change href -->
							    	<div class="row">
								    	<div class="col-xs-1">
								    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $member['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
								    	</div>
								    	<div class="col-xs-9">
								    		<h4 class="list-group-item-heading">
									    		{{ $member['FIRST_NAME'] }} {{ $member['LAST_NAME'] }}
									    	</h4>
									    	<p class="list-group-item-text">{{ $member['POSITION'] }}</p>
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
					        </h4>
						</a>
					</div>
					<div id="rejectList" class="panel-collapse collapse">
					  <ul class="list-group">
					  	@if(count($rejectList)>0)
							@foreach ($rejectList as $reject)
								<a href="#" class="list-group-item link"><!-- Change href -->
							    	<div class="row">
								    	<div class="col-xs-1">
								    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $reject['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
								    	</div>
								    	<div class="col-xs-9">
								    		<h4 class="list-group-item-heading">
									    		{{ $reject['FIRST_NAME'] }} {{ $reject['LAST_NAME'] }}
									    	</h4>
									    	<p class="list-group-item-text">{{ $reject['POSITION'] }}</p>
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
@endsection
@section('scripts')
<script>
	$(document).ready(function(){
		var memberAuthorization = {};
		memberAuthorization.init
			= function(){
				var groupList = $("#groupList .link");
				var adminList = $("#adminList .link");
				var modal = $("#modal-data");
				memberAuthorization.handler(groupList, adminList, modal);
			};

		memberAuthorization.handler
			= function(groupList, adminList, modal){
				groupList.click(function(e){
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
					        //modal.slideUp(300);
					        modal.html("<img src='img/preload_horizontal.gif' class='img-responsive center-block'/>");
					    },
						success: function(result){
							modal.html(result);
							modal.slideDown(300);
						},
						error: function(){
							return false;
						}
					});
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