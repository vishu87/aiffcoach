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
		           <span class="dob-error"></span>
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
            	<div class="col-md-6 form-group">
            		<label class="form-label">Photograph</label><br>
            		{{Form::file('photo',["class"=>"form-control"])}}
            	</div>
            	<div class="col-md-3 form-group">
            		<label class="form-label">Current Photograph</label><br>
            		<img src="{{url($coach->photo)}}" style="width:100%">
            	</div>	
            </div>
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
            	<div class="col-md-4 form-group">
            		<label>City<span class="error">*</span></label>
            		{{Form::text('city',$coach->city,['class'=>'form-control','placeholder'=>'City Name','required'=>"true"])}}
            	</div>
            	<div class="col-md-4 form-group">
              		<label>Pin Code<span class="error">*</span></label>
              		{{Form::text('pincode',$coach->pincode,['class'=>'form-control','placeholder'=>'Pin Code', 'required'=>'true'])}}
              	</div>
            	<div class="col-md-4 form-group">
	              	<label>State <span class="error">*</span></label>
	              	{{Form::select('state',$state,$coach->address_state_id,['class'=>'form-control','required'=>"true"])}}
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
				        {{Form::file('passport_proof',['class'=>'form-control','placeholder'=>'Attach Passport Copy','pdf'=>'true'])}}
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
<div class="portlet box blue ">
    <div class="portlet-title">
    	<div class="caption">
    		Add Document
    	</div>
    </div>
    <div class="portlet-body form">
      	<div class="form-body">
            <div class="">
                {{ Form::open(array('url' =>'coach/addDocument/add',"method"=>"POST","files"=>'true','class'=>'form check_form check_form_2')) }}
	            <div class="row" >
					<div class="col-md-4 form-group" id="document-div">
						<label>Select Document</label><span class="error">*</span>
						{{Form::select('document',$document_types,'',["class"=>"form-control",'required'=>'true',"id"=>"document_id"])}}
					</div>
					<div class="col-md-4 form-group"> 
				        <label class="form-label">Document Number</label>   <span class="error">*</span>    
				        {{Form::text('number','',['class'=>'form-control','required'=>'true'])}}
				        <span class="error">{{$errors->first('number')}}</span>
				    </div>
					<div class="col-md-4 form-group"> 
				        <label class="form-label">Attach Document</label> <span class="error">*</span>      
				        {{Form::file('file',['class'=>'form-control','placeholder'=>'Attach Passport Copy','pdf'=>'true','required'=>'true'])}}
				        
				    </div>
				    <div class="col-md-4 form-group"> 
				        <label class="form-label">Start Date</label>   <span class="error">*</span>    
				        {{Form::text('start_date','',['class'=>'form-control datepicker','date_en'=>'true' , 'required'=>'true'])}}
				        <span class="error">{{$errors->first('start_date')}}</span>
				    </div>
				    <div class="col-md-4 form-group"> 
				        <label class="form-label">Expiry Date</label>
				        {{Form::text('expiry','',['class'=>'form-control datepicker','date_en'=>'true'])}}
				        
				    </div>
				    <div class="col-md-4 form-group">
				    	<label>Remarks</label>
				    	{{Form::text('remarks','',["class"=>"form-control"])}}
				    </div>
				</div>
            </div>
        </div>
        <div class="form-actions">
        	<button type="submit" class="btn green">Submit</button>
        </div>
        {{Form::close()}}
	</div>
</div>
<div style="overflow-y:auto;margin-top:40px;">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>Document Name</th>
				<th>Document Number</th>
				<th>Start Date</th>
				<th>Status</th>
				<th>#</th>
			</tr></thead>
			<tbody id="documents">
				<?php $count = 1; ?>
				@foreach($documents as $data)
					<tr id="document_{{$data->id}}">
						<td>{{$count}}</td>
						<td>{{($data->document_id==0)?$data->name:$document_types[$data->document_id]}}</td>
						<td>{{$data->number}}</td>
						<td>{{date('d-m-Y',strtotime($data->expiry_date))}}</td>
						<td>{{$ApprovalStatus[$data->status]}}</td>
						<td>
							<a type="button" class="btn yellow btn-sm "  href="{{url($data->file)}}" target="_blank"> View</a>

							<button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-sm blue showApprovals"><i class="fa fa-angle-double-right"></i> Details</button>

							@if($data->status != 1)
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
            {{ Form::open(array('url' =>'coach/coachLicense/add',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}
	        <div class="row">
	        	<div class="col-md-6 form-group"><label class="form-label">License Name <span class="error">*</span></label>
		           {{Form::select('license_id',$licenses,'',["class"=>"form-control","required"=>"true"])}}
		           <span class="dob-error">{{$errors->first('license_id')}}</span>
		        </div>
	        	<div class="col-md-6">
		          <div class="form-group"> 
		            <label class="form-label">License Number <span class="error">*</span></label><br>
		            {{Form::text('number','',["class"=>"form-control",'required'=>'true'])}}
		            <span class="error">{{$errors->first('number')}}</span>
		          </div>
		        </div>
		        <div class="col-md-6 clear">
		          <div class="form-group"> 
		            <label class="form-label">Start Date <span class="error">*</span></label><br>
		            {{Form::text('start_date','',["class"=>"form-control datepicker",'required'=>'true',"date_en"=>"true"])}}
		            <span class="error">{{$errors->first('start_date')}}</span>
		          </div>
		        </div>
		        <div class="col-md-6">
		          <div class="form-group"> 
		            <label class="form-label">End Date</label><br>
		            {{Form::text('end_date','',["class"=>"form-control datepicker","date_en"=>"true"])}}
		            <span class="error">{{$errors->first('end_date')}}</span>
		          </div>
		        </div>
            	<div class="col-md-6 form-group clear">
            		<label class="form-label">Document Copy</label><br>
            		{{Form::file('document',["class"=>"form-control"])}}
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
					<th>#</th>
				</tr>
			</thead>
			<tbody id="licenses">
				<?php $count = 1; ?>
				@foreach($coachLicense as $data)
				<tr id="document_{{$data->id}}">
					<td>{{$count}}</td>
					<td>{{$data->license_name}}</td>
					<td>{{$data->number}}</td>
					<td>{{date('d-m-Y',strtotime($data->start_date))}}</td>
					<td>{{date('d-m-Y',strtotime($data->end_date))}}</td>
					<td>
						@if($data->document!='')
							<a type="button" class="btn yellow btn-sm "  href="{{url($data->document)}}" target="_blank"> <i class="fa fa-cube"></i> View</a>
						@else
						
						@endif	

						<button type="button" class="btn red btn-sm delete-div" div-id="document_{{$data->id}}"  action="{{'coach/coachLicense/delete/'.$data->id}}"> <i class="fa fa-remove"></i> Delete</button>
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