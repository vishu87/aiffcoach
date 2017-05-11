

<div class="portlet box blue">
    <div class="portlet-title"><div class="caption">Complete Your Employment {{Auth::User()->status}}</div></div>
        <div class="portlet-body form">
          	<div class="form-body">
	           
	                {{ Form::open(array('url' =>'coach/postEmployment',"method"=>"POST","files"=>'true','class'=>'check_form')) }}
	                <div class="row">
	                	<div class="col-md-6">
				            <div class="form-group">
				                <label>Present Football Employment</label><span class="error"> *</span>
				            
				                {{Form::text('present_emp','',['required'=>'true','placeholder'=>"Present Football Employment",'class'=>"form-control "])}}
				                <span class="error">{{$errors->first('present_emp')}}</span>
				            </div>
				        </div>
				        <div class="col-md-6">
				          	<div class="form-group">
				            	<label>Date Since Employed</label><span class="error"> *</span>
				            
					            {{Form::text('date_since_emp','',['placeholder'=>"Date Since Employed",'class'=>"form-control datepicker ","date"=>'true'])}}
					            <span class="error">{{$errors->first('date_since_emp')}}</span>
			            
				          	</div>
				        </div>
	                </div>
	                
				          	
	            	<label>Last Five Employment</label>
	            	<div class="row">
	            		<div class="col-md-6 form-group">{{Form::text('emp_name[]','',['placeholder'=>"Employment Name",'class'=>"form-control "])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('start_date[]','',['placeholder'=>"Start Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('end_date[]','',['placeholder'=>"End Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            	</div>
	            	<div class="row">
	            		<div class="col-md-6 form-group">{{Form::text('emp_name[]','',['placeholder'=>"Employment Name",'class'=>"form-control "])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('start_date[]','',['placeholder'=>"Start Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('end_date[]','',['placeholder'=>"End Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            	</div>
	            	<div class="row">
	            		<div class="col-md-6 form-group">{{Form::text('emp_name[]','',['placeholder'=>"Employment Name",'class'=>"form-control "])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('start_date[]','',['placeholder'=>"Start Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('end_date[]','',['placeholder'=>"End Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            	</div>
	            	<div class="row">
	            		<div class="col-md-6 form-group">{{Form::text('emp_name[]','',['placeholder'=>"Employment Name",'class'=>"form-control "])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('start_date[]','',['placeholder'=>"Start Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('end_date[]','',['placeholder'=>"End Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            	</div>
	            	<div class="row">
	            		<div class="col-md-6 form-group">{{Form::text('emp_name[]','',['placeholder'=>"Employment Name",'class'=>"form-control "])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('start_date[]','',['placeholder'=>"Start Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            		<div class="col-md-3 form-group">{{Form::text('end_date[]','',['placeholder'=>"End Date",'class'=>"form-control  datepicker","date"=>'true'])}}</div>
	            	</div>
	            	
				           

				      
	                <div class="row">
		                <div class="col-md-6 form-group">
				        	<label>Present AFC/AIFF Certificate No</label><span class="error"> *</span>
				        	{{Form::text('aiff_certificate','',["class"=>"form-control"])}}
				        </div>
				         <div class="col-md-6 form-group">
				        	<label>Attach Proof Copy</label><span class="error"> *</span>
				        	{{Form::file('aiff_certificate_copy',["class"=>"form-control","pdf"=>true])}}
				        </div>
	                </div>
	                <div class="row">
	                	<div class="col-md-6 form-group">
				        	<label>Date of Completion of last AFC Coaching Licence</label><span class="error"> *</span>
				        	{{Form::text('last_afc_date','',["class"=>"form-control datepicker","date"=>'true'])}}
				        </div>
				        <div class="col-md-6 form-group">
				        	<label>Copy of Latest AFC/AIFF Certificate</label><span class="error"> *</span>
				        	{{Form::file('aiff_latest_copy',["class"=>"form-control","pdf"=>true])}}
				        </div>
	                </div>
	                <div class="row">
		                <div class="col-md-6 form-group">
				        	<label>Copy of Present Footballing Employment Contract</label><span class="error"> *</span>
				        	{{Form::file('present_emp_copy',["class"=>"form-control","pdf"=>true])}}
				        </div>
	                </div>
        
		   
	        </div>
	        <div class="form-actions">
	        	<button type="submit" class="btn green">Submit</button>{{Form::close()}}
	        </div>    
    	</div>
        
    </div>
</div>