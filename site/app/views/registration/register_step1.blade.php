<div class="container">
	<div clas="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="row form-wizard">
        		@include('register_status')
			</div>
			<div class="row hidden">
				<div class="col-md-12">
					<span style="font-size:13px;">Documents required during registrations -</span>
					<ol>
						<li>Date of birth proof (PDF format) - Mandatory</li>
						<li>Recent Photograph (jpeg format) - Mandatory</li>
						<li>Copy of C/D Licence (pdf format) - Mandatory</li>
						<li>Passport (pdf format) - Optional</li>
					</ol>
				</div>
			</div>
			<div class="portlet box blue">
			    <div class="portlet-title"><div class="caption">Step 1</div></div>
			        <div class="portlet-body form">
				        {{ Form::open(array('url' =>'registerStep1',"method"=>"POST","files"=>'true','class'=>'form check_form dob-validate')) }}
				        {{Form::text('id',$id,["class"=>'hidden'])}}
				          	<div class="form-body">
				          		<div class="row">
				          			<div class="col-md-12">
				          				<span class="error">Please fill your name as per your date of birth certificate</span>
				          			</div>
				          		</div>
				          		<div class="row">
							        <div class="col-md-4">
								        <div class="form-group">
								            <label class="control-label">First Name <span class="error"> *</span></label>
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
							            <label class="control-label ">Last Name <span class="error"> *</span></label>
							              {{Form::text('last_name',(isset($data["last_name"]))?$data["last_name"]:'',['required'=>'true','placeholder'=>"Last Name",'class'=>"form-control placeholder-no-fix"])}}
							              <span class="error">{{$errors->first('last_name')}}</span>
							          </div>
							        </div>
							    </div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
										    <label class="control-label ">Email Id <span class="error"> *</span></label>
										    {{Form::text('email',(isset($data["email"]))?$data["email"]:'',['required'=>'true','placeholder'=>"Email Id",'class'=>"form-control placeholder-no-fix"])}}
										    <span class="error">{{$errors->first('username')}}</span>
										</div>
									</div>
									<div class="col-md-6">
							          <div class="form-group"> 
							            <label class="form-label">Gender <span class="error"> *</span></label><br>
							            {{Form::radio('gender','1',(isset($data["gender"]))?($data["gender"]==1)?$data["gender"]:'':'',['required'=>'true','placeholder'=>''])}} Male &nbsp; &nbsp; &nbsp;
							            {{Form::radio('gender','2',(isset($data["gender"]))?($data["gender"]==2)?$data["gender"]:'':'',['required'=>'true','placeholder'=>''])}} Female
							            <span class="error">{{$errors->first('gender')}}</span>
							          </div>
							        </div>
							    </div>
							    <div class="row">
							        <div class="col-md-6 form-group">
							        	<label class="form-label" style="width:100%"> DOB <span class="error"> *</span></label>
							        	{{Form::text('dob',(isset($data["dob"]))?date('d-m-Y',strtotime($data["dob"])):'',["class"=>"form-control datepicker","date_en"=>"true","required"=>"true"])}}
							          <span class="dob-error"></span>
							        </div>
								    <div class="col-md-6">
								        <div class="form-group"> 
								            <label class="form-label">Place of Birth <span class="error"> *</span></label>       
								            {{Form::text('birth_place',(isset($data["birth_place"]))?$data["birth_place"]:'',['required'=>'true','class'=>'form-control','placeholder'=>'Birth Place'])}}
								            <span class="error">{{$errors->first('birth_place')}}</span>
								        </div>
								    </div>
							        
							    </div>
							    <div class="row">
							        <div class="col-md-6">
							          <div class="form-group"> 
							            <label class="form-label">Attach DOB Proof @if(!isset($data["dob_proof"]))<span class="error"> *</span>@endif</label>       
							            {{Form::file('dob_proof',['class'=>'form-control','placeholder'=>'Attach Proof',(!isset($data['dob_proof']))?'required':'',"pdf"=>"true"])}}
							              <span class="error">{{$errors->first('dob_proof')}}</span>
								          @if(isset($data["dob_proof"]))
								          	<div><a target="_blank" href="{{url($data['dob_proof'])}}">view current</a></div>
								          @endif
							          </div>
							        </div>
							        <div class="col-md-6">
							          <div class="form-group">
							            <label class="control-label ">Upload Photograph @if(!isset($data["photo"]))<span class="error"> *</span>@endif</label>
							              {{Form::file('photo',[(!isset($data['photo']))?'required':'','placeholder'=>"Upload Photograph",'filesize_img'=>'true','jpg'=>'true','class'=>"form-control placeholder-no-fix"])}}
							              <span class="error">{{$errors->first('photo')}}</span>
										@if(isset($data["photo"]))
								          	<div><a target="_blank" href="{{url($data['photo'])}}">view current</a></div>
								          @endif
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