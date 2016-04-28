
	@if(Session::has('success'))
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		{{Session::get('success')}}
	</div>
	@endif

<div class="portlet box blue">
    <div class="portlet-title"><div class="caption">Contact Details</div>
	</div>
    <div class="portlet-body form">
      	<div class="form-body">
            <div class="">
                {{ Form::open(array('url' =>'coach/updateContact',"method"=>"POST","files"=>'true','class'=>'form')) }}			        
	            <div class="row">
		        	<div class="col-md-6 form-group">
			        	<label>Alternate Email</label>
			        	{{Form::text('aemail',$coach->alternate_email,["class"=>"form-control","placeholder"=>"Alternate Email Id"])}}
			        </div>
			        <div class="col-md-6 form-group">
			        	<label>Mobile</label>
			        	{{Form::text('mobile',$coach->mobile,['required'=>'true','class'=>'form-control','placeholder'=>'Mobile'])}}
			          	<span class="error">{{$errors->first('mobile')}}</span>
			        </div>
		        </div>
		        <div class="row">
		        	<div class="col-md-6 form-group">
			        	<label>Landline</label>
			        	{{Form::text('landline',$coach->landline,['class'=>'form-control','placeholder'=>'Landline'])}}
			          	<span class="error">{{$errors->first('landline')}}</span>
			        </div>
	              	<div class="col-md-6 form-group">
	              		<label>Address Line 1</label>
	              		{{Form::text('address1',$coach->address1,['required'=>'true','class'=>'form-control','placeholder'=>'Address line 1'])}}
	              		<span class="error">{{$errors->first('address1')}}</span>
	              	</div>
	            </div>
	            <div class="row">
	            	<div class="col-md-6 form-group">
	              		<label>Address Line 2</label>
	              		{{Form::text('address2',$coach->address2,['class'=>'form-control','placeholder'=>'Address line 2'])}}
	             	</div>
	            	<div class="col-md-6 form-group">
	            		<label>City</label>
	            		{{Form::text('city',$coach->city,['class'=>'form-control','placeholder'=>'City Name'])}}
	            	</div>
	              	
	            </div>  

	            <div class="row">
	            	<div class="col-md-6 form-group">
	              		<label>Pin Code</label>
	              		{{Form::text('pincode',$coach->pincode,['class'=>'form-control','placeholder'=>'Pin Code'])}}
	              	</div>
	            	<div class="col-md-6 form-group">
		              	<label>State</label>
		              	{{Form::select('state',$state,$coach->address_state_id,['class'=>'form-control'])}}
		            </div>
	            </div>  
            </div>
        </div>
        <div class="form-actions">
        	<button type="submit" class="btn green">Submit</button>{{Form::close()}}
        </div>    
	</div>
</div>
	
	
<div class="portlet box blue ">
    <div class="portlet-title">
    	<div class="caption">
    		Passport Details
    	</div>
    </div>
    <div class="portlet-body form">
      	<div class="form-body">
            <div class="">
                {{ Form::open(array('url' =>'coach/updatePassport',"method"=>"POST","files"=>'true','class'=>'form')) }}			        
	            <div class="row">
					<div class="col-md-6 form-group">
						<label>Passport No</label>
						{{Form::text('passport_no',$coach->passport_no,["class"=>"form-control"])}}
					</div>
				    <div class="col-md-6 form-group">
				    	<label>Passport Expiry</label>
				    	{{Form::text('passport_expiry',$coach->passport_expiry,["class"=>"form-control datepicker",'placeholder'=>'Passport Expiry'])}}
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-6 form-group"> 
				        <label class="form-label">Attach Passport Copy</label>       
				        {{Form::file('passport_proof',['required'=>'true','class'=>'form-control','placeholder'=>'Attach Passport Copy'])}}
				        <span class="error">{{$errors->first('passport_proof')}}</span>
				    </div>
				</div>
            </div>
        </div>
        <div class="form-actions">
        	<button type="submit" class="btn green">Submit</button>{{Form::close()}}
        </div>    
	</div>
</div>

