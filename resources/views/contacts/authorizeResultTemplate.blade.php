	<div class="panel-group">
		  <div class="panel panel-default">
			@if(isset($highUser))
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#highUser">
					<h4 class="panel-title">High User</h4>
					<span class="label label-default label-badge">{{ count($highUser) }}</span>
				</a>
			</div>
			<div id="highUser" class="panel-collapse collapse">
			  <ul class="list-group">
				@foreach ($highUser as $hiUser)
							<a href="#" class="list-group-item link .clearfix">
						    	<div class="row">
							    	<div class="col-xs-2">
							    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $hiUser['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
							    	</div>
							    	<div class="col-xs-8">
										<div class="row">
											<h4 class="list-group-item-heading">
												{{ $hiUser['FIRST_NAME'] }} {{ $hiUser['LAST_NAME'] }}
											</h4>
											<p class="list-group-item-text">{{ $hiUser['POSITION'] }}</p>		
										</div>
										<div class="row">
											<a href="#" class="btn btn-danger btn-sm" role="button">ยกเลิกเป็นผู้เกี่ยวข้อง</a>
										</div>
									</div>
						    	</div>
						    </a>
				@endforeach
			  </ul>
			</div>
			@endif
			
			@if(isset($normalUser))
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#normalUser">
					<h4 class="panel-title">Normal User</h4>
					<span class="label label-default label-badge">{{ count($normalUser) }}</span>
				</a>
			</div>
			<div id="normalUser" class="panel-collapse collapse">
			  <ul class="list-group">
				@foreach ($normalUser as $nmUser)
							<a href="#" class="list-group-item link">
						    	<div class="row">
							    	<div class="col-xs-2">
							    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $nmUser['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
							    	</div>
							    	<div class="col-xs-9">
							    		<h4 class="list-group-item-heading">
								    		{{ $nmUser['FIRST_NAME'] }} {{ $nmUser['LAST_NAME'] }}
								    	</h4>
								    	<p class="list-group-item-text">{{ $nmUser['POSITION'] }}</p>
										<a href="#" class="btn btn-danger btn-sm" role="button">ยกเลิกเป็นผู้เกี่ยวข้อง</a>
							    	</div>
						    	</div>
						    </a>
				@endforeach
			  </ul>
			</div>
			@endif
			
			@if(isset($unAuthorize))
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#unAuthorize">
					<h4 class="panel-title">Unauthorized User</h4>
					<span class="label label-default label-badge">{{ count($unAuthorize) }}</span>
				</a>
			</div>
			<div id="unAuthorize" class="panel-collapse collapse">
			  <ul class="list-group">
				@foreach ($unAuthorize as $unAuth)
							<a href="#" class="list-group-item link">
						    	<div class="row">
							    	<div class="col-xs-2">
							    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $unAuth['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
							    	</div>
							    	<div class="col-xs-9">
							    		<h4 class="list-group-item-heading">
								    		{{ $unAuth['FIRST_NAME'] }} {{ $unAuth['LAST_NAME'] }}
								    	</h4>
								    	<p class="list-group-item-text">{{ $unAuth['POSITION'] }}</p>
										<a href="authorizedUser/1/{{$unAuth['ID_USER']}}" class="btn btn-success btn-sm" role="button">เพิ่มเป็นผู้เกี่ยวข้อง</a>
										<a href="authorizedUser/2/{{$unAuth['ID_USER']}}" class="btn btn-info btn-sm" role="button">เพิ่มเข้ากลุ่ม</a>
										<a href="#" class="btn btn-warning btn-sm" role="button">ปฏิเสธ</a>
							    	</div>
						    	</div>
						    </a>
				@endforeach
			  </ul>
			</div>
			@endif
			
			@if(isset($rejectUser))
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#rejectUser">
					<h4 class="panel-title">Rejected User</h4>
					<span class="label label-default label-badge">{{ count($rejectUser) }}</span>
				</a>
			</div>
			<div id="rejectUser" class="panel-collapse collapse">
			  <ul class="list-group">
				@foreach ($rejectUser as $reUser)
							<a href="#" class="list-group-item link">
						    	<div class="row">
							    	<div class="col-xs-2">
							    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $reUser['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
							    	</div>
							    	<div class="col-xs-9">
							    		<h4 class="list-group-item-heading">
								    		{{ $reUser['FIRST_NAME'] }} {{ $reUser['LAST_NAME'] }}
								    	</h4>
								    	<p class="list-group-item-text">{{ $reUser['POSITION'] }}</p>
										<a href="authorizedUser/1/{{$reUser['ID_USER']}}" class="btn btn-success btn-sm" role="button">เพิ่มเป็นผู้เกี่ยวข้อง</a>
										<a href="authorizedUser/2/{{$reUser['ID_USER']}}" class="btn btn-info btn-sm" role="button">เพิ่มเข้ากลุ่ม</a>
							    	</div>
						    	</div>
						    </a>
				@endforeach
			  </ul>
			</div>
			@endif