<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">
			Add D Licenses
		</h3>
	</div>
	<div class="col-md-5">
		<a href="{{url('/resultAdmin/d-license')}}" class="btn btn-sm blue pull-right" ><i class="fa fa-arrow-left"> </i> Go Back</a>
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


@if(isset($license))
{{Form::open(array("url"=>'resultAdmin/d-license/update/'.$license->id,"method"=>'PUT',"class"=>"check_form"))}}
@else
{{Form::open(array("url"=>'resultAdmin/d-license/add',"method"=>'post',"class"=>"check_form"))}}
@endif
	<div class="form-body">
		<!--- my form start -->
			<div class="row">
				<div class="col-md-4 form-group">
					{{Form::label('Course Name')}}<span class="error">*</span>
					{{Form::text('course_name',(isset($license))?$license->course_name:'',["class"=>"form-control ","required"=>"true"])}}
					<span class="error">{{$errors->first('course_name')}}</span>
				</div>

				<div class="col-md-4 form-group">
					{{Form::label('Start Date')}}<span class="error">*</span>
					{{Form::text('start_date',(isset($license))?date('d-m-Y',strtotime($license->start_date)):'',["class"=>"form-control datepicker","required"=>"true","date_en"=>'true'])}}
					<span class="error">{{$errors->first('start_date')}}</span>
				</div>

				<div class="col-md-4 form-group">
					{{Form::label('End Date')}}<span class="error">*</span>
					{{Form::text('end_date',(isset($license))?date('d-m-Y',strtotime($license->end_date)):'',["class"=>"form-control datepicker","required"=>"true","date_en"=>'true'])}}
					<span class="error">{{$errors->first('end_date')}}</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 form-group">
					{{Form::label('Venue')}}<span class="error">*</span>
					{{Form::text('venue',(isset($license))?$license->venue:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('venue')}}</span>
				</div>
			
				<div class="col-md-4 form-group">
					{{Form::label('Description')}}<span class="error">*</span>
					{{Form::text('description',(isset($license))?$license->description:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('description')}}</span>
				</div>
			</div>

			<div>
				<h2 class="page-title" style="font-weight: 400;font-size: 20px;">Add Applicants</h2>
			</div>

			<div class="row" style="padding: 0 15px; overflow-y: auto;">
				<table class="table table-bordered table-hover">

					<tr>
						<th style="width:50px;">SN</th>
						<th>Applicant Name</th>
						<th>License Issue Date</th>
						<th>License Number</th>
						<th>Remarks</th>
					</tr>
					
					@for($i = 1; $i <= 25; $i++ )
					<tr id="applicant_{{$i}}">
						<td style="width:50px;">{{$i}}</td>
						<td>{{Form::text('applicant_name_'.$i,'',["class"=>"form-control" , "placeholder" => "Applicant name"])}}</td>
						<td>{{Form::text('issue_date_'.$i,'',["class"=>"form-control datepicker" , "placeholder" => "license issue date" , "date_en" => true])}}</td>
						<td>{{Form::text('license_number_'.$i,'',["class"=>"form-control" , "placeholder" => "license number"])}}</td>
						<td>{{Form::text('remarks_'.$i,'',["class"=>"form-control" , "placeholder" => "remarks"])}}</td>
					</tr>
					@endfor
				</table> 
			</div>

		<!---my form end-->
	
		<div class="form-actions" style="text-align: center;">
			<button type="submit" class="btn blue"><i class="fa fa-upload"> </i> {{(isset($license))?'Update':'Add'}}</button>
		</div>
	</div>
{{Form::close()}}
