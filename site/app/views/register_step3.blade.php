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
        <li class="done">
          <a href="#tab3" data-toggle="tab" class="step active">
          <span class="number">
          2 </span>
          <span class="desc">
          <i class="fa fa-check"></i> Contact Details </span>
          </a>
        </li>
        <li class="active">
          <a href="#tab4" data-toggle="tab" class="step">
          <span class="number">3
          </span>
          <span class="desc">
          <i class="fa fa-check"></i> Confirm </span>
          </a>
        </li>
      </ul>
      <div id="bar" class="progress progress-striped" role="progressbar">
        <div class="progress-bar progress-bar-success" style="width:100%;">
        </div>
      </div>
  </div>
</div>
{{ Form::open(array('url' =>'registerStep3',"method"=>"POST","files"=>'true','class'=>'form check_form')) }}
  {{Form::text('id',(isset($id))?$id:'',["class"=>'hidden'])}}

<div class="portlet box blue">
  <div class="portlet-title"><div class="caption">Other Details</div></div>
  <div class="portlet-body form">             
    <div class="form-body">

      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
            <label class="form-label">Passport No</label>       
            {{Form::text('passport',(isset($data->passport))?$data->passport:'',['required'=>'true','class'=>'form-control','placeholder'=>'Passport No'])}}
              <span class="error">{{$errors->first('passport')}}</span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group"> 
            <label class="form-label">Passport Expiry</label>       
            {{Form::text('passport_expiry',(isset($data->passport_expiry))?$data->passport_expiry:'',['required'=>'true','class'=>'form-control datepicker',"date"=>'true','placeholder'=>'Passport Expiry'])}}
              <span class="error">{{$errors->first('passport_expiry')}}</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
            <label class="form-label">Attach Passport Copy</label>       
            {{Form::file('passport_proof',['required'=>'true','class'=>'form-control','placeholder'=>'Attach Passport Copy'])}}
              <span class="error">{{$errors->first('passport_proof')}}</span>
          </div>
        </div>
      </div>   
    </div>      
    <div class="form-actions">
          <a href="{{url('/registerStep2/'.$id)}}" class="btn blue pull-left"> previous</a>
      <button type="submit" class="btn blue pull-right">Submit</button>
    </div>
    
  </div>
</div>
