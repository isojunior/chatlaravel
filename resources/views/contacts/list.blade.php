@extends('app')
@section('content')
	@if($user['USER_TYPE'] == 1)
		<div class="panel-group">
		  <div class="panel panel-default">
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
								    	<p class="list-group-item-text">{{ $company }}</p>
							    	</div>
						    	</div>
						    </a>
						@endif
				@endforeach
			  </ul>
			</div>
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
					<a data-toggle="collapse" href="#collapse1">Collapsible panel</a>
				  </h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse">
				  <div class="panel-body">Panel Body</div>
				  <div class="panel-footer">Panel Footer</div>
				</div>
			  </div>
			</div>
		</div>
	@else
	This is example content for user.
	@endif
@endsection
@section('scripts')
	<script>
		// initial js function
	$(document).ready(function(){
		var memberAuthorization = {};
		memberAuthorization.init
			= function(){
				var groupList = $("#groupList .link");
				var adminList = $("#adminList .link");
				var modal = $("#modal-data");
				memberAuthorization.handler(groupList, adminList, modal);
			};
			
		// error /*	
		/*	memberAuthorization.test
			= function(result){
				$.each(result, function(i, item){
					modal.html(item);
				});​
			};
			
			*/
		
		memberAuthorization.putData
			= function(container, result) {
				var container = $(".modal-body");
				var div = $("div.memberContainer");
					container.append(div);
					div.show();
					 
					for (var key in result)
					{
					    var i;
					   if (result.hasOwnProperty(key))
					   {
						  // here you have access to
						  alert(result[key][i]["ID_USER"]);
					   }
					   i++;
					}
					
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
						//dataType: 'json',
						dataType: 'html',
						success: function(result){
							modal.html(result);
							//modal.html(result[1][0]["ID_USER"]);
							//memberAuthorization.test(result);
							//memberAuthorization.putData(modal, result);
						},
						error: function(){
							alert("Error");
							return false;
						}
					});
				});
			};
		memberAuthorization.init();
	});
	</script>
@endsection