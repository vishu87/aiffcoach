<div class="container">
  <div clas="row">
    <div class="col-md-8 col-md-offset-2">

      <div class="row form-wizard">

        @include('register_status')
        
      </div>
      {{ Form::open(array('url' =>'registerStep3',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}
        {{Form::text('id',(isset($id))?$id:'',["class"=>'hidden'])}}

      <div class="portlet box blue">
        <div class="portlet-title"><div class="caption">Step 3</div></div>
        <div class="portlet-body form">             
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group"> 
                  <label class="form-label">Registration For <span class="error">*</span></label>
                  {{Form::select('official_types',$official_types,(isset($data->official_types))?$data->official_types:'',['required'=>'true','class'=>'form-control',"id"=>"registration_for"])}}
                    <span class="error">{{$errors->first('official_types')}}</span>
                </div>
              </div>
              
            </div>
            <div class="row" id="license_data" style="(isset($data->official_types) && $data->official_types == 1)?'':'display:none' " >
              <div class="col-md-12">
                
              </div>
              
              <h4 style="padding: 0 15px;font-weight: 400">
                License Details
                <span style="font-size:12px;">
                  You must upload one of the following licenses to register
                </span>
              </h4>
              <?php
                $types = ["" => "Select"] + License::lists("name", "id");
              ?>
              <div class="col-md-3">
                <div class="form-group"> 
                  <label class="form-label">License Type <span class="error">*</span></label>
                  {{Form::select('license_id',$types,(isset($data->license_id))?$data->license_id:'',['required'=>'true','class'=>'form-control', 'id' => 'coach-license'])}}
                    <span class="error">{{$errors->first('start_date')}}</span>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-group"> 
                  <label class="form-label">Start Date <span class="error">*</span></label>
                  {{Form::text('start_date',(isset($data->start_date))?date('d-m-Y',strtotime($data->start_date)):'',['required'=>'true','class'=>'form-control  datepicker' ,"date_en"=>true ,'placeholder'=>'License start date'])}}
                    <span class="error">{{$errors->first('start_date')}}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group"> 
                  <label class="form-label">License Number <span class="error">*</span></label>
                  {{Form::text('license_number',(isset($data->license_number))?$data->license_number:'',['required'=>'true','class'=>'form-control' ,'placeholder'=>'Enter License Number'])}}
                    <span class="error">{{$errors->first('license_number')}}</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6 form-group" id ="div-recc"  style="display: {{(Input::old('recc'))?'block':'none';}}">
                    <div class="row">
                      <div class="col-md-4">
                        <label>RECC Authorised ?</label><br>
                        {{Form::checkbox('recc',1,'',["id" => "recc","required"=>true])}}
                      </div>
                      <div id = "equivalent-license-div" style="display: {{(Input::old('recc'))?'block':'none';}}">
                        
                        <div class="col-md-8" style="display: 'none'">
                          <label>RECC Document Upload <span class="error">*</span></label><br>
                          {{Form::file('recc_document',["class" => "form-control","id"=>"recc_document","required"=>true,"pdf"=>"true"])}}
                        </div>
                        <div class="col-md-12 " >
                          <label class="form-label">Equivalent License </label>
                           {{Form::select('equivalent_license_id',$types,'',["class"=>"form-control" ,"id" => "equivalent_licenses","required"=>true])}}
                           <span class="error">{{$errors->first('equivalent_license_id')}}</span>
                          
                        </div>
                      </div> 
                    </div>
                  </div>
               
                  <div class="col-md-6">
                    <div class="form-group"> 
                      <label class="form-label">Upload License <span class="error">*</span></label>
                      {{Form::file('license',['class'=>'form-control', 'required' => 'true',"pdf"=>"true"])}}
                        <span class="error">{{$errors->first('license')}}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <h4 style="padding: 0 15px;font-weight: 400">Employment Details <span style="font-size: 12px">Write about your employment</span></h4>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Employment Status</label><span class="error"> *</span>
                    
                      {{Form::select('employment_status',$emp_status,(isset($data))?$data->emp_status:'',['required'=>'true','class'=>"form-control " , "id" => "emp_status"])}}
                      <span class="error">{{$errors->first('employment_status')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Organization</label><span class="error"> *</span>
                    
                      {{Form::text('present_emp',(isset($data))?$data->employment:'',['required'=>'true','placeholder'=>"Present Football Employment",'class'=>"form-control emp_validate"])}}
                      <span class="error">{{$errors->first('present_emp')}}</span>
                  </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Date Since Employed</label><span class="error"> *</span>
                        {{Form::text('date_since_emp',(isset($data))?date('d-m-Y',strtotime($data->start_date)):'',['required'=>'true','class'=>"form-control datepicker emp_validate ","date_en"=>'true'])}}
                        <span class="error">{{$errors->first('date_since_emp')}}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                      <label>End Date</label>
                        {{Form::text('end_date',(isset($data))?($data->end_date)?date('d-m-Y',strtotime($data->end_date)):'':'',['class'=>"form-control emp_validate datepicker ","date_en"=>'true'])}}
                        <span class="error">{{$errors->first('date_since_emp')}}</span>
                    </div>
                </div>
                <div class="col-md-6 form-group clear">
                @if(isset($data))
                      <div class="form-group">
                        <label>Copy of Present Footballing Employment Contract <span class="error"> *</span></label>
                        {{Form::file('present_emp_copy',["class"=>"form-control emp_validate",($data->contract =='')?'required':'',"pdf"=>"true"])}}
                          <span class="error">{{$errors->first('present_emp_copy')}}</span>
                          <div class="col-md-4 form-group">
                          @if($data->contract!='')<a href="{{url($data->contract)}}" target="_blank">view current</a>@endif
                        </div>
                      </div>
                    @else
                      <label>Copy of Present Footballing Employment Contract <span class="error">*</span></label>
                      {{Form::file('present_emp_copy',["class"=>"form-control emp_validate","required"=>true,"id"=>"present_emp","pdf"=>"true"])}}
                        <span class="error">{{$errors->first('present_emp_copy')}}</span>
                    @endif    
                  </div>
                <div class="col-md-6 form-group">
                @if(isset($data))
                      <div class="form-group">
                        <label>Upload CV (Resume)<span class="error"> *</span></label>
                        {{Form::file('cv',["class"=>"form-control" ,($data->cv =='')?'required':'',"pdf"=>"true"])}}
                          <span class="error">{{$errors->first('cv')}}</span>
                          <div class="col-md-4 form-group">
                          @if($data->cv!='')<a href="{{url($data->cv)}}" target="_blank">view current</a>@endif
                        </div>
                      </div>
                    @else
                      <label>CV (Resume)<span class="error"> *</span></label>
                      {{Form::file('cv',["class"=>"form-control","required"=>true,"id"=>"contract","pdf"=>"true"])}}
                        <span class="error">{{$errors->first('cv')}}</span>
                    @endif    
                </div>

                
            </div>
            <div>
              <h4>
                Referral Details
              </h4>
            </div>

            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Name</label><span class="error"> *</span>
                    
                      {{Form::text('referral_name',(isset($data))?$data->referral_name:'',['required'=>'true','placeholder'=>"Referral Name",'class'=>"form-control "])}}
                      <span class="error">{{$errors->first('referral_name')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Contact Number</label><span class="error"> *</span>
                    
                      {{Form::text('referral_contact',(isset($data))?$data->referral_contact:'',['required'=>'true','class'=>"form-control " ,'placeholder'=>"Contact Number"])}}
                      <span class="error">{{$errors->first('referral_contact')}}</span>
                  </div>
                </div>
            </div>
            <div class="row">
              <h4 style="padding: 0 15px;font-weight: 400">Passport Details</h4>
              <div class="col-md-6">
                <div class="form-group"> 
                  <label class="form-label">Passport No</label>       
                  {{Form::text('passport',(isset($data->passport))?$data->passport:'',['class'=>'form-control','placeholder'=>'Passport No'])}}
                    <span class="error">{{$errors->first('passport')}}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group"> 
                  <label class="form-label">Passport Expiry</label>       
                  {{Form::text('passport_expiry',(isset($data->passport_expiry))?$data->passport_expiry:'',['class'=>'form-control datepicker',"date_en"=>'true','placeholder'=>'Passport Expiry'])}}
                    <span class="error">{{$errors->first('passport_expiry')}}</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group"> 
                  <label class="form-label">Attach Passport Copy</label>       
                  {{Form::file('passport_proof',['class'=>'form-control','placeholder'=>'Attach Passport Copy',"pdf"=>"true"])}}
                    <span class="error">{{$errors->first('passport_proof')}}</span>
                </div>
              </div>
            </div>   
          </div>      
          <div class="form-actions">
                <a href="{{url('/registerStep2/'.$id)}}" class="btn blue pull-left"> Previous</a>
            <button type="submit" class="btn blue pull-right">Confirm</button>
          </div>
          
        </div>
      </div>
    </div>  
  </div>
</div>  