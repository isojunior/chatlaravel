@extends('app')
@section('content')
<br><br><br>
	@if($user['USER_TYPE'] == 1)
		<div class="panel-group">
		  <div class="panel panel-default">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#groupList">
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
									<h4 class="list-group-item-heading">
										{{ $group['UNIVERSITY'][0]['NAME_THA'] }}
									</h4>
									<p class="list-group-item-text">{{ $group['FACULTY'][0]['NAME_THA'] }}</p>
								</a>
				@endforeach
			  </ul>
			</div>
			<div class="panel-heading">
				<a data-toggle="collapse" href="#adminList">
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
				<h4 class="modal-title">{{ $group['UNIVERSITY'][0]['NAME_THA'] }}
				</h4>
				<p class="list-group-item-text">{{ $group['FACULTY'][0]['NAME_THA'] }}</p>
			  </div>
			  <div class="modal-body">
				<p id="modal-data"></p>
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
		var memberAuthorization = {};
		memberAuthorization.init
			= function(){
				var groupList = $("#groupList .link");
				var adminList = $("#adminList .link");
				var modal = $("#modal-data");
				var data = groupList.data("group");
				//var data = JSON.parse(groupList.data("group"));
				memberAuthorization.handler(groupList, adminList, modal, data);
			};
		
		memberAuthorization.handler
			= function(groupList, adminList, modal, data){	
				groupList.click(function(){
					$.ajax({
						url: "authorizedList",
						type: 'get',
						data: { 'data': data },
						dataType: 'html',
						success: function(result){
							modal.html(result);
						},
						error: function(){
							alert("Error");
							return false;
						}
					});
				});
			};
			
		memberAuthorization.init();
	</script>
@endsection