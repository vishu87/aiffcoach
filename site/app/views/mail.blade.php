@if($type == 1)
	<p style='font-size:14px'>Dear {{$name}},</p>
	<div style='margin-top:20px; font-size:14px;'>

	<p>Following are login details for your account on AIFF Official Registration System: </p>
	<br>
	<p>Link: <a href="http://coaching.the-aiff.com/">http://coaching.the-aiff.com</a></p>
	<p>Username: <b>{{$username}}</b></p>
	<p>Password: <b>{{$password}}</b></p>

	<p>Regards,<br>
	AIFF</p></div>
@endif

@if($type == 2)
	<p style='font-size:14px'>Dear {{$name}},</p>
	<div style='margin-top:20px; font-size:14px;'>
	<p>Your Password has been reset. Following are new login details for your account on AIFF CMS:</p>
	<p>Link: <a href="http://coaching.the-aiff.com/">http://coaching.the-aiff.com</a></p>
	<p>Username: {{$username}}</p>
	<p>Password: {{$password}}</p>
	<p>Regards,<br>
	AIFF</p></div>
@endif

@if($type == 3)
	<p style='font-size:14px'>Dear user,</p>
	<div style='margin-top:20px; font-size:14px;'>
	<p>Your profile has been {{$ref_type}} because of following reason - </p>
	<p>
		"<b><i>{{$remarks}}</i></b>"
	</p>
	<p>Please login to your profile at <a href="http://coaching.the-aiff.com/">http://coaching.the-aiff.com</a></p>
	<p>Regards,<br>
	AIFF</p></div>
@endif

@if($type == 4)
	<p style='font-size:14px'>Dear user,</p>
	<div style='margin-top:20px; font-size:14px;'>
	<p>Your application has been {{$ref_type}} because of following reason - </p>
	<p>
		"<b><i>{{$remarks}}</i></b>"
	</p>
	<p>Please login to your profile at <a href="http://coaching.the-aiff.com/">http://coaching.the-aiff.com</a></p>
	<p>Regards,<br>
	AIFF</p></div>
@endif

@if($type == 5)
	<p style='font-size:14px'>Dear user,</p>
	<div style='margin-top:20px; font-size:14px;'>
	<p>Your application has been selected for course <b>{{$course->name}}</b>.</p>
	<p>
		Now you can fill the payment details in your application and send DD/Cheque to AIFF.
	</p>
	<p>Please login to your profile at <a href="http://coaching.the-aiff.com/">http://coaching.the-aiff.com</a> to complete your application.</p>
	<p>Regards,<br>
	AIFF</p></div>
@endif