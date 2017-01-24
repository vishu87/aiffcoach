{{Form::open(array("url"=>'admin/reset-password/'.$user_id,"method"=>'put',"class"=>"check_form ajax_edit_pop"))}}
	<div class="form-body">
		<!--- my form start -->
			<div class="row">
				<div class="col-md-12 form-group">
					{{Form::label('New Password')}} <span class="error"> *</span>
					{{Form::text('new_pwd','',["class"=>"form-control ","required"=>"true"])}}
					<span class="error">{{$errors->first('new_pwd')}}</span>
				</div>
				<div class="col-md-12 form-group">
					{{Form::label('Confirm Password')}} <span class="error"> *</span>
					{{Form::text('con_pwd','',["class"=>"form-control ","required"=>"true"])}}
					<span class="error">{{$errors->first('con_pwd')}}</span>
				</div>
			</div>
		<!---my form end-->
	</div>
	<div class="form-actions">
		<button type="submit" class="btn blue">Update</button>
	</div>
{{Form::close()}}
