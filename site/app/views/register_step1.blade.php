<div class="container">
	<div clas="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="row form-wizard">
        		@include('register_status')
			</div>
			<div class="portlet box blue">
			    <div class="portlet-title"><div class="caption">Step 1</div></div>
			        <div class="portlet-body form">
				        {{ Form::open(array('url' =>'registerStep1',"method"=>"POST","files"=>'true','class'=>'form check_form dob-validate')) }}
				        {{Form::text('id',$id,["class"=>'hidden'])}}
				          	<div class="form-body">
				          		<div class="row">
							        <div class="col-md-4">
								        <div class="form-group">
								            <label class="control-label ">First Name</label>
								              {{Form::text('first_name',(isset($data["first_name"]))?$data["first_name"]:'',['required'=>'true','placeholder'=>"First Name",'class'=>"form-control placeholder-no-fix"])}}
								              <span class="error">{{$errors->first('first_name')}}</span>
								        </div>
							        </div>
							        <div class="col-md-4">
							          <div class="form-group">
							            <label class="control-label ">Middle Name</label>
							              {{Form::text('middle_name',(isset($data["middle_name"]))?$data["middle_name"]:'',['placeholder'=>"Middle Name",'class'=>"form-control placeholder-no-fix"])}}
							              <span class="error">{{$errors->first('middle_name')}}</span>
							          </div>
							        </div>
							        <div class="col-md-4">
							          <div class="form-group">
							            <label class="control-label ">Last Name</label>
							              {{Form::text('last_name',(isset($data["last_name"]))?$data["last_name"]:'',['required'=>'true','placeholder'=>"Last Name",'class'=>"form-control placeholder-no-fix"])}}
							              <span class="error">{{$errors->first('last_name')}}</span>
							          </div>
							        </div>
							    </div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
										    <label class="control-label ">Email Id</label>
										    {{Form::text('email',(isset($data["email"]))?$data["email"]:'',['required'=>'true','placeholder'=>"Email Id",'class'=>"form-control placeholder-no-fix"])}}
										    <span class="error">{{$errors->first('username')}}</span>
										</div>
									</div>
									<div class="col-md-6">
							          <div class="form-group"> 
							            <label class="form-label">Gender</label><br>
							            {{Form::radio('gender','1',(isset($data["gender"]))?($data["gender"]==1)?$data["gender"]:'':'',['required'=>'true','placeholder'=>''])}} Male &nbsp; &nbsp; &nbsp;
							            {{Form::radio('gender','2',(isset($data["gender"]))?($data["gender"]==2)?$data["gender"]:'':'',['required'=>'true','placeholder'=>''])}} Female
							            <span class="error">{{$errors->first('gender')}}</span>
							          </div>
							        </div>
							    </div>
							    <div class="row">
							        <div class="col-md-6 form-group"><label class="form-label" style="width:100%"> DOB</label>
							           {{Form::select('day',$day,'',["class"=>"form-control","required"=>"true", "style"=>"width:90px; display:inline"])}}
							           {{Form::select('month',$months,'',["class"=>"form-control","required"=>"true", "style"=>"width:90px; display:inline"])}}
							           {{Form::select('year',$years,'',["class"=>"form-control","required"=>"true","id"=>"year", "style"=>"width:90px; display:inline"])}}
							           <span class="dob-error"></span>
							        </div>
								    <div class="col-md-6">
								        <div class="form-group"> 
								            <label class="form-label">Place of Birth</label>       
								            {{Form::text('birth_place',(isset($data["birth_place"]))?$data["birth_place"]:'',['required'=>'true','class'=>'form-control','placeholder'=>'Birth Place'])}}
								            <span class="error">{{$errors->first('birth_place')}}</span>
								        </div>
								    </div>
							        
							    </div>
							    <div class="row">
							        <div class="col-md-6">
							          <div class="form-group"> 
							            <label class="form-label">Attach DOB Proof</label>       
							            {{Form::file('dob_proof',['required'=>'true','class'=>'form-control','placeholder'=>'Attach Proof','pdf'=>'true'])}}
							              <span class="error">{{$errors->first('dob_proof')}}</span>
							          </div>
							        </div>
							        <div class="col-md-6">
							          <div class="form-group">
							            <label class="control-label ">Upload Photograph</label>
							              {{Form::file('photo',['required'=>'true','placeholder'=>"Upload Photograph",'filesize_img'=>'true','jpg'=>'true','class'=>"form-control placeholder-no-fix"])}}
							              <span class="error">{{$errors->first('photo')}}</span>

							          </div>
							        </div>
							    </div>
				          	</div>      
				          	<div class="form-actions">
				          		
						    	<button type="submit" class="btn blue">Next</button>
						    </div>
						{{Form::close()}}
			    	</div>
			    </div>
			</div>
		</div>
	</div>