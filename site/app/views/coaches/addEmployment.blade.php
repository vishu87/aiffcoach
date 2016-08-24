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
<div class="portlet box blue">
    <div class="portlet-title"><div class="caption">@if(!isset($employment))Add New Employment @else Edit Employment Details @endif</div></div>
        <div class="portlet-body form">
	        {{ Form::open(array('url' =>(isset($employment))?'coach/updateEmployment/'.$employment->id:'coach/addEmployment',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}			        
          	<div class="form-body">

	          	{{ Form::open(array('url' =>(isset($employment))?'coach/updateEmployment/'.$employment->id:'coach/addEmployment',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}			        

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
				            {{Form::text('date_since_emp',(isset($employment))?date('d-m-Y',strtotime($employment->start_date)):'',['required'=>'true','placeholder'=>"Date Since Employed",'class'=>"form-control datepicker ","date_en"=>'true'])}}
				            <span class="error">{{$errors->first('date_since_emp')}}</span>
				      	</div>
				    </div>
				</div>
				<div class="row">
					<div class="col-md-6">
				      	<div class="form-group ">
				        	<label>End Date</label><span class="error">*</span>
				            {{Form::text('end_date',(isset($employment))?date('d-m-Y',strtotime($employment->end_date)):'',['required'=>'true','placeholder'=>"Date Since Employed",'class'=>"form-control datepicker ","date_en"=>'true'])}}
				            <span class="error">{{$errors->first('date_since_emp')}}</span>
				      	</div>
				    </div>
					<div class="col-md-6 form-group">
						@if(isset($employment))
		        			<div class="form-group">
		        				<label>Copy of Present Footballing Employment Contract</label>
				        		{{Form::file('present_emp_copy',["class"=>"form-control","id"=>"contract","pdf"=>'true'])}}
					            <span class="error">{{$errors->first('present_emp_copy')}}</span>
					            <div class="col-md-4 form-group">
		        					<a href="{{url($employment->contract)}}" target="_blank">view current</a>
		        				</div>
		        			</div>
				        @else
				        	<label>Copy of Present Footballing Employment Contract</label><span class="error">*</span>
			        		{{Form::file('present_emp_copy',["required"=>"true","class"=>"form-control","id"=>"contract","pdf"=>'true'])}}
				            <span class="error">{{$errors->first('present_emp_copy')}}</span>
				        @endif    
			        </div>
				</div>
          	</div>      
          	<div class="form-actions">
		    	<button type="submit" class="btn green">Submit</button>
		    </div>
			{{Form::close()}}

    	</div>
        
    </div>
</div>
