@if($type == 1)
	<p style='font-size:14px'>Dear {{$name}},</p>
	<div style='margin-top:20px; font-size:14px;'>

	<p>Following are login details for your account on AIFF CMS: </p>
	<p>Link: <a href="http://administrator.the-aiff.com/">http://administrator.the-aiff.com</a></p>

	<p>Click the link below to activate your account</p>

	<p><a href='{{url("/verify/".$hash)}}' style="background:blue;padding:5px;color:#fff">Click Here to Verify</a></p>


	<p>Username: {{$username}}</p>
	<p>Password: {{$password}}</p>


	<p>Regards,<br>
	AIFF</p></div>
@endif

@if($type == 2)
	<p style='font-size:14px'>Dear {{$name}},</p>
	<div style='margin-top:20px; font-size:14px;'>
	<p>Your Password has been reset. Following are new login details for your account on AIFF CMS:</p>
	<p>Link: <a href="http://administrator.the-aiff.com/">http://administrator.the-aiff.com</a></p>
	<p>Username: {{$username}}</p>
	<p>Password: {{$password}}</p>
	<p>Regards,<br>
	AIFF</p></div>
@endif