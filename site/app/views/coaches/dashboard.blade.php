@if(Session::has('success'))
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		{{Session::get('success')}}
	</div>
@endif

@if(Session::has('failure'))
    	<div class="alert alert-danger">
        	<button type="button" class="close" data-dismiss="alert">×</button>
        	<i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
       	</div>
@endif

@if($coach_employments == 0)
	<div class="alert alert-danger">
		Your profile doesn't have any employment details. Please add at least one employment details to get approved by AIFF.<br>To add new employement <a href="{{url('coach/addNewEmployment')}}">Click Here</a>
	</div>
@endif

@if($coach_licenses == 0)
	<div class="alert alert-danger">
		Your profile doesn't have any license details. Please add at least one license to get approved by AIFF.<br>
		To add license <a href="{{url('coach/coachLicense')}}">Click here</a>
	</div>
@endif
<div class="row">
	<div class="col-md-12">
		<h2 class="page-title">Active Courses</h2>
		<div style="overflow-y:auto">
			<table class="table table-bordered table-hover tablesorter">
				<thead>
					<tr>
						<th style="width:50px">SN</th>
						<th>Course Name</th>
						<th>Venue</th>
						<th>Course Start Date</th>
						<th>Registration Start Date</th>
						<th>Registration End Date</th>
						<th>Manage</th>
					</tr>
				</thead>
					<tbody id="courses">
						<?php $count = 1; ?>
						@foreach($courses as $data)
						<tr id="activity_{{$data->id}}">
							<td>{{$count}}</td>
							<td>{{$data->name}}</td>
							<td>{{$data->venue}}</td>
							<td>{{$data->start_date}}</td>
							<td>{{$data->registration_start}}</td>
							<td>{{$data->registration_end}}</td>
							<td>
								@if(!isset($status))
									@if(isset($data->application_id))
										<a type="button" class="btn green btn-sm " href="{{url('control/applications/details/'.$data->application_id)}}">View Application</a>
										@if($data->application_status == 1)
											<span class="badge badge-danger badge-roundless"> Please fill payment details </span>
										@endif
										@if($data->application_status == 4)
											<span class="badge badge-danger badge-roundless"> Your application is referred back </span>
										@endif
										@if($data->application_status == 5)
											<span class="badge badge-danger badge-roundless"> Your application is rejected </span>
										@endif
									@else
										<a type="button" class="btn default btn-sm " href="{{url('coach/courses/details/'.$data->id)}}">View Course</button>
									@endif
								@endif	
							</td>
						</tr>
							<?php $count++ ?>
						@endforeach
					</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-12">
		
		@if($coach->status == 2)
			<div class="alert alert-danger">Your account is referred back. Please make changes to your profile as per AIFF remark below and then press re-submit button to send your account back for approval.{{Form::open(array('url'=>'approve/1/'.$coach->id,'method'=>'post','files'=>'true','class'=>""))}}{{Form::radio('type',1, true,["class"=>"hidden"])}}{{Form::submit('Re-Submit',["class"=>"btn green btn","style"=>"margin-top:20px"])}}{{Form::close()}}</div>
		@endif
		@if($coach->status == 3)
			<div class="alert alert-danger">Your account is rejected.</div>
		@endif
		@if($coach->status == 0)
			<div class="alert alert-warning">Your account is under approval.</div>
		@endif
		@if($coach->status == 1)
			<div class="alert alert-success">Your account is approved.</div>
		@endif
		<div>
			@if($coach->check_coach())
				<?php $entity_type=1; $entity_id = $coach->id; $show_refer = 1; ?>
				@include('approve_box')
			@endif
			{{Approval::approval_html(1, $coach->id)}}
		</div>
	</div>
</div>