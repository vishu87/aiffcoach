{{Form::open(array("url"=>'admin/changeEmail/'.$user_id,"method"=>'put',"class"=>"check_form ajax_edit_pop"))}}
	<div class="form-body">
		<!--- my form start -->
			<div class="row">
				<div class="col-md-12">
					{{Form::label('Change Email Id')}} <span class="error"> *</span><br>
					{{Form::text('email',$user->username,["class"=>"form-control","required"=>true])}}
				</div>
			</div>
		<!---my form end-->
	</div>
	<div class="form-actions" style="margin-top: 10px;">
		<button type="submit" class="btn blue">Update</button>
	</div>
{{Form::close()}}