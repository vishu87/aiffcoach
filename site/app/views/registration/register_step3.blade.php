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
                  {{Form::select('official_types',$official_types,(isset($data->official_types))?$data->official_types:'',['required'=>'true','class'=>'form-control'])}}
                    <span class="error">{{$errors->first('official_types')}}</span>
                </div>
              </div>
              
            </div>
            <div class="row">
              <h4 style="padding: 0 15px;font-weight: 400">D License Details</h4>
              
              <div class="col-md-6">
                <div class="form-group"> 
                  <label class="form-label">Start Date <span class="error">*</span></label>
                  {{Form::text('start_date',(isset($data->start_date))?date('d-m-Y',strtotime($data->start_date)):'',['required'=>'true','class'=>'form-control  datepicker' ,"date_en"=>true ,'placeholder'=>'License start date'])}}
                    <span class="error">{{$errors->first('start_date')}}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group"> 
                  <label class="form-label">End Date </label>
                  {{Form::text('end_date',(isset($data->end_date))?date('d-m-Y',strtotime($data->end_date)):'',['class'=>'form-control  datepicker' ,"date_en"=>true ,'placeholder'=>'license expiry if any'])}}
                    <span class="error">{{$errors->first('end_date')}}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group"> 
                  <label class="form-label">License Number<span class="error">*</span></label>
                  {{Form::text('license_number',(isset($data->license_number))?$data->license_number:'',['required'=>'true','class'=>'form-control' ,'placeholder'=>'Enter License Number'])}}
                    <span class="error">{{$errors->first('license_number')}}</span>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group"> 
                  <label class="form-label">Upload D-License </label>
                  {{Form::file('d_licence',['class'=>'form-control'])}}
                    <span class="error">{{$errors->first('d_licence')}}</span>
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
                  {{Form::file('passport_proof',['class'=>'form-control','placeholder'=>'Attach Passport Copy'])}}
                    <span class="error">{{$errors->first('passport_proof')}}</span>
                </div>
              </div>
            </div>   
          </div>      
          <div class="form-actions">
                <a href="{{url('/registerStep2/'.$id)}}" class="btn blue pull-left"> previous</a>
            <button type="submit" class="btn blue pull-right">Confirm</button>
          </div>
          
        </div>
      </div>
    </div>  
  </div>
</div>  