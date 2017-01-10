
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
		<h3 class="page-title">{{$course->name}}</h3>
	</div>
</div>

<div class="course-details">
	<div class="row detail">
		<div class="col-md-6">
			<span>License</span>
			{{$course->license_name}}
		</div>
	</div>

	<div class="row detail">
		<div class="col-md-4">
			<span>Start Date</span>
			{{date('d-m-Y',strtotime($course->start_date))}}
		</div>
		<div class="col-md-4">
			<span>End Date</span>
			{{date('d-m-Y',strtotime($course->end_date))}}
		</div>
		<div class="col-md-4">
			<span>Venue</span>
			{{$course->venue}}
		</div>
	</div>

	<div class="row detail">
		<div class="col-md-4">
			<span>Fees</span>
			{{$course->fees}} Rs
		</div>
		<div class="col-md-4">
			<span>Attachments</span>
			@if(!empty($course->documents))
				<a href="{{url($course->documents)}}" target="_blank" style="font-size:16px;">View document</a>
			@else
			N/A
			@endif
		</div>
	</div>

	<div class="row detail">
		<div class="col-md-6">
			<span>Description</span>
			{{$course->description}}
		</div>
	</div>

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

</div>

<div class="row">
	@if($is_applied)
		@if(!Session::has('success'))
			<div class="alert alert-danger">
				You have already applied for the course. Please check applications section.
			</div>
		@endif
		
	@else
	{{Form::open(array('url'=>'coach/courses/apply/'.$course->id,'method'=>'post','files'=>'true','class'=>"check_form"))}}
        <div class="col-md-6">
          <div class="">
            <label>Remarks </label>
            {{Form::text('remarks','',["class"=>"form-control"])}}
          </div>
          <div>
            <label>Document</label>
            {{Form::file('document',["class"=>'form-control'])}}
          </div>
        </div>
        <div class="col-md-12">
          {{Form::submit('Apply for course',["class"=>"btn green","style"=>"margin-top:20px"])}}
        </div>
      {{Form::close()}}
    @endif
</div>