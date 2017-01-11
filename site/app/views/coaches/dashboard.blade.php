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

@if(sizeof($coach_employments) < 1)
	<div class="alert alert-danger">
		Your profile doesn't have any employment details. Please add at least one employment details to get approved by AIFF.<br>To add new employement <a href="{{url('coach/addNewEmployment')}}">Click Here</a>
	</div>
@endif

@if(sizeof($coach_licenses) < 1)
	<div class="alert alert-danger">
		Your profile doesn't have any license details. Please add at least one license to get approved by AIFF.<br>
		To add license <a href="{{url('coach/coachLicense')}}">Click here</a>
	</div>
@endif
<div class="row">
	<div class="col-md-6">
		<h2 class="page-title">Active Courses</h2>
		<div style="overflow-y:auto">
			<table class="table table-bordered table-hover tablesorter">
				<thead>
					<tr>
						<th style="width:50px">SN</th>
						<th>Course Name</th>
						<th>License Name</th>
						<th>Start Date</th>
						<th>#</th>
					</tr>
				</thead>
					<tbody id="courses">
						<?php $count = 1; ?>
						@foreach($courses as $data)
						<tr id="activity_{{$data->id}}">
							<td>{{$count}}</td>
							<td>{{$data->name}}</td>
							<td>{{$data->license_name}}</td>
							<td>{{$data->start_date}}</td>
							<td>
								@if(!isset($status))
									@if(in_array($data->id,$check))
									<a type="button" class="btn blue btn-sm " div-id="activity_{{$data->id}}"  href="{{url('coach/courses/details/'.$data->id)}}">Already Applied</button>
									@else
									<a type="button" class="btn blue btn-sm " div-id="activity_{{$data->id}}"  href="{{url('coach/courses/details/'.$data->id)}}">Apply</button>
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
	<div class="col-md-6">
		<div class="page-title">Status: {{Approval::get_status($coach->status)}}</div>
		<div>
			@if($coach->check_coach())
				<?php $entity_type=1; $entity_id = $coach->id; $show_refer = 1; ?>
				@include('approve_box')
			@endif
			{{Approval::approval_html(1, $coach->id)}}
		</div>
	</div>
</div>