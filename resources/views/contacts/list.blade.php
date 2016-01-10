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
				@foreach ($groupList as $index)
					@foreach ($index as $group)
						<a href="#" class="list-group-item">		<!-- Change href -->
							<h4 class="list-group-item-heading">
								{{ $group['UNIVERSITY'][0]['NAME_THA'] }}
							</h4>
							<p class="list-group-item-text">{{ $group['FACULTY'][0]['NAME_THA'] }}</p>
						</a>
					@endforeach
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
				@foreach ($adminList as $index)
					@foreach ($index as $admin)
						@if ($user['ID_USER'] != $admin['ID_USER'])
							<a href="#" class="list-group-item">			<!-- Change href -->
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
				@endforeach
			  </ul>
			</div>
		  </div>
		</div>
	@endif
@endsection