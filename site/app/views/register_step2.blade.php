<div class="container">
<div clas="row">
<div class="col-md-8 col-md-offset-2">
<div class="row form-wizard">
  <div class="col-md-12">
    <ul class="nav nav-pills nav-justified steps">
        <li class="done">
          <a href="#tab2" data-toggle="tab" class="step">
          <span class="number">
          1 </span>
          <span class="desc">
          <i class="fa fa-check"></i> Registration Details</span>
          </a>
        </li>
        <li class="active">
          <a href="#tab3" data-toggle="tab" class="step active">
          <span class="number">
          2 </span>
          <span class="desc">
          <i class="fa fa-check"></i> Contact Details </span>
          </a>
        </li>
        <li>
          <a href="#tab4" data-toggle="tab" class="step">
          <span class="number">
          3 </span>
          <span class="desc">
          <i class="fa fa-check"></i> Confirm </span>
          </a>
        </li>
      </ul>
      <div id="bar" class="progress progress-striped" role="progressbar">
        <div class="progress-bar progress-bar-success" style="width:67.5%;">
        </div>
      </div>
  </div>
  
</div>
<div class="portlet box blue">
    <div class="portlet-title">
      <div class="caption">Registration & Contact Details</div>
    </div>
          

    <div class="portlet-body form">
      <div class="form-body">
        {{ Form::open(array('url' =>'registerStep2',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}      {{Form::text('id',(isset($id))?$id:'',["class"=>'hidden'])}}
        <div class="row">
          <div class="col-md-12">
            <div class="form-group"> 
              <label class="form-label">State of Registration</label>       
              {{Form::select('state_reg',$state,(isset($data["state_reg"]))?$data["state_reg"]:'',['class'=>'form-control'])}}
                <span class="error">{{$errors->first('state_reg')}}</span>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group"> 
              <label class="form-label">State Reference</label>       
              {{Form::select('state_reference',$state,(isset($data["state_reference"]))?$data["state_reference"]:'',['required'=>'true','class'=>'form-control','placeholder'=>'State of Registration'])}}
                <span class="error">{{$errors->first('state_reference')}}</span>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group"> 
              <label class="form-label">Address</label>   
              <div class="row">
                <div class="col-md-6 form-group">{{Form::text('address1',(isset($data["address1"]))?$data["address1"]:'',['required'=>'true','class'=>'form-control','placeholder'=>'Address line 1'])}}
                <span class="error">{{$errors->first('address1')}}</span>
                </div>
                
                <div class="col-md-6 form-group">{{Form::text('address2',(isset($data["address2"]))?$data["address2"]:'',['class'=>'form-control','placeholder'=>'Address line 2'])}}</div>
                

                <div class="col-md-6 form-group">{{Form::text('city',(isset($data["city"]))?$data["city"]:'',['class'=>'form-control','placeholder'=>'City Name'])}}</div>
                <div class="col-md-6 form-group">{{Form::text('pincode',(isset($data["pincode"]))?$data["pincode"]:'',['class'=>'form-control','placeholder'=>'Pin Code'])}}</div>
                

                <div class="col-md-6 form-group">{{Form::select('state',$state,(isset($data["state"]))?$data["state"]:'',['class'=>'form-control'])}}</div>
              </div>    
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12"><label class="form-label">Phone</label>    
            <div class="form-group"> 
                 
              <div class="row">
                <div class="col-md-6">{{Form::text('mobile',(isset($data["mobile"]))?$data["mobile"]:'',['required'=>'true','class'=>'form-control','placeholder'=>'Mobile'])}}
                <span class="error">{{$errors->first('mobile')}}</span>
                </div>
                <div class="col-md-6">{{Form::text('landline',(isset($data["landline"]))?$data["landline"]:'',['class'=>'form-control','placeholder'=>'Landline'])}}
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
