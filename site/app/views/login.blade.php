<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>AIFF</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
{{HTML::style("http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all")}}
{{HTML::style("assets/global/plugins/font-awesome/css/font-awesome.min.css")}}
{{HTML::style("assets/global/plugins/bootstrap/css/bootstrap.min.css")}}
<!-- {{HTML::style("assets/global/plugins/uniform/css/uniform.default.css")}} -->
<!-- {{HTML::style("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css")}} -->
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
{{HTML::style("assets/global/css/components.css")}}
<!-- {{HTML::style("assets/admin/css/layout.css")}} -->
<!-- {{HTML::style("assets/admin/css/themes/darkblue.css")}} -->
{{HTML::style("assets/admin/css/login-soft.css")}}
<!-- {{HTML::style("assets/admin/css/custom.css")}} -->
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<body class="login">
  <div class="logo">
    <img src="{{url('assets/img/aiff.jpg')}}">
  </div>
<div class="row">
  <div class="col-md-6">
    <div class="content" style="margin-left:210px">
    <!-- BEGIN LOGIN FORM -->
    {{ Form::open(array('action' => 'UserController@postLogin','class' => 'login-form check_form',"method"=>"POST")) }}
    @if(Session::has('failure'))
      <div class="alert alert-danger">
          <i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
        </div>
    @endif
      <h3 class="form-title">Login to your account</h3>
      <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span>
        Enter any username and password. </span>
      </div>
      <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="input-icon">
          <i class="fa fa-user"></i>
          <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="input-icon">
          <i class="fa fa-lock"></i>
          <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn blue pull-right">
        Login <i class="m-icon-swapright m-icon-white"></i>
        </button>
      </div>

      <div class="forget-password">
        <h4>Forgot your password ?</h4>
        <p>
           no worries, <a href="{{URL("/reset")}}" id="forget-password" style="color:#000">
          click here </a>
          to reset your password.
        </p>
      </div>


    {{ Form::close() }}
    </div>
  </div>
  <div class="col-md-6">
    <div class="content" style="margin-right:160px">
  <!-- BEGIN LOGIN FORM -->
    {{ Form::open(array('action' => 'CoachController@register','class' => 'registration-form',"id"=>'registration',"method"=>"POST","files"=>'true')) }}
        <h3 class="form-title">Create New Account</h3>
        <div class="alert alert-danger display-hide">
          <button class="close" data-close="alert"></button>
          <span>
          Fill Blank Fields. </span>
        </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label ">First Name</label>
            
              {{Form::text('fname','',['required'=>'true','placeholder'=>"First Name",'class'=>"form-control placeholder-no-fix"])}}
              <span class="error">{{$errors->first('fname')}}</span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label ">Middle Name</label>
            
              {{Form::text('mname','',['placeholder'=>"Middle Name",'class'=>"form-control placeholder-no-fix"])}}
              <span class="error">{{$errors->first('mname')}}</span>

            
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label ">Last Name</label>
            
              {{Form::text('lname','',['required'=>'true','placeholder'=>"Last Name",'class'=>"form-control placeholder-no-fix"])}}
              <span class="error">{{$errors->first('lname')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="control-label ">Email Id</label>
              {{Form::text('email','',['required'=>'true','placeholder'=>"Email Id",'class'=>"form-control placeholder-no-fix"])}}
              <span class="error">{{$errors->first('email')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="control-label ">Upload Photograph</label>
              {{Form::file('photo',['required'=>'true','placeholder'=>"Upload Photograph",'class'=>"form-control placeholder-no-fix"])}}
              <span class="error">{{$errors->first('photo')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12"><label class="form-label"> DOB</label>
        </div>
      </div>
      <div class="row">
        
        <div class="col-md-3">
          <div class="form-group">   
                     
            {{Form::select('dob_date',$date,'',['required'=>'true','class'=>'form-control'])}}
              <span class="error">{{$errors->first('dob_date')}}</span>

          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">        
            {{Form::select('dob_month',$month,'',['required'=>'true','class'=>'form-control'])}}
              <span class="error">{{$errors->first('dob_month')}}</span>

          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">        
            {{Form::select('dob_year',$year,'',['required'=>'true','class'=>'form-control'])}}
              <span class="error">{{$errors->first('dob_year')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group"> 
            <label class="form-label">Attach Proof</label>       
            {{Form::file('dob_proof',['required'=>'true','class'=>'form-control','placeholder'=>'Attach Proof'])}}
              <span class="error">{{$errors->first('dob_proof')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group"> 
            <label class="form-label">Place of Birth</label>       
            {{Form::text('birth_place','',['required'=>'true','class'=>'form-control','placeholder'=>'Birth Place'])}}
              <span class="error">{{$errors->first('birth_place')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group"> 
            <label class="form-label">State of Registration</label>       
            {{Form::select('state_reg',$state,'',['class'=>'form-control'])}}
              <span class="error">{{$errors->first('state_reg')}}</span>

          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <div class="form-group"> 
            <label class="form-label">State Reference</label>       
            {{Form::select('state_reference',$state,'',['required'=>'true','class'=>'form-control','placeholder'=>'State of Registration'])}}
              <span class="error">{{$errors->first('state_reference')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group"> 
            <label class="form-label">Gender</label>   <br>    
            {{Form::radio('gender','male','',['required'=>'true','placeholder'=>''])}} Male
            {{Form::radio('gender','female','',['required'=>'true','placeholder'=>''])}} FeMale
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group"> 
            <label class="form-label">Address</label>   
            <div class="row">
              <div class="col-md-12">{{Form::text('address1','',['required'=>'true','class'=>'form-control','placeholder'=>'Address line 1'])}}
              <span class="error">{{$errors->first('address1')}}</span>
              </div>
              <div style="height:35px;"></div>
              <div class="col-md-12">{{Form::text('address2','',['class'=>'form-control','placeholder'=>'Address line 2'])}}</div>
              <div style="height:35px;"></div>

              <div class="col-md-6">{{Form::text('city','',['class'=>'form-control','placeholder'=>'City Name'])}}</div>
              <div class="col-md-6">{{Form::text('pincode','',['class'=>'form-control','placeholder'=>'Pin Code'])}}</div>
              <div style="height:35px;"></div>

              <div class="col-md-12">{{Form::select('state',$state,'',['class'=>'form-control'])}}</div>
            </div>    
            
            

            
            
            
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12"><label class="form-label">Phone</label>    
          <div class="form-group"> 
               
            <div class="row">
              <div class="col-md-6">{{Form::text('mobile','',['required'=>'true','class'=>'form-control','placeholder'=>'Mobile'])}}
              <span class="error">{{$errors->first('mobile')}}</span>
              </div>
              <div class="col-md-6">{{Form::text('landline','',['class'=>'form-control','placeholder'=>'Landline'])}}
              <span class="error">{{$errors->first('landline')}}</span>
              </div>
            
            </div>
            
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group"> 
            <label class="form-label">Passport No</label>       
            {{Form::text('passport','',['required'=>'true','class'=>'form-control','placeholder'=>'Passport No'])}}
              <span class="error">{{$errors->first('passport')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12"><label class="form-label"> Passport Expiry</label>
        </div>
      </div>
      <div class="row">
        
        <div class="col-md-3">
          <div class="form-group">   
                     
            {{Form::select('passport_date',$date,'',['required'=>'true','class'=>'form-control'])}}
              <span class="error">{{$errors->first('passport_date')}}</span>

          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">        
            {{Form::select('passport_month',$month,'',['required'=>'true','class'=>'form-control'])}}
              <span class="error">{{$errors->first('passport_month')}}</span>

          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">        
            {{Form::select('passport_year',$ex_year,'',['required'=>'true','class'=>'form-control'])}}
              <span class="error">{{$errors->first('passport_year')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group"> 
            <label class="form-label">Attach Passport Copy</label>       
            {{Form::file('passport_proof',['required'=>'true','class'=>'form-control','placeholder'=>'Attach Passport Copy'])}}
              <span class="error">{{$errors->first('passport_proof')}}</span>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-actions">
            <button type="submit" class="btn blue pull-right">
            Register <i class="m-icon-swapright m-icon-white"></i>
            </button>
          </div>
        </div>
      </div>
    {{ Form::close() }}
    </div>  
  </div>
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
{{HTML::script("assets/global/plugins/jquery.min.js")}}
{{HTML::script("assets/global/plugins/jquery-migrate.min.js")}}
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
{{HTML::script("assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js")}}
{{HTML::script("assets/global/plugins/bootstrap/js/bootstrap.min.js")}}
{{HTML::script("assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js")}}
{{HTML::script("assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js")}}
<!-- {{HTML::script("assets/global/plugins/jquery.blockui.min.js")}}
{{HTML::script("assets/global/plugins/jquery.cokie.min.js")}}
{{HTML::script("assets/global/plugins/uniform/jquery.uniform.min.js")}} -->
<!-- END CORE PLUGINS -->
{{HTML::script("assets/global/scripts/metronic.js")}}
<!-- {{HTML::script("assets/admin/scripts/layout.js")}}
{{HTML::script("assets/admin/scripts/quick-sidebar.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.pager.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.widgets.js")}} -->
{{HTML::script("assets/admin/scripts/custom.js")}}
<script>
jQuery(document).ready(function() {   
   // initiate layout and plugins
  Metronic.init(); // init metronic core components
  Layout.init(); // init current layout
  QuickSidebar.init(); // init quick sidebar
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>