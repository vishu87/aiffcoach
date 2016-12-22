<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">
			@if(!isset($employment))
				Add New Employment
			@else
				{{$employment->employment}}
			@endif
		</h3>
	</div>
	<div class="col-md-5">
		<a href="{{url('coach/employmentDetails	')}}" class="btn blue pull-right">Go Back</a>
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
<div class="portlet-body form">
    @if(isset($employment))
    {{ Form::open(array('url' =>(isset($employment))?'coach/updateEmployment/'.$employment->id:'coach/addEmployment',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}			        
	@else
	{{ Form::open(array('url' =>(isset($employment))?'coach/addEmployment/'.$employment->id:'coach/addEmployment',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}
	@endif			        
	<div class="form-body">
	    <div class="row">
			<div class="col-md-6">
		      <div class="form-group">
		        <label>Organization</label><span class="error"> *</span>
		        
		          {{Form::text('present_emp',(isset($employment))?$employment->employment:'',['required'=>'true','placeholder'=>"Present Football Employment",'class'=>"form-control "])}}
		          <span class="error">{{$errors->first('present_emp')}}</span>
		      </div>
		    </div>

		    <div class="col-md-6">
		      <div class="form-group">
		        <label>Employment Status</label><span class="error"> *</span>
		        
		          {{Form::select('employment_status',$emp_status,(isset($employment))?$employment->emp_status:'',['required'=>'true','class'=>"form-control "])}}
		          <span class="error">{{$errors->first('employment_status')}}</span>
		      </div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-md-6">
		      	<div class="form-group">
		        	<label>Date Since Employed</label><span class="error"> *</span>
		            {{Form::text('date_since_emp',(isset($employment))?date('d-m-Y',strtotime($employment->start_date)):'',['required'=>'true','class'=>"form-control datepicker ","date_en"=>'true'])}}
		            <span class="error">{{$errors->first('date_since_emp')}}</span>
		      	</div>
		    </div>
			<div class="col-md-6">
		      	<div class="form-group ">
		        	<label>End Date</label>
		            {{Form::text('end_date',(isset($employment))?date('d-m-Y',strtotime($employment->end_date)):'',['class'=>"form-control datepicker ","date_en"=>'true'])}}
		            <span class="error">{{$errors->first('date_since_emp')}}</span>
		      	</div>
		    </div>
		</div>
		<div class="row">
			<div class="col-md-6 form-group">
				@if(isset($employment))
        			<div class="form-group">
        				<label>Upload CV</label>
		        		{{Form::file('cv',["class"=>"form-control","id"=>"contract","pdf"=>'true'])}}
			            <span class="error">{{$errors->first('cv')}}</span>
			            <div class="col-md-4 form-group">
        					@if($employment->cv!='')<a href="{{url($employment->cv)}}" target="_blank">view current</a>@endif
        				</div>
        			</div>
		        @else
		        	<label>CV</label>
	        		{{Form::file('cv',["class"=>"form-control","id"=>"contract","pdf"=>'true'])}}
		            <span class="error">{{$errors->first('cv')}}</span>
		        @endif    
	        </div>
			<div class="col-md-6 form-group">
				@if(isset($employment))
        			<div class="form-group">
        				<label>Copy of Present Footballing Employment Contract</label>
		        		{{Form::file('present_emp_copy',["class"=>"form-control","id"=>"contract","pdf"=>'true'])}}
			            <span class="error">{{$errors->first('present_emp_copy')}}</span>
			            <div class="col-md-4 form-group">
        					@if($employment->contract!='')<a href="{{url($employment->contract)}}" target="_blank">view current</a>@endif
        				</div>
        			</div>
		        @else
		        	<label>Copy of Present Footballing Employment Contract</label>
	        		{{Form::file('present_emp_copy',["class"=>"form-control","id"=>"contract","pdf"=>'true'])}}
		            <span class="error">{{$errors->first('present_emp_copy')}}</span>
		        @endif    
	        </div>
		</div>
		<div>
			<h3 class="page-title">
				Referral Details
			</h3>
		</div>

		<div class="row">
			<div class="col-md-6">
		      <div class="form-group">
		        <label>Name</label><span class="error"> *</span>
		        
		          {{Form::text('referral_name',(isset($employment))?$employment->referral_name:'',['required'=>'true','placeholder'=>"Referral Name",'class'=>"form-control "])}}
		          <span class="error">{{$errors->first('referral_name')}}</span>
		      </div>
		    </div>

		    <div class="col-md-6">
		      <div class="form-group">
		        <label>Contact Number</label><span class="error"> *</span>
		        
		          {{Form::text('referral_contact',(isset($employment))?$employment->referral_contact:'',['required'=>'true','class'=>"form-control " ,'placeholder'=>"Contact Number"])}}
		          <span class="error">{{$errors->first('referral_contact')}}</span>
		      </div>
		    </div>
		</div>

		<div>
    		<button type="submit" class="btn btn-primary">Submit</button>
    	</div>
    </div>
</div>      
{{Form::close()}}
