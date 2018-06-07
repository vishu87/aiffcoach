<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Upload Data</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
{{HTML::style("http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all")}}
{{HTML::style("assets/global/plugins/font-awesome/css/font-awesome.min.css")}}
{{HTML::style("assets/global/plugins/bootstrap/css/bootstrap.min.css")}}

<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<body class="login">
<div style="max-width:700px; margin:0 auto">
  @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
      {{Session::get('success')}}
    </div>
  @endif
</div>
<div class="content">
  	<div class="logo" style="text-align: center;">
    	<img src="{{url('assets/img/aiff.png')}}" style="width:240px; height:auto">
  	</div>
  	<!-- BEGIN LOGIN FORM -->
  	{{ Form::open(array('url' => 'upload-data','class' => 'login-form',"method"=>"POST" , "files"=>true)) }}
  	<div class="row">
  		<div class="col-md-4 col-md-offset-4">
		  	@if(isset($message))
		    	<div class="alert alert-danger">
		        	<i class="fa fa-ban-circle"></i><strong>Message!</strong> {{$message}}
		      	</div>
		  	@endif
  			<div>
  				<h2 class="page-title">Upload Data</h2>
  			</div>
		  	<div class="form-group">
		  		{{Form::file('file',["class"=>"form-control","required"=>true])}}
		  	</div>
  			<button class="btn btn-primary">Upload</button>
  		</div>

  		@if(isset($cData) && sizeof($cData) > 0)
  		<div class="col-md-8 col-md-offset-2">
  			
  			<table class="table">
  				<thead>
  					<tr>
  						<th>SN</th>
  						<th>Name</th>
  						<th>Email</th>
  						<th>Mobile</th>
  						<th>Status</th>
  					</tr>
  				</thead>
  				<tbody>
  					<?php $count =1;?>
  					@foreach($cData as $coach)
  					<tr>
  						<td>{{$count++}}</td>
  						<td>{{$coach[1]}}</td>
  						<td>{{$coach[2]}}</td>
  						<td>{{$coach[3]}}</td>
  						<td>{{$coach['message']}}</td>
  					</tr>
  					@endforeach
  				</tbody>
  			</table>
  		</div>
  		@endif
  	</div>
    
  	{{Form::close()}}


</div>

</body>
</html>