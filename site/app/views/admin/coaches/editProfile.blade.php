<div class="row">
	<div class="col-md-8">
		<h2 class="page-title">{{'Edit Details - '.strtoupper($coach->full_name)}} <br>{{strtoupper($coach->registration_id)}}</h2>
	</div>
	<div class="col-md-4">
		<a href="{{url('admin/viewCoachDetails/'.$coach->id)}}" class="btn blue pull-right" style="margin-top:10px">Back</a>
	</div>
</div>

{{Form::open(array("url"=>'admin/updateCoachProfile/'.$coach->id,"method"=>'POST','files'=>"true","class"=>"check_form"))}}
	<div class="form-body">
		<!--- profile form start -->
			<div class="row">
				<div class="col-md-6 form-group">
					{{Form::label('Full Name')}} <span class="error"> *</span>
					{{Form::text('full_name',(isset($coach))?$coach->full_name:'',["class"=>"form-control ","required"=>"true"])}}
					<span class="error">{{$errors->first('full_name')}}</span>
				</div>
				<div class="col-md-6 form-group">
				    <label class="control-label ">Email Id <span class="error"> *</span></label>
				    {{Form::text('email',(isset($coach->email))?$coach->email:'',['required'=>'true','placeholder'=>"Email Id",'class'=>"form-control placeholder-no-fix"])}}
				    <span class="error">{{$errors->first('email')}}</span>
				</div>
				<div class="col-md-6 form-group clear">
					{{Form::label('Mobile')}} <span class="error"> *</span>
					{{Form::text('mobile',(isset($coach))?$coach->mobile:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('mobile')}}</span>
				</div>
				<div class="col-md-6 form-group">
		            <label class="form-label">Gender <span class="error"> *</span></label><br>
		            {{Form::radio('gender','1',(isset($coach->gender))?($coach->gender==1)?$coach->gender:'':'',['required'=>'true','placeholder'=>''])}} Male &nbsp; &nbsp; &nbsp;
		            {{Form::radio('gender','2',(isset($coach->gender))?($coach->gender==2)?$coach->gender:'':'',['required'=>'true','placeholder'=>''])}} Female
		            <span class="error">{{$errors->first('gender')}}</span>
		        </div>
		        <div class="col-md-6 form-group clear">
		        	<label class="form-label"> DOB <span class="error"> *</span></label>
		        	{{Form::text('dob',(isset($coach->dob))?date('d-m-Y',strtotime($coach->dob)):'',["class"=>"form-control datepicker","date_en"=>"true","required"=>"true"])}}
		          <span class="dob-error"></span>
		        </div>
		        <div class="col-md-6 form-grou">
		        	<label class="form-label">Profile Picture</label>
		        	{{Form::file('photo',["jpg"=>"true","class"=>"form-control"])}}
		          	<div>
		          		@if($coach->photo!='')
		          			<a href="{{url($coach->photo)}}" target="_blank">view current</a>
		          		@endif		
		          	</div>
		        </div>
		        <div class="col-md-6 form-group">
		        	<label class="form-label">User Types</label><br>
		        	@foreach($officialTypes as $officialTypeId => $officialTypeValue)
		        		{{Form::checkbox('official_types[]',$officialTypeId,in_array($officialTypeId,$selectedOfficialTypes))}}  &nbsp;{{$officialTypeValue}} <br>
		        	@endforeach
		        </div>
			</div>
		<!---profile form end-->
	</div>
	<div class="form-actions" >
		<button type="submit" class="btn blue">Update</button>
	</div>
{{Form::close()}}