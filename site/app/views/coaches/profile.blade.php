<h3 class="page-title">Profile - {{$title}}</h3>
<?php $count_main =1;?>
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
<ul class="nav nav-tabs">
	<li class="{{($profileType==1)?'active':''}}">
		<a href="{{url('coach/personalInformation')}}" >
		Personal information </a>
	</li>
	<li class="{{($profileType==2)?'active':''}}">
		<a href="{{url('coach/contactInformation')}}" >
		Contact Details</a>
	</li>
	<!-- <li class="{{($profileType==3)?'active':''}}">
		<a href="{{url('coach/passportDetails')}}" >
		Passport Details</a>
	</li> -->
	<li class="{{($profileType==5)?'active':''}}">
		<a href="{{url('coach/addDocument')}}" >
		Documents</a>
	</li>
	<li class="{{($profileType==6)?'active':''}}">
		<a href="{{url('coach/coachLicense')}}" >
		Licenses</a>
	</li>
	<li class="{{($profileType==4)?'active':''}}">
		<a href="{{url('coach/measurements')}}" >
		Measurements</a>
	</li>
</ul>
@if($profileType==1)

  	<div class="form-body">
        <div class="">
            {{ Form::open(array('url' =>'coach/updatePersonalInformation',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}
            <div class="row">
		        <div class="col-md-6 form-group">
		        	<label>Name</label>
		        	<div style="font-size:20px;">{{$coach->first_name}} {{$coach->middle_name}} {{$coach->last_name}}</div>
		        </div>
		        <div class="col-md-6 form-group">
		        	<label>Email</label>
		        	<div style="font-size:20px;">{{$CoachParameter->email}}</div>
		        </div>
	        </div>
	        <div class="row">
	        	<div class="col-md-6 form-group"><label class="form-label" style="width:100%"> DOB</label>
		           {{Form::text('dob',date('d-m-Y',strtotime($coach->dob)),["class"=>"form-control datepicker","id"=>"datepicker1","required"=>"true","date_en"=>"true"])}}
		           <span class="error"></span>
		        </div>
	        	<div class="col-md-6">
		          <div class="form-group"> 
		            <label class="form-label">Gender</label><br>
		            {{Form::radio('gender','1',(!empty($coach->gender))?($coach->gender==1)?1:'':'',['required'=>'true','placeholder'=>''])}} &nbsp;&nbsp;Male &nbsp; &nbsp; &nbsp;
		            {{Form::radio('gender','2',(!empty($coach->gender))?($coach->gender==2)?2:'':'',['required'=>'true','placeholder'=>''])}} &nbsp;&nbsp;Female
		            <span class="error">{{$errors->first('gender')}}</span>
		          </div>
		        </div>
            </div>
            <div class="row">

            	<div class="col-md-6">
            		<div class="row">
            			
		            	<div class="col-md-12 form-group">
		            		<label class="form-label">Photograph</label><br>
		            		{{Form::file('photo',["class"=>"form-control","jpg"=>true])}}
		            	</div>
		            	<div class="col-md-12 form-group">
			              	<label>State of Domicile</label>
			              	{{Form::select('state_id',$state,$coach->state_id,['class'=>'form-control',"id"=>"domicile_state"])}}
			            </div>

			            <div class="col-md-6 domicile_state clear" style="{{(isset($coach) && $coach->state_id == 37)?'':'display:none'}}">
		                  <div class="form-group"> 
		                    <label class="form-label">Country </label>       
		                    {{Form::text('domicile_country',(isset($coach))?$coach->domicile_country:'',['class'=>'form-control'])}}
		                    <span class="error">{{$errors->first('domicile_country')}}</span>
		                  </div>
		                </div>
		                <div class="col-md-6 domicile_state" style="{{(isset($coach) && $coach->state_id == 37)?'':'display:none'}}">
		                  <div class="form-group"> 
		                    <label class="form-label">State </label>       
		                    {{Form::text('domicile_state',(isset($coach))?$coach->domicile_state:'',['class'=>'form-control'])}}
		                    <span class="error">{{$errors->first('domicile_state')}}</span>
		                  </div>
		                </div>
		            	<div class="col-md-12 form-group">
		            		<label class="form-label">Association</label>
		            		{{Form::select('association_id',$associations,(isset($coach))?$coach->association_id:'',["class"=>"form-control"])}}
		            	</div>
            		</div>
            	</div>

            	<div class="col-md-3 form-group">
            		<label class="form-label">Current Photograph</label><br>
            		<img src="{{url($coach->photo)}}" style="width:100%">
            	</div>	
            </div>

            <?php $user_official_types = explode(',',Auth::user()->official_types);?>
            @if(in_array(2,$user_official_types))
            <div class="row" id="official_degree">
	            <div class="col-md-6">
	                <label>Are you a Doctor / Physiotherapist ?</label><br>
	                <label>
	                  {{Form::radio('is_doctor',1,($coach->is_doctor==1)?true:false,["id"=>"is_doctor"])}}  Yes &nbsp;&nbsp;&nbsp;
	                </label>
	                <label>{{Form::radio('is_doctor',0,($coach->is_doctor==0)?true:false,["id"=>"is_doctor"])}} No</label>
	            </div>

	            <div class="col-md-6" id="upload_degree" style="{{($coach->is_doctor==1)?'':'display:none';}}">
	                <label>Upload Degree</label>

	                {{Form::file('doctor_degree',["class"=>"form-control"])}}

	                @if($coach->doctor_degree != '')
	                	<a href="{{url($coach->doctor_degree)}}" target="_blank">View</a>
	                @endif
	            </div>
            </div>
            @endif

        </div>
    </div>
    <div class="form-actions">
    	<button type="submit" class="btn green">Submit</button>{{Form::close()}}
    </div>    
@endif
@if($profileType==2)
  	<div class="form-body">
        <div class="">
            {{ Form::open(array('url' =>'coach/updateContact',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}			        
            <div class="row">
		        <div class="col-md-6 form-group">
		        	<label>Mobile<span class="error">*</span></label>
		        	{{Form::text('mobile',$coach->mobile,['required'=>'true','class'=>'form-control','placeholder'=>'Mobile'])}}
		          	<span class="error">{{$errors->first('mobile')}}</span>
		        </div>
		        <div class="col-md-6 form-group">
		        	<label>Landline</label>
		        	{{Form::text('landline',$coach->landline,['class'=>'form-control','placeholder'=>'Landline'])}}
		          	<span class="error">{{$errors->first('landline')}}</span>
		        </div>
	        </div>
	        <div class="row">
	        	<div class="col-md-6 form-group">
		        	<label>Alternate Email</label>
		        	{{Form::email('aemail',$coach->alternate_email,["class"=>"form-control","placeholder"=>"Alternate Email Id"])}}
		        </div>
            </div>
            <h3>Address</h3>
            <div class="row">
            	<div class="col-md-6 form-group">
              		<label>Address Line 1<span class="error">*</span></label>
              		{{Form::text('address1',$coach->address1,['required'=>'true','class'=>'form-control','placeholder'=>'Address line 1'])}}
              		<span class="error">{{$errors->first('address1')}}</span>
              	</div>
            	<div class="col-md-6 form-group">
              		<label>Address Line 2</label>
              		{{Form::text('address2',$coach->address2,['class'=>'form-control','placeholder'=>'Address line 2'])}}
             	</div>
            </div>  
            <div class="row">
            	<div class="col-md-6 form-group">
            		<label>City<span class="error">*</span></label>
            		{{Form::text('city',$coach->city,['class'=>'form-control','placeholder'=>'City Name','required'=>"true"])}}
            	</div>
            	<div class="col-md-6 form-group">
              		<label>Pin Code<span class="error">*</span></label>
              		{{Form::text('pincode',$coach->pincode,['class'=>'form-control','placeholder'=>'Pin Code', 'required'=>'true'])}}
              	</div>
            	<div class="col-md-6 form-group">
	              	<label>State <span class="error">*</span></label>
	              	{{Form::select('state',$state,$coach->address_state_id,['class'=>'form-control','required'=>"true","id"=>"address_state"])}}
	            </div>

	            <div class="col-md-6 address_state clear" style="{{(isset($coach) && $coach->address_state_id == 37)?'':'display:none'}}">
                  <div class="form-group"> 
                    <label class="form-label">Country <span class="error"> *</span></label>       
                    {{Form::text('address_country',(isset($coach))?$coach->address_country:'',['required'=>'true','class'=>'form-control'])}}
                    <span class="error">{{$errors->first('address_country')}}</span>
                  </div>
                </div>
                <div class="col-md-6 address_state" style="{{(isset($coach) && $coach->address_state_id == 37)?'':'display:none'}}">
                  <div class="form-group"> 
                    <label class="form-label">State <span class="error"> *</span></label>       
                    {{Form::text('address_state',(isset($coach))?$coach->address_state:'',['required'=>'true','class'=>'form-control'])}}
                    <span class="error">{{$errors->first('address_state')}}</span>
                  </div>
                </div>
            </div>  
        </div>
    </div>
    <div class="form-actions">
    	<button type="submit" class="btn green">Submit</button>{{Form::close()}}
    </div>
@endif	
@if($profileType==3)	
<!-- <div class="portlet box blue ">
    <div class="portlet-title">
    	<div class="caption">
    		Passport Details
    	</div>
    </div>
    <div class="portlet-body form">
      	<div class="form-body">
            <div class="">
                {{ Form::open(array('url' =>'coach/updatePassport',"method"=>"POST","files"=>'true','class'=>'form check_form check_form_2')) }}
	            <div class="row">
					<div class="col-md-6 form-group">
						<label>Passport No</label><span class="error"> *</span>
						{{Form::text('passport_no',$coach->passport_no,["class"=>"form-control",'required'=>'true'])}}
					</div>
				    <div class="col-md-6 form-group">
				    	<label>Passport Expiry</label> <span class="error"> *</span>
				    	{{Form::text('passport_expiry',$coach->passport_expiry,["class"=>"form-control datepicker",'placeholder'=>'Passport Expiry','required'=>'true', 'date'=>'true'])}}
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-6 form-group"> 
				        <label class="form-label">Attach Passport Copy</label>  <span class="error"> *</span>      
				        {{Form::file('passport_proof',['class'=>'form-control','placeholder'=>'Attach Passport Copy'])}}
				        <span class="error">{{$errors->first('passport_proof')}}</span>
				    </div>
				</div>
            </div>
        </div>
        <div class="form-actions">
        	<button type="submit" class="btn green">Submit</button>
        </div>
        {{Form::close()}}
	</div>
</div> -->
@endif
@if($profileType==4)	
    <div class="form-body">
        <div class="">
            {{ Form::open(array('url' =>'coach/measurements/update',"method"=>"POST","files"=>'true','class'=>'form check_form check_form_2')) }}
            <div class="row">
				<div class="col-md-4 form-group">
					<label>Height</label>
					<div class="input-group">
						{{Form::text('height',(!empty($measurement))?$measurement->height:'',["class"=>"form-control"])}}
						<span class="input-group-addon" id="basic-addon1">(cm)</span>
						<span class="error">{{$errors->first('height')}}</span>
					</div>	
				</div>
				<div class="col-md-4 form-group">
					<label>Weight</label>
					<div class="input-group">
						{{Form::text('weight',(!empty($measurement))?$measurement->weight:'',["class"=>"form-control"])}}<span class="input-group-addon" id="basic-addon1">(Kg)</span>
						<span class="error">{{$errors->first('weight')}}</span>
					</div>
				</div>
				<div class="col-md-4 form-group">
					<label>Shoes</label>
					{{Form::text('shoes',(!empty($measurement))?$measurement->shoes:'',["class"=>"form-control"])}}
					<span class="error">{{$errors->first('shoes')}}</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 form-group">
					<label>Boots</label>
					{{Form::text('boots',(!empty($measurement))?$measurement->boots:'',["class"=>"form-control"])}}
					<span class="error">{{$errors->first('boots')}}</span>
				</div>
				<div class="col-md-4 form-group">
					<label>Sliper</label>
					{{Form::text('sliper',(!empty($measurement))?$measurement->sliper:'',["class"=>"form-control"])}}
					<span class="error">{{$errors->first('sliper')}}</span>
				</div>
				<div class="col-md-4 form-group">
					<label>Tracksuit</label>
					{{Form::text('tracksuit',(!empty($measurement))?$measurement->tracksuit:'',["class"=>"form-control"])}}
					<span class="error">{{$errors->first('tracksuit')}}</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 form-group">
					<label>Jersey</label>
					{{Form::text('jersey',(!empty($measurement))?$measurement->jersey:'',["class"=>"form-control"])}}
					<span class="error">{{$errors->first('jersey')}}</span>
				</div>
				<div class="col-md-4 form-group">
					<label>Shorts</label>
					{{Form::text('shorts',(!empty($measurement))?$measurement->shorts:'',["class"=>"form-control"])}}
					<span class="error">{{$errors->first('shorts')}}</span>
				</div>
				<div class="col-md-4 form-group">
					<label>Shirts</label>
					{{Form::text('shirts',(!empty($measurement))?$measurement->shirts:'',["class"=>"form-control"])}}
					<span class="error">{{$errors->first('shirts')}}</span>
				</div>
			</div>
        </div>
	    <div class="form-actions">
	    	<button type="submit" class="btn green">Submit</button>
	    </div>
	    {{Form::close()}}
    </div>
@endif
@if($profileType==5)	
<?php $entity_type = 2;?>

@if(isset($document))
{{ Form::open(array('url' =>'coach/addDocument/update/'.$document->id, "method"=>"POST","files"=>'true','class'=>'form check_form check_form_2')) }}
@else
{{ Form::open(array('url' =>'coach/addDocument/add', "method"=>"POST","files"=>'true','class'=>'form check_form check_form_2')) }}
@endif
  	<div class="form-body">
        <div class="">
            <div class="row" >
				<div class="col-md-4 form-group" id="document-div">
					<label>Select Document</label><span class="error">*</span>
					{{Form::select('document',$document_types,(isset($document))?$document->document_id:'',["class"=>"form-control",'required'=>'true',"id"=>"document_id"])}}
				</div>
				<div class="col-md-4 form-group"> 
			        <label class="form-label">Document Number <span class="error">*</span></label>  
			        {{Form::text('number',(isset($document))?$document->number:'',['class'=>'form-control',"required"=>true])}}
			        <span class="error">{{$errors->first('number')}}</span>
			    </div>
				<div class="col-md-4 form-group">

			        <label class="form-label">Attach Document</label> <span class="error">*</span>      
			        {{Form::file('file',['class'=>'form-control','placeholder'=>'Attach Passport Copy',(isset($document) && $document->file != '')?'':'required' ,"pdf"=>true])}}
			        
			        @if(isset($document) && $document->file != '')
			        	<a href="{{url($document->file)}}" target="_blank"> view</a>
			        @endif
			    </div>
			    <div class="col-md-4 form-group"> 
			        <label class="form-label">Issue Date</label>
			        {{Form::text('start_date',(isset($document) && $document->start_date != '')?date('d-m-Y',strtotime($document->start_date)):'',['class'=>'form-control datepicker','date_en'=>'true' ])}}
			        <span class="error">{{$errors->first('start_date')}}</span>
			    </div>
			    <div class="col-md-4 form-group"> 
			        <label class="form-label">Expiry Date</label>
			        {{Form::text('expiry',(isset($document) && $document->expiry_date != '')?date('d-m-Y',strtotime($document->expiry_date)):'',['class'=>'form-control datepicker','date_en'=>'true'])}}
			        
			    </div>
			    <div class="col-md-4 form-group">
			    	<label>Remarks</label>
			    	{{Form::text('remarks',(isset($document))?$document->remarks:'',["class"=>"form-control"])}}
			    </div>
			</div>
        </div>
    </div>
    <div class="form-actions">
    	<button type="submit" class="btn green">Submit</button>
    </div>
{{Form::close()}}

<div style="overflow-y:auto;margin-top:40px;">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>Document Name</th>
				<th>Document Number</th>
				<th>Issue Date</th>
				
				<th>#</th>
			</tr></thead>
			<tbody id="documents">
				<?php $count = 1; ?>
				@foreach($documents as $data)
					<tr id="document_{{$data->id}}">
						<td>{{$count}}</td>
						<td>{{($data->document_id==0)?$data->name:$document_types[$data->document_id]}}</td>
						<td>{{$data->number}}</td>
						<td>{{($data->start_date)?date('d-m-Y',strtotime($data->start_date)):''}}</td>
						
						<td>
							<a type="button" class="btn yellow btn-sm "  href="{{url($data->file)}}" target="_blank"> View</a>

							<button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-sm blue showApprovals hidden"><i class="fa fa-angle-double-right"></i> Details</button>

							@if($data->status != 1)
								<a type="button" class="btn yellow btn-sm " href="{{url('coach/addDocument/edit/'.$data->id)}}"><i class="fa fa-edit"></i> Edit</a>

								<button type="button" class="btn red btn-sm delete-div" div-id="document_{{$data->id}}"  action="{{'coach/addDocument/delete/'.$data->id}}"> Delete</button>

							@endif
						</td>
					</tr>
					<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
						<td colspan="5">
							<div class="row" style="">
								@if($data->check_admin())
								<div class="col-md-6">
									<?php $entity_id = $data->id;?>
									@include('approve_box')
								</div>
								@endif
								<div class="col-md-6">
									{{Approval::approval_html($entity_type, $data->id)}}
								</div>
							</div>
						</td>
					</tr>
					<?php $count++ ?>
				@endforeach
			</tbody>
	</table>
</div>
@endif
@if($profileType==6)
  	<div class="form-body">
        <div class="">
        	@if(isset($license))
            	{{ Form::open(array('url' =>'coach/coachLicense/update/'.$license->id, "method"=>"POST","files"=>'true','class'=>'form check_form')) }}
            @else
            	{{ Form::open(array('url' =>'coach/coachLicense/add', "method"=>"POST","files"=>'true','class'=>'form check_form')) }}
            @endif
	        <div class="row">
	        	<div class="col-md-6 form-group"><label class="form-label">License Name <span class="error">*</span></label>
		           {{Form::select('license_id',$licenses,(isset($license))?$license->license_id:'',["class"=>"form-control","required"=>"true" , "id" => "coach-license" , (isset($license))?'disabled':''])}}
		           <span class="error">{{$errors->first('license_id')}}</span>
		        </div>

		        <div class="col-md-6 form-group" id ="div-recc"  style="display: {{(Input::old('recc') || isset($license))?'block':'none';}}">
			        <div class="row">
			        	<div class="col-md-2" style="display: {{(isset($license) && $license->license_id != 21) ? 'none':'';}}">
			        		<label>RECC Authorised </label><br>
			        		{{Form::checkbox('recc',1,(isset($license) && $license->recc == 1)?true:false,["id" => "recc","required"=>true])}}
			        	</div>
			        	<div class="" id = "equivalent-license-div" style="display: {{(Input::old('recc') || isset($license))?'block':'none';}}" >
				        	<div class="col-md-5" style="display: {{(isset($license) && $license->license_id != 21) ? 'none':'';}}">
				        		<label>RECC Document Upload </label><br>
				        		{{Form::file('recc_document',[(isset($license) && $license->recc_document != '')?'':'required' ,"pdf"=>true])}}
				        		@if(isset($license) && $license->recc_document != '')
			            			<a href="{{url($license->recc_document)}}" target="_blank">view</a>
			            		@endif
				        	</div>

				        	<div class="col-md-5 " >
						        <div style="display: {{(isset($license) && $license->license_id != 21) ? 'none':'';}}">
						        	<label class="form-label">Equivalent License </label>
						           {{Form::select('equivalent_license_id',$licenses,(isset($license))?$license->equivalent_license_id:'',["class"=>"form-control" ,"id" => "equivalent_licenses","required"=>true])}}
						           <span class="error">{{$errors->first('equivalent_license_id')}}</span>
						        </div>
			        		</div>
			        		
			        	</div>
			        </div>
			    </div>
	        	<div class="col-md-6 clear">
		          <div class="form-group"> 
		            <label class="form-label">License Number <span class="error">*</span></label><br>
		            {{Form::text('number',(isset($license))?$license->number:'',["class"=>"form-control",'required'=>'true'])}}
		            <span class="error">{{$errors->first('number')}}</span>
		          </div>
		        </div>
		        <div class="col-md-6 ">
		          <div class="form-group"> 
		            <label class="form-label">Issue Date <span class="error">*</span></label><br>
		            {{Form::text('start_date',(isset($license) && $license->start_date != '')?date('d-m-Y',strtotime($license->start_date)):'',["class"=>"form-control datepicker",'required'=>'true',"date_en"=>"true"])}}
		            <span class="error">{{$errors->first('start_date')}}</span>
		          </div>
		        </div>
		        <div class="col-md-6">
		          <div class="form-group"> 
		            <label class="form-label">End Date</label><br>
		            {{Form::text('end_date',(isset($license) && $license->end_date != '')?date('d-m-Y',strtotime($license->end_date)):'',["class"=>"form-control datepicker","date_en"=>"true"])}}
		            <span class="error">{{$errors->first('end_date')}}</span>
		          </div>
		        </div>
            	<div class="col-md-6 form-group ">
            		<label class="form-label">Document Copy <span class="error">*</span></label><br>
            		{{Form::file('document',["class"=>"form-control",(isset($license) && $license->document != '')?'':'required' ,"pdf"=>true])}}

            		@if(isset($license) && $license->document != '')
            			<a href="{{url($license->document)}}" target="_blank">view</a>
            		@endif
            	</div>	
            </div>
        </div>
    </div>
    <div class="form-actions">
    	<button type="submit" class="btn green">Submit</button>{{Form::close()}}
    </div>

    @if(sizeof($coachLicense)>0)
    <div style="overflow-y:auto;margin-top:40px;">
		<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th style="width:50px">SN</th>
					<th>License Name</th>
					<th>License Number</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Manage</th>
				</tr>
			</thead>
			<tbody id="licenses">
				<?php $count = 1; ?>
				@foreach($coachLicense as $data)
				<tr id="document_{{$data->id}}">
					<td>{{$count}}</td>
					<td>{{$data->license_name}} 
						{{($data->recc == 1)?"<br>($data->equivalent_license)":''}}
					</td>
					<td>{{$data->number}}</td>
					<td>{{date('d-m-Y',strtotime($data->start_date))}}</td>
					<td>{{($data->end_date)?date('d-m-Y',strtotime($data->end_date)):''}}</td>
					<td>
						@if($data->document != '')
							<a type="button" class="btn yellow btn-sm "  href="{{url($data->document)}}" target="_blank"> <i class="fa fa-cube"></i> View</a>
						@endif

						
						<a type="button" class="btn yellow btn-sm" href="{{url('coach/coachLicense/edit/'.$data->id)}}"> <i class="fa fa-edit"></i> Edit</a>
						@if($data->status == 0)

							<button type="button" class="btn red btn-sm delete-div" div-id="document_{{$data->id}}"  action="{{'coach/coachLicense/delete/'.$data->id}}"> <i class="fa fa-remove"></i> Delete</button>
						@endif
					</td>
				</tr>
				<?php $count++ ?>
				@endforeach
			</tbody>
		</table>
	</div>  
	@else
	<div class="alert alert-warning" style="margin-top:20px;">
		No License found
	</div>
	@endif  
@endif