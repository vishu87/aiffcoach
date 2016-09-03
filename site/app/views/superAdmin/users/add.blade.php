<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">{{(isset($user))?'Update User':'Add New User'}}</h3>
	</div>
	<div class="col-md-6">
		<a class="btn green pull-right" href="{{url('superAdmin/manage_logins')}}">Back</a>

	</div>
</div>
@if(Session::has('success'))
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		{{Session::get('success')}}
	</div>
@endif
@if(Session::has('failure'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
    </div>
@endif

@if(!isset($user))
{{ Form::open(array('url' => 'superAdmin/manage_logins/store', 'method' => 'POST','role' => 'form','class'=>"check_form")) }}
@else
{{ Form::open(array('url' => 'superAdmin/manage_logins/update/'.$user->id, 'method' => 'POST','role' => 'form','class'=>"check_form")) }}
@endif
<div class="row">
	<div class="form-group col-md-6">
		<label>Name</label>
		{{Form::text('name',(isset($user))?$user->name:'',["class"=>"form-control","required"=>"true"])}}
		<span class="error"><?php echo $errors->first('name'); ?></span>
	</div>
	<div class="form-group col-md-6">
		<label>Email</label>
		{{Form::email('email',(isset($user))?$user->username:'',["class"=>"form-control","required"=>"true"])}}
		<span class="error"><?php echo $errors->first('email'); ?></span>
	</div>
	<div class="form-group col-md-6 clear">
		<label>Role</label>
		{{Form::select('user_type',$UserTypes,(isset($user))?$user->privilege:'',["class"=>"form-control","required"=>"true","id"=>"UserType"])}}
		<span class="error"><?php echo $errors->first('user_type'); ?></span>
	</div>
	<div class="form-group col-md-6">
		<label>Mobile</label>
		{{Form::text('mobile',(isset($user))?$user->mobile:'',["class"=>"form-control"])}}
		<span class="error"><?php echo $errors->first('mobile'); ?></span>
	</div>
</div>
<div>
<button class="btn green" type="submit">{{(!isset($user))?'Add':'Update'}}</button>
</div>
{{Form::close()}}