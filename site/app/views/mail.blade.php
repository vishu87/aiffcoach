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