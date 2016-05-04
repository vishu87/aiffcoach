<div class="row">
	<div class="col-md-9">
		<h3 class="page-title">
			@if(!isset($employment))
				Add New Employment
			@else
				{{$employment->employment}}
			@endif
		</h3>
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
<div class="portlet box blue">
    <div class="portlet-title"><div class="caption">@if(!isset($employment))Add New Employment @else Edit Employment Details @endif</div></div>
        <div class="portlet-body form">
	        {{ Form::open(array('url' =>(isset($employment))?'coach/updateEmployment/'.$employment->id:'coach/addEmployment',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}			        
          	<div class="form-body">
<<<<<<< HEAD
	          	{{ Form::open(array('url' =>(isset($employment))?'coach/updateEmployment/'.$employment->id:'coach/addEmployment',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}			        
=======
>>>>>>> eb948cfe5b8e2ad8a7667abd63e9274901dfa2be
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
					        	<label>Date Since Employed</label><span class="error"> *</span>
					            {{Form::text('date_since_emp',(isset($employment))?$employment->start_date:'',['placeholder'=>"Date Since Employed",'class'=>"form-control datepicker ","date"=>'true'])}}
					            <span class="error">{{$errors->first('date_since_emp')}}</span>
					      	</div>
					    </div>
					</div>
					<div class="row">
						<div class="col-md-6">
					      	<div class="form-group">
					        	<label>End Date</label><span class="error"> *</span>
					            {{Form::text('end_date',(isset($employment))?$employment->end_date:'',['placeholder'=>"Date Since Employed",'class'=>"form-control datepicker ","date"=>'true'])}}
					            <span class="error">{{$errors->first('date_since_emp')}}</span>
					      	</div>
					    </div>
						<div class="col-md-6 form-group">
							@if(isset($employment))
				        		<div class="row">
				        			<div class="col-md-8 form-group">
				        				<label>Copy of Present Footballing Employment Contract</label><span class="error">*</span>
						        		{{Form::file('present_emp_copy',["class"=>"form-control","id"=>"contract","pdf"=>'true'])}}
							            <span class="error">{{$errors->first('present_emp_copy')}}</span>
				        			</div>
				        			<div class="col-md-4 form-group" style="margin-top:25px;">
				        				<a href="{{url($employment->contract)}}" class="btn yellow" target="_blank">View Old Contract</a>
				        			</div>
				        		</div>
					        @else
					        	<label>Copy of Present Footballing Employment Contract</label><span class="error">*</span>
				        		{{Form::file('present_emp_copy',["class"=>"form-control","id"=>"contract","pdf"=>'true'])}}
					            <span class="error">{{$errors->first('present_emp_copy')}}</span>
					        @endif    

				        </div>
					</div>

<<<<<<< HEAD
				          
          	</div>   <div class="form-actions">
				    	<button type="submit" class="btn green">Submit</button>
				    </div>
				{{Form::close()}}     
=======
		      
          	</div>      
          	<div class="form-actions">
		    	<button type="submit" class="btn green">Submit</button>
		    </div>
			{{Form::close()}}
>>>>>>> eb948cfe5b8e2ad8a7667abd63e9274901dfa2be
    	</div>
        
    </div>
</div>
