@if(!$flag)
{{Form::open(array("url"=>'admin/updateRemark/'.$log->id,"method"=>'PUT',"class"=>"check_form ajax_edit_pop"))}}
	<div class="form-body">
		<!--- my form start -->
			<div class="form-group">
				{{Form::label('Remarks')}}<span class="error">*</span>
				{{Form::textarea('remarks',(isset($log))?$log->remarks:'',["class"=>"form-control ","required"=>"true"])}}
				<span class="error">{{$errors->first('remarks')}}</span>
			</div>
			
		<!---my form end-->
	
	<div class="form-actions" >
		<button type="submit" class="btn blue">{{(isset($log))?'Update':'Add'}}</button>
	</div>
	</div>
{{Form::close()}}

@else
<tr id="approval_log_{{$log_data->id}}">
	<td>{{$count}}</td>
	<td>
		{{$log_data->remarks}}
		
	</td>
	<td>
		@if($log_data->privilege == 2)
			{{Approval::get_status($log_data->status);}}
		@endif
	</td>
	<td>
		{{$log_data->user_name}} <br>  {{date('d-m-Y',strtotime($log_data->created_at))}}
	</td>
	<td>
		@if(Auth::user()->privilege == 2)
		<button class="btn btn-xs btn-warning edit-div" modal-title="Edit Remarks" div-id="approval_log_{{$log_data->id}}" count="{{$count}}" action="{{'admin/editRemark/'.$log_data->id}}"><i class = "fa fa-edit" ></i></button>
		@endif
	</td>
	<td>
		@if(!empty($log_data->document))
			<a href="{{url($log_data->document)}}" target=_blank>view</a>
		@else
			N/A	
		@endif
	</td>
</tr>
@endif