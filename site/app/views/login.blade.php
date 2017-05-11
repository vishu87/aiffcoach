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
  <div class="row">
    <div class="col-md-12">
      <div style="padding: 10px;">
        <a href="{{url('/view-all-coaches')}}" class="btn pull-right blue">View All Coaches</a>
      </div>
    </div>
  </div>
  <div class="logo">
    <img src="{{url('assets/img/aiff.png')}}" style="width:240px; height:auto">
  </div>
<div style="max-width:700px; margin:0 auto">
  @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
      {{Session::get('success')}}
    </div>
  @endif
</div>
<div class="content">
  <!-- BEGIN LOGIN FORM -->
  {{ Form::open(array('action' => 'UserController@postLogin','class' => 'login-form',"method"=>"POST")) }}
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
        {{Form::text('username','',array("class" => "form-control placeholder-no-fix", "autocomplete" => "off", "placeholder" => "Username"))}}
      </div>
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Password</label>
      <div class="input-icon">
        <i class="fa fa-lock"></i>
        {{Form::password('password',array("class" => "form-control placeholder-no-fix", "placeholder" => "Password", "autocomplete" => "off"))}}
      </div>
    </div>
    <div class="form-group" id="captcha">
      <div class="row">
        <div class="col-md-4">
          {{ HTML::image(URL::to('simplecaptcha'),'Captcha') }}
        </div>
        <div class="col-md-6">
          <input type="text" name="captcha" class="form-control" placeholder="Enter the code">
        </div>
      </div>  
    </div>
    <div class="form-actions">
      <button type="submit" class="btn green pull-right">
      Login <i class="m-icon-swapright m-icon-white"></i>
      </button>
    </div>

    <div style="margin-top:30px; text-align: center;">
      
      <a href="{{url('/registerStep1')}}" class="btn blue pull-left btn-block">Register Here!</a><br>

    </div>

    <div class="forget-password clear">
      <h4>Forgot your password ?</h4>
      <p>
         no worries, <a href="{{URL("/reset")}}" id="forget-password" style="color:#000">
        click here </a>
        to reset your password.
      </p>
    </div>


  {{ Form::close() }}
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