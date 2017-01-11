<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">@if(isset($course)) Update Course Details @else Add Course @endif</h3>
	</div>
	<div class="col-md-6">
		<a href="{{url('admin/Courses')}}" class="btn blue pull-right">Go Back</a>
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

@if(isset($course))
{{Form::open(array("url"=>'admin/Courses/update/'.$course->id,"method"=>'PUT',"class"=>"check_form","files"=>"true"))}}
@else
{{Form::open(array("url"=>'admin/Courses/insert',"method"=>'post',"class"=>"check_form","files"=>'true'))}}
@endif
<div class="form-body">
	<!--- my form start -->
		<div class="row">
			<div class="col-md-6 form-group">
				{{Form::label('Course Name')}} <span class="error"> *</span>
				{{Form::text('name',(isset($course))?$course->name:'',["class"=>"form-control ","required"=>"true"])}}
				<span class="error">{{$errors->first('name')}}</span>
			</div>
			<div class="col-md-3 form-group">
				{{Form::label('Course Start Date')}} <span class="error"> *</span>
				{{Form::text('start_date',(isset($course))?date('d-m-Y',strtotime($course->start_date)):'',["class"=>"form-control datepicker","required"=>"true","date_en"=>'true'])}}
				<span class="error">{{$errors->first('start_date')}}</span>
			</div>
			<div class="col-md-3 form-group">
				{{Form::label('Course End Date')}} <span class="error"> *</span>
				{{Form::text('end_date',(isset($course))?date('d-m-Y',strtotime($course->end_date)):'',["class"=>"form-control datepicker","required"=>"true","date_en"=>'true'])}}
				<span class="error">{{$errors->first('end_date')}}</span>
			</div>
			<div class="col-md-3 form-group clear">
				{{Form::label('Registration Start Date')}} <span class="error"> *</span>
				{{Form::text('registration_start',(isset($course))?date('d-m-Y',strtotime($course->registration_start)):'',["class"=>"form-control datepicker","required"=>"true","date_en"=>'true'])}}
				<span class="error">{{$errors->first('registration_start')}}</span>
			</div>
			<div class="col-md-3 form-group">
				{{Form::label('Registration End Date')}} <span class="error"> *</span>
				{{Form::text('registration_end',(isset($course))?date('d-m-Y',strtotime($course->registration_end)):'',["class"=>"form-control datepicker","required"=>"true","date_en"=>'true'])}}
				<span class="error">{{$errors->first('registration_end')}}</span>
			</div>	
			<div class="col-md-3 form-group">
				{{Form::label('License Type')}} <span class="error"> *</span>
				{{Form::select('license_id',$licenses,(isset($course))?$course->license_id:'',["class"=>"form-control","required"=>"true"])}}
				<span class="error">{{$errors->first('license_id')}}</span>
			</div>
			<div class="col-md-3 form-group">
				{{Form::label('Fee')}} <span class="error"> *</span>
				{{Form::text('fee',(isset($course))?$course->fees:'',["class"=>"form-control","required"=>"true"])}}
				<span class="error">{{$errors->first('fee')}}</span>
			</div>
			<div class="col-md-3 form-group clear">
				{{Form::label('Venue')}}
				{{Form::text('venue',(isset($course))?$course->venue:'',["class"=>"form-control"])}}
				<span class="error">{{$errors->first('venue')}}</span>
			</div>
			<div class="col-md-3 form-group">
				{{Form::label('Instructors')}}
				{{Form::select('instructor[]',$instructors,(isset($selectedInstructors))?$selectedInstructors:'',["class"=>"form-control","multiple"=>"true"])}}
				<span class="error">{{$errors->first('instructor')}}</span>
			</div>
			<div class="col-md-6 form-group hidden">
				{{Form::label('Documents')}}
				{{Form::file('documents',["class"=>"form-control","pdf"=>'true'])}}
				<span class="error">{{$errors->first('documents')}}</span>
				@if(isset($course))
    				@if($course->documents!='')<a href="{{url($course->documents)}}" class="btn yellow" target="_blank">View Old Document</a>@endif
        		@endif	
			</div>
		</div>
		<div class="row">	
			<div class="col-md-12 form-group">
				<label>Remarks (if any)</label>
				{{Form::textarea('description',(isset($course))?$course->description:'',["class"=>"form-control"])}}
				<span class="error">{{$errors->first('description')}}</span>
			</div>
		</div>
		<div class="row">	
			
		</div>
	<!---my form end-->
</div>
<div class="form-actions" style="margin-top:40px;">
	<button type="submit" class="btn blue">{{(isset($course))?'Update':'Add'}}</button>
</div>
{{Form::close()}}