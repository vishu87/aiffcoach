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
  {{HTML::style("assets/global/plugins/simple-line-icons/simple-line-icons.min.css")}}
  {{HTML::style("assets/global/plugins/bootstrap/css/bootstrap.min.css")}}
  {{HTML::style("assets/global/plugins/uniform/css/uniform.default.css")}}
  {{HTML::style("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css")}}
  <!-- END GLOBAL MANDATORY STYLES -->
  <!-- BEGIN THEME STYLES -->
  {{HTML::style("assets/global/css/components.css")}}
  {{HTML::style("assets/admin/css/layout.css")}}
  {{HTML::style("assets/admin/css/themes/darkblue.css")}}
  {{HTML::style("assets/admin/css/login-soft.css")}}
  {{HTML::style("assets/admin/css/custom.css")}}
  <!-- END THEME STYLES -->
  <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<body class="login">
  <div class="logo">
    <a href="javascript:;">
      {{HTML::image('assets/img/aiff.jpg','')}}
    </a>
  </div>

  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    {{ Form::open(array('action' => 'UserController@postReset','class' => 'login-form',"method"=>"POST")) }}
    @if(Session::has('success'))
    <div class="alert alert-success">
      <i class="fa fa-ban-circle"></i><strong>Success!</strong> {{Session::get('success')}}
    </div>
    @endif
    @if(Session::has('failure'))
    <div class="alert alert-danger">
      <i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
    </div>
    @endif
    <h3 class="form-title">Forgot Password?</h3>

    <div class="form-group">
      <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
      <label class="control-label visible-ie8 visible-ie9">Your Email</label>
      <div class="input-icon">
        <i class="fa fa-user"></i>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="username"/>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn blue pull-right">
        Reset <i class="m-icon-swapright m-icon-white"></i>
      </button>
    </div>

    <div class="forget-password">
      <h4>Remember your password ?</h4>
      <p>
        <a href="{{URL("/")}}" id="forget-password" style="color:#000">
          click here </a>
          to login again.
        </p>
      </div>


      {{ Form::close() }}
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
<!-- {{HTML::script("assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js")}}
{{HTML::script("assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js")}}
{{HTML::script("assets/global/plugins/jquery.blockui.min.js")}}
{{HTML::script("assets/global/plugins/jquery.cokie.min.js")}}
{{HTML::script("assets/global/plugins/uniform/jquery.uniform.min.js")}} -->
<!-- END CORE PLUGINS -->
{{HTML::script("assets/global/scripts/metronic.js")}}<!-- 
{{HTML::script("assets/admin/scripts/layout.js")}}
{{HTML::script("assets/admin/scripts/quick-sidebar.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.pager.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.widgets.js")}} -->
{{HTML::script("assets/admin/scripts/custom.js")}}
<script>
jQuery(document).ready(function() {   
   // initiate layout and plugins
  Metronic.init(); // init metronic core components
  // Layout.init(); // init current layout
  QuickSidebar.init(); // init quick sidebar
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>