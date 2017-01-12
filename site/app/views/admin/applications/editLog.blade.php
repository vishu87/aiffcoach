@if(!$flag)
{{Form::open(array("url"=>'control/updateAppLog/'.$log->id,"method"=>'PUT',"class"=>"check_form ajax_edit_pop"))}}
	<div class="form-body">
		<!--- form start -->
			<div class="form-group">
				{{Form::label('Remarks')}}<span class="error">*</span>
				{{Form::textarea('remarks',(isset($log))?$log->remarks:'',["class"=>"form-control ","required"=>"true"])}}
				<span class="error">{{$errors->first('remarks')}}</span>
			</div>
		<!---form end-->
		<div class="form-actions" >
			<button type="submit" class="btn blue">{{(isset($log))?'Update':'Add'}}</button>
		</div>
	</div>
{{Form::close()}}

@else
<div class="log-remarks" id="app_log_{{$log->id}}">
	{{$log->remarks}} &nbsp;<button class="btn btn-xs edit-div yellow" modal-title="Edit Remarks" div-id="app_log_{{$log->id}}" action="control/editAppLog/{{$log->id}}"><i class="fa fa-edit"></i></button>
</div>
@endif