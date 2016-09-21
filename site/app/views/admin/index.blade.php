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


<h2 class="page-title">Courses</h2>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue-madison">
			<div class="visual">
				<i class="fa fa-bar-chart"></i>
			</div>
			<div class="details-dash">
				<div class="number">
					{{$active_courses}}
				</div>
				<div class="desc">
					Active Courses
				</div>
			</div>
			<a class="more" href="{{url('admin/Courses/active')}}">
			View all <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue-madison">
			<div class="visual">
				<i class="fa fa-bar-chart"></i>
			</div>
			<div class="details-dash">
				<div class="number">
					{{$all_courses}}
				</div>
				<div class="desc">
					All Courses
				</div>
			</div>
			<a class="more" href="{{url('admin/Courses')}}">
			View all <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>

</div>


<h2 class="page-title">Applications</h2>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat red-intense ">
			<div class="visual">
				<i class="fa fa-bar-chart"></i>
			</div>
			<div class="details-dash">
				<div class="number">
					{{$pending_applications}}
				</div>
				<div class="desc">
					Pending for Approval
				</div>
			</div>
			<a class="more" href="{{url('admin/Applications/all?course=&status=0')}}">
			View all <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue-madison">
			<div class="visual">
				<i class="fa fa-bar-chart"></i>
			</div>
			<div class="details-dash">
				<div class="number">
					{{$approved_applications}}
				</div>
				<div class="desc">
					Waiting for Payment
				</div>
			</div>
			<a class="more" href="{{url('admin/Applications/all?course=&status=1')}}">
			View all <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat red-intense ">
			<div class="visual">
				<i class="fa fa-bar-chart"></i>
			</div>
			<div class="details-dash">
				<div class="number">
					{{$payment_under_approval}}
				</div>
				<div class="desc">
					Payment Under Approval
				</div>
			</div>
			<a class="more" href="{{url('admin/Applications/all?course=&status=2')}}">
			View all <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>

	

</div>