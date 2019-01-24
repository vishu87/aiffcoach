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
	<div class="">
	    <div class="row">
	    	<div class="col-md-6">
		      <div class="form-group">
		        <label>Employment Status</label><span class="error"> *</span>
		        
		          {{Form::select('employment_status',$emp_status,(isset($employment))?$employment->emp_status:'',['required'=>'true','class'=>"form-control ", "id" => "emp_status"])}}
		          <span class="error">{{$errors->first('employment_status')}}</span>
		      </div>
		    </div>

		    <div id="organization_fields" class="{{(isset($employment) && $employment->emp_status == 3)?'hiddenDiv':''}}">
		    	
				<div class="col-md-6 form-group emp_validate">
			      
			        <label>Organization Type</label><span class="error"> *</span>
			        
			          {{Form::select('organization_type',$organization_types,(isset($employment))?$employment->organization_type:'',['required'=>'true','class'=>"form-control" , "id"=>"organization_type"])}}
			          <span class="error">{{$errors->first('organization_type')}}</span>
			     
			    </div>

			    <div class="col-md-6 form-group {{(isset($employment) && $employment->organization_type == 1 && $employment->organization_id != 0)?'':'hiddenDiv'}}" id="associations">
			      
			        <label>Associations</label><span class="error"> *</span>
			        
			          {{Form::select('association_id',$associations,(isset($employment))?$employment->organization_id:'',['required'=>'true','class'=>"form-control select" , "id"=>"organization_id"])}}
			          <span class="error">{{$errors->first('organization_id')}}</span>
			     
			    </div>

			    <div class="col-md-6 form-group {{(isset($employment) && $employment->organization_type == 2 && $employment->organization_id != 0)?'':'hiddenDiv'}}" id="clubs">
			      
			        <label>Clubs</label><span class="error"> *</span>
			        
			          {{Form::select('club_id',$clubs,(isset($employment))?$employment->organization_id:'',['required'=>'true','class'=>"form-control select" , "id"=>"organization_id"])}}
			          <span class="error">{{$errors->first('organization_id')}}</span>
			     
			    </div>

			    <div class="col-md-6 form-group {{(isset($employment) && $employment->organization_type == 3 && $employment->organization_id != 0)?'':'hiddenDiv'}}" id="schools">
			      
			        <label>Schools</label><span class="error"> *</span>
			        
			          {{Form::select('school_id',$schools,(isset($employment))?$employment->organization_id:'',['required'=>'true','class'=>"form-control select" , "id"=>"organization_id"])}}
			          <span class="error">{{$errors->first('organization_id')}}</span>
			     
			    </div>

			    <div class="col-md-6 form-group {{(isset($employment) && $employment->organization_type == 0)?'':'hiddenDiv'}}" id="organization_name">
			      
			        <label>Organization</label>
			        
			          {{Form::text('present_emp',(isset($employment))?$employment->employment:'',['placeholder'=>"Present Football Employment",'class'=>"form-control "])}}
			          <span class="error">{{$errors->first('present_emp')}}</span>
			     
			    </div>

			    <div class="col-md-6 form-group">
			      
			        <label>Designation</label><span class="error"> *</span>
			        
			          {{Form::select('designation_id',$designations,(isset($employment))?$employment->designation_id:'',['required'=>'true','class'=>"form-control" , "id"=>"designation_id"])}}
			          <span class="error">{{$errors->first('designation_id')}}</span>
			     
			    </div>

			    <div class="col-md-6 form-group {{(isset($employment) && $employment->designation_id == 0)?'':'hiddenDiv'}}" id="designation_name">
			      
			        <label>Specify Designation <span class="error">*</span></label>
			        
			          {{Form::text('designation_name',(isset($employment))?$employment->designation_name:'',['class'=>"form-control " , "required"=>true])}}
			          <span class="error">{{$errors->first('designation_name')}}</span>
			     
			    </div>

		    </div>

		    
		    <div class="col-md-6 form-group {{(isset($employment) && $employment->emp_status == 3)?'hiddenDiv':''}}">
	        	<label>Date Since Employed</label><span class="error"> *</span>
	            {{Form::text('date_since_emp',(isset($employment) && $employment->start_date != null)?date('d-m-Y',strtotime($employment->start_date)):'',['required'=>'true','class'=>"form-control emp_validate datepicker ","date_en"=>'true'])}}
	            <span class="error">{{$errors->first('date_since_emp')}}</span>
		    </div>
			<div class="col-md-6 form-group {{(isset($employment) && $employment->emp_status == 3)?'hiddenDiv':''}}">
	        	<label>End Date <span class="error">*</span></label>
	            {{Form::text('end_date',(isset($employment))?($employment->end_date)?date('d-m-Y',strtotime($employment->end_date)):'':'',['class'=>"form-control emp_validate datepicker ","date_en"=>'true' , "required"=>true])}}
	            <span class="error">{{$errors->first('date_since_emp')}}</span>
		    </div>
		
			
			<div class="col-md-6 form-group clear {{(isset($employment) && $employment->emp_status == 3)?'hiddenDiv':''}}">
				@if(isset($employment))
        			
    				<label>Copy of Present Footballing Employment ( Contract / Appointment Letter)<span class="error"> *</span></label>
	        		{{Form::file('present_emp_copy',["class"=>"form-control emp_validate",($employment->contract =='')?'required':'',"id"=>"present_emp","pdf"=>true])}}
		            <span class="error">{{$errors->first('present_emp_copy')}}</span>
		            <div class="col-md-4 form-group">
    					@if($employment->contract!='')<a href="{{url($employment->contract)}}" target="_blank">view current</a>@endif
    				</div>
        			
		        @else
		        
		        	<label>Copy of Present Footballing Employment ( Contract / Appointment Letter)<span class="error">*</span></label>
	        		{{Form::file('present_emp_copy',["class"=>"form-control emp_validate","required"=>true,"id"=>"present_emp","pdf"=>true])}}
		            <span class="error">{{$errors->first('present_emp_copy')}}</span>
		        @endif    
	        </div>
	        <div class="col-md-6 form-group ">
				@if(isset($employment))
    			
    				<label>Upload CV (Resume)<span class="error"> *</span></label>
	        		{{Form::file('cv',["class"=>"form-control " ,($employment->cv =='')?'required':'',"id"=>"contract","pdf"=>true])}}
		            <span class="error">{{$errors->first('cv')}}</span>
		            <div class="col-md-4 form-group">
    					@if($employment->cv!='')<a href="{{url($employment->cv)}}" target="_blank">view current</a>@endif
    				</div>
        			
		        @else
		        	<label>CV (Resume)<span class="error"> *</span></label>
	        		{{Form::file('cv',["class"=>"form-control","required"=>true,"id"=>"contract","pdf"=>true])}}
		            <span class="error">{{$errors->first('cv')}}</span>
		        @endif    
	        </div>
		</div>
		<div>
			<h3>
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
