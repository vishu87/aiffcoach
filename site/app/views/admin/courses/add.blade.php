
	<div class="row">
		<div class="col-md-9">
			<h3 class="page-title">Courses</h3>
		</div>
		<div class="col-md-3">
			<a href="{{URL::previous()}}" class="btn blue pull-right">Go Back</a>
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
<div class="portlet box blue">
	<div class="portlet-title"><div class="caption">@if(!isset($course))Add New Course @else Edit Course Details @endif</div></div>

<div class="portlet-body form">


@if(isset($course))
{{Form::open(array("url"=>'admin/Courses/update/'.$course->id,"method"=>'PUT',"class"=>"check_form","files"=>"true"))}}
@else
{{Form::open(array("url"=>'admin/Courses/insert',"method"=>'post',"class"=>"check_form","files"=>'true'))}}
@endif
	<div class="form-body">
		<!--- my form start -->
			<div class="row">
				<div class="col-md-6 form-group">
					{{Form::label('Course Name')}}
					{{Form::text('name',(isset($course))?$course->name:'',["class"=>"form-control ","required"=>"true"])}}
					<span class="error">{{$errors->first('name')}}</span>
				</div>
				<div class="col-md-3 form-group">
					{{Form::label('Start Date')}}
					{{Form::text('start_date',(isset($course))?$course->start_date:'',["class"=>"form-control datepicker","required"=>"true","date"=>'true'])}}
					<span class="error">{{$errors->first('start_date')}}</span>
				</div>
				<div class="col-md-3 form-group">
					{{Form::label('End Date')}}
					{{Form::text('end_date',(isset($course))?$course->end_date:'',["class"=>"form-control datepicker","required"=>"true","date"=>'true'])}}
					<span class="error">{{$errors->first('end_date')}}</span>
				</div>
			</div>
			
			<div class="row">	
				
				<div class="col-md-3 form-group">
					{{Form::label('License Type')}}
					{{Form::select('license_id',$licenses,(isset($course))?$course->license_id:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('license_id')}}</span>
				</div>
				<div class="col-md-3 form-group">
					{{Form::label('Fee')}}
					{{Form::text('fee',(isset($course))?$course->fees:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('fee')}}</span>
				</div>
				<div class="col-md-6 form-group">
					{{Form::label('Venue')}}
					{{Form::text('venue',(isset($course))?$course->venue:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('venue')}}</span>
				</div>
			</div>

			<div class="row">	
				
				
				<div class="col-md-12 form-group">
					{{Form::label('Description')}}
					{{Form::textarea('description',(isset($course))?$course->description:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('description')}}</span>
				</div>
			</div>
			<div class="row">	
				
				<div class="col-md-6 form-group">
					<div class="row">
						<div class="col-md-8">
							{{Form::label('Documents')}}
							{{Form::file('documents',["class"=>"form-control","pdf"=>'true'])}}
							<span class="error">{{$errors->first('documents')}}</span>

						</div>
						@if(isset($course))

							<div class="col-md-4" style="margin-top:25px;">
		        				@if($course->documents!='')<a href="{{url($course->documents)}}" class="btn yellow" target="_blank">View Old Document</a>@endif
		        			</div>
		        		@endif	
					</div>
				</div>
			</div>
		<!---my form end-->
	</div>
	<div class="form-actions" style="margin-top:40px;">
		<button type="submit" class="btn blue">{{(isset($course))?'Update':'Add'}}</button>
	</div>
{{Form::close()}}

</div>
</div>