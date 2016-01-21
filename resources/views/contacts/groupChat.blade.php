<div class="row">
	<div class="col-xs-12 text-right">
		<button class="btn btn-primary btn-md btn-block">CHAT</button>
	</div>
</div>
<div class="panel-group">
  	<div class="panel panel-default">
		@if(isset($groupMembers))
		<div class="panel-heading">
			<a class="collapseLink" data-toggle="collapse" href="#highUser">
				<h4 class="panel-title">สมาชิกทั้งหมด
					<span class="label label-default label-badge-group-chat">{{ $total }}</span>
				</h4>
			</a>
		</div>
		<div id="highUser" class="panel-collapse collapse in">
		  <ul class="list-group">
		  	@if(count($groupMembers)>0)
				@foreach ($groupMembers as $members)
					@foreach ($members as $member)
					<li class="list-group-item link">
				    	<div class="row">
					    	<div class="col-xs-2">
					    		<img class="img-responsive img-circle avatar imgUsr" src="http://apps.jobtopgun.com/Mercury/photos/{{ $member['ID_USER'] }}.jpg" onerror='this.src="img/avatar.png"'>
					    	</div>
					    	<div class="col-xs-8">
								<div class="row">
									<h4 class="list-group-item-heading">
										{{ $member['FIRST_NAME'] }} {{ $member['LAST_NAME'] }}
									</h4>
									<p class="list-group-item-text">
										@if ( $member['USER_TYPE'] == '1')
										     Top Gun Co.,Ltd.
										@else
										    {{ $member['POSITION'] }}
										@endif
									</p>
								</div>
							</div>
				    	</div>
				    </li>
					@endforeach
				@endforeach
			@else
				<a class="list-group-item text-center"><h3>ไม่พบข้อมูล</h3></a>
			@endif
		  </ul>
		</div>
		@endif
	</div>
</div>
