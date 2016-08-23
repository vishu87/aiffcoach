<div class="container">
  <div clas="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="row form-wizard">
        @include('register_status')
      </div>
      <div class="portlet box blue">
        <div class="portlet-title">
          <div class="caption">Step 2</div>
        </div>
        <div class="portlet-body form">
          <div class="form-body">
            {{ Form::open(array('url' =>'registerStep2',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}
            {{Form::hidden('id',(isset($id))?$id:'')}}
            <div class="row">
              <div class="col-md-12">
                <div class="form-group"> 
                  <label class="form-label">State of Domicile*</label>       
                  {{Form::select('state_id',$state,(isset($data["state_id"]))?$data["state_id"]:'',['required'=>'true','class'=>'form-control','placeholder'=>'State of Registration'])}}
                  <span class="error">{{$errors->first('state_id')}}</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group"> 
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label class="form-label">Address Line 1*</label>                      
                      {{Form::text('address1',(isset($data["address1"]))?$data["address1"]:'',['required'=>'true','class'=>'form-control','placeholder'=>'Address line 1'])}}
                      <span class="error">{{$errors->first('address1')}}</span>
                    </div>
                    
                    <div class="col-md-6 form-group">
                      <label class="form-label">Address Line 2</label>
                      {{Form::text('address2',(isset($data["address2"]))?$data["address2"]:'',['class'=>'form-control','placeholder'=>'Address line 2'])}}
                    </div>
                    
                    <div class="col-md-6 form-group clear">
                      <label class="form-label">City* </label>
                      {{Form::text('city',(isset($data["city"]))?$data["city"]:'',['class'=>'form-control','placeholder'=>'City Name'])}}
                    </div>
                    
                    <div class="col-md-6 form-group">
                      <label class="form-label">Pincode* </label>
                      {{Form::text('pincode',(isset($data["pincode"]))?$data["pincode"]:'',['class'=>'form-control','placeholder'=>'Pin Code'])}}
                    </div>
                    
                    <div class="col-md-6 form-group">
                      <label class="form-label">State* </label>
                      {{Form::select('state',$state,(isset($data["state"]))?$data["state"]:'',['class'=>'form-control'])}}
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">    
                <div class="form-group"> 
                     
                  <div class="row">
                    <div class="col-md-6">
                      <label class="form-label">Mobile/Phone*</label>
                      {{Form::text('mobile',(isset($data["mobile"]))?$data["mobile"]:'',['required'=>'true','class'=>'form-control','placeholder'=>'Mobile'])}}
                    <span class="error">{{$errors->first('mobile')}}</span>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Landline</label>{{Form::text('landline',(isset($data["landline"]))?$data["landline"]:'',['class'=>'form-control','placeholder'=>'Landline'])}}
                    <span class="error">{{$errors->first('landline')}}</span>
                    </div>
                  
                  </div>
                  
                </div>
              </div>
            </div>
          </div>    
          <div class="form-actions">
            <a href="{{url('/registerStep1/'.$id)}}" class="btn blue pull-left"> previous</a>
            <button type="submit" class="btn blue pull-right">Next</button>
          </div>
          {{Form::close()}}

        </div>
      </div>
      </div>
    </div>
  </div>
</div>
