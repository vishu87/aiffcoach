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
<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">Applicant - {{$application->full_name}}</h3>
	</div>
	<div class="col-md-6">
		<h3 class="page-title page-title2">Application Status - {{$ApplicationStatus[$application->status]}}</h3>
		@if($data->status == 0 || $data->status == 4)
			<button class="btn btn-sm btn-danger delete-div" div-id="activity_{{$data->application_id}}" action="{{'coach/applications/delete/'.$data->application_id}}"><i class="fa fa-remove"></i>
			</button>
		@endif
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="course-details">
			<div class="row detail">
				<div class="col-md-6">
					<span>Course</span>
					{{$course->name}}
				</div>
			</div>

			<div class="row detail">
				<div class="col-md-4">
					<span>Course Start Date</span>
					{{date('d-m-Y',strtotime($course->start_date))}}
				</div>
				<div class="col-md-4">
					<span>Course End Date</span>
					{{date('d-m-Y',strtotime($course->end_date))}}
				</div>
				<div class="col-md-4">
					<span>Registration Start Date</span>
					{{date('d-m-Y',strtotime($course->registration_start))}}
				</div>
				<div class="col-md-4">
					<span>Registration End Date</span>
					{{date('d-m-Y',strtotime($course->registration_end))}}
				</div>
				<div class="col-md-4">
					<span>Venue</span>
					{{$course->venue}}
				</div>
				<div class="col-md-4">
					<span>Fees</span>
					{{$course->fees}} Rs
				</div>
			</div>

			<div class="row detail">
				<div class="col-md-6">
					<span>Remarks</span>
					{{$course->description}}
				</div>
			</div>

			@if(Session::get('privilege') == 2)
			<div class="row detail">
				<div class="col-md-12">
					<span>Pre Requisites</span>
					@if(sizeof($prerequisites) > 0)
						@foreach($prerequisites as $prerequisite)
							@if(isset($coach_licenses[$prerequisite]))
								@if($coach_licenses[$prerequisite]["start_date"] < $check_date )
									<span class="color-green"><i class="fa fa-check"></i> {{$licenses[$prerequisite]}}</span>
								@else
									<span class="color-red"><i class="fa fa-remove"></i> {{$licenses[$prerequisite]}} (Your license is registered on {{date("d-m-Y",strtotime($coach_licenses[$prerequisite]["start_date"]))}}. You must complete 2 years under this license to apply for the course.)</span>
								@endif
							@else
								<span class="color-red"><i class="fa fa-remove"></i> {{$licenses[$prerequisite]}}</span>
							@endif
						@endforeach
					@else
						Not Applicable
					@endif
				</div>
			</div>
			@else
			<div class="row detail">
				<div class="col-md-12">
					<span>Pre Requisites</span>
					@if(sizeof($prerequisites) > 0)
						@foreach($prerequisites as $prerequisite)
							<span class="">{{$licenses[$prerequisite]}}</span>
						@endforeach
					@else
						Not Applicable
					@endif
				</div>
			</div>
			@endif
		</div>

		@if($payment)
			@if($payment->check_status($application))
				@include('coaches.applications.payment')
			@else
				@include('coaches.applications.payment_view')
			@endif
		@endif

	</div>
	<div class="col-md-6">
		<div>	
			<?php $count_log = 0; ?>
			@foreach($application_log as $log)
				@if($count_log != 0)
					<div class="arrow-up">
						<img src="{{url('assets/img/up_arrow.png')}}">
					</div>
				@endif
				@include('admin.applications.log_box')

				<?php $count_log++; ?>
			@endforeach
		</div>
	</div>
</div>

