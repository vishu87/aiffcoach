<h2 class="page-title">Officials</h2>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue-madison">
			<div class="visual">
				<i class="fa fa-bar-chart"></i>
			</div>
			<div class="details-dash">
				<div class="number">
					{{$approved_officials}}
				</div>
				<div class="desc">
					Approved Officials
				</div>
			</div>
			<a class="more" href="{{url('admin/approvedCoach')}}">
			View all <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat red-intense">
			<div class="visual">
				<i class="fa fa-bar-chart"></i>
			</div>
			<div class="details-dash">
				<div class="number">
					{{$pending_officials}}
				</div>
				<div class="desc">
					Under Process
				</div>
			</div>
			<a class="more" href="{{url('admin/pendingCoach')}}">
			View all <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>

</div>