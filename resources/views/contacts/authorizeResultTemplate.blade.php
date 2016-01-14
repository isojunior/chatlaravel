<div class="panel-group">
		  <div class="panel panel-default">
			@if(isset($highUser))
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#highUser">
					<h4 class="panel-title">High User <span class="label label-default label-badge-authorized">{{ count($highUser) }}</span></h4>
				</a>
			</div>
			<div id="highUser" class="panel-collapse collapse">
			  <ul class="list-group">
			  	@if(count($highUser)>0)
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
										<button class="btn btn-danger btn-sm cancel">ยกเลิกเป็นผู้เกี่ยวข้อง</button>
									</div>
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

			@if(isset($normalUser))
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#normalUser">
					<h4 class="panel-title">Normal User <span class="label label-default label-badge-authorized">{{ count($normalUser) }}</span></h4>
				</a>
			</div>
			<div id="normalUser" class="panel-collapse collapse">
			  <ul class="list-group">
			  	@if(count($normalUser)>0)
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
										<button class="btn btn-danger btn-sm cancel">ยกเลิกเป็นผู้เกี่ยวข้อง</button>
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

			@if(isset($unAuthorize))
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#unAuthorize">
					<h4 class="panel-title">Unauthorized User <span class="label label-default label-badge-authorized">{{ count($unAuthorize) }}</span></h4>
				</a>
			</div>
			<div id="unAuthorize" class="panel-collapse collapse">
			  <ul class="list-group">
			  	@if(count($unAuthorize)>0)
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
										<button data-attr="{{ $unAuth['ID_USER'] }}" class="btn btn-success btn-sm accept">เพิ่มเป็นผู้เกี่ยวข้อง</button>
										<button data-attr="{{ $unAuth['ID_USER'] }}" class="btn btn-info btn-sm group">เพิ่มเข้ากลุ่ม</button>
										<button data-attr="{{ $unAuth['ID_USER'] }}" class="btn btn-warning btn-sm reject">ปฏิเสธ</button>
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

			@if(isset($rejectUser))
			<div class="panel-heading">
				<a class="collapseLink" data-toggle="collapse" href="#rejectUser">
					<h4 class="panel-title">Rejected User <span class="label label-default label-badge-authorized">{{ count($rejectUser) }}</span></h4>
				</a>
			</div>
			<div id="rejectUser" class="panel-collapse collapse">
			  <ul class="list-group">
			  	@if(count($rejectUser)>0)
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
										<button data-attr="{{ $reUser['ID_USER'] }}" class="btn btn-success btn-sm accept">เพิ่มเป็นผู้เกี่ยวข้อง</button>
										<button data-attr="{{ $reUser['ID_USER'] }}"class="btn btn-info btn-sm group">เพิ่มเข้ากลุ่ม</button>
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
@section('scripts')
<script>
	$(document).ready(function(){

		var manageButton = {};
			manageButton.init
			= function(){
				var modal = $("#modal-data");
				var acceptButton = $("button.accept");
				var groupButton = $("button.group");
				var rejectButton = $("button.reject");
				manageButton.handler(acceptButton, modal);
			};

			manageButton.acceptBandler
			= function(acceptButton, modal){
				acceptButton.click(function(e){
					var userID = $(this).data("attr");
					$.ajax({
						url: "authorizedUser/2/"+userID,
						type: 'get',
						data: { 'data': userID },
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
			
			manageButton.rejectBandler
			= function(acceptButton, modal){
				acceptButton.click(function(e){
					var userID = $(this).data("attr");
					$.ajax({
						url: "rejectUser/"+userID
						type: 'get',
						data: { 'data': userID },
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
			manageButton.init();
	});
</script>
@endsection
