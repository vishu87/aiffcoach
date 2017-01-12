<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">
			Courses list
		</h3>
	</div>
	
</div>

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


@if(isset($courses))
	<div>
		<!-- <h3>Pending Activities</h3> -->
	</div>
	@if(sizeof($courses) > 0)
	<?php $entity_type=5; ?>
	<div class="row" style="padding:20px;">
		<table class="table table-bordered table-hover">
			<tr>
				<th style="width:50px;">SN</th>
				<th>Course</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Venue</th>
				<th>#</th>
			</tr>
			<?php $count=1;?>
			@foreach($courses as $course)
				<tr>	
					<td>{{$count}}</td>
					<td>{{$course->name}}</td>
					<td>{{($course->start_date)?date('d-m-Y',strtotime($course->start_date)):''}}</td>
					<td>{{($course->end_date)?date('d-m-Y',strtotime($course->end_date)):''}}</td>
					<td>{{$course->venue}}</td>
					<th>
						<a href="{{url('resultAdmin/courses/viewApplications/'.$course->id)}}" class="btn btn-sm yellow">Applications <i class="fa fa-arrow-right"></i></a>
					</th>
				</tr>
				<?php $count++?>
			@endforeach
		</table> 
	</div>
	@else
	<div class="alert alert-warning">
		No courses found
	</div>
	@endif
@endif	