{{Form::open(array("url"=>'admin/changeOfficialType/'.$user_id,"method"=>'put',"class"=>"check_form ajax_edit_pop"))}}
	<div class="form-body">
		<!--- my form start -->
			<div class="row">
				<div class="col-md-12">
					{{Form::label('Select Official Types')}} <span class="error"> *</span><br>
					@foreach(User::OfficialTypes() as $key => $value)

					    <label>
					        <input type="checkbox" name="official_types[]" value="{{$key}}" {{(in_array($key,$current_user_types))?'checked':''}}> 
					        <span>{{$value}} &nbsp;&nbsp;</span>
					    </label>

					@endforeach
				</div>
			</div>
		<!---my form end-->
	</div>
	<div class="form-actions" style="margin-top: 10px;">
		<button type="submit" class="btn blue">Update</button>
	</div>
{{Form::close()}}