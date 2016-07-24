{{Form::open(array("url"=>'resultAdmin/result/update/'.$application_id,"method"=>'PUT',"class"=>"ajax_edit_pop"))}}
	

<table class="table table-bordered table-hover">
		@foreach($parameters as $parameter)				
		<tr>
			<td style="width:50%">
				{{Form::label($parameter->parameter)}}
			</td>
			<td>
				{{Form::hidden('parameters[]',$parameter->parameter_id)}}
				{{Form::text('marks_'.$parameter->parameter_id,(isset($results[$parameter->parameter_id]))?$results[$parameter->parameter_id]:'',["class"=>"form-control"])}}
				<span class="error">{{$errors->first('event')}}</span>
			</td>
		</tr>
		@endforeach

		<tr>
			<td>
				{{Form::label('Exam Status')}}
			</td>
			<td>
				{{Form::select('status',$status,(!empty($finalResult))?$finalResult->status:'',["required"=>"true","class"=>"form-control"])}}
				<span class="error">{{$errors->first('event')}}</span>
			</td>
		</tr>
		<tr>
			<td>
				{{Form::label('Remarks')}}
			</td>
			<td>
				
				{{Form::text('remarks',(!empty($finalResult))?$finalResult->remarks:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('remarks')}}</span>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-ali"><button type="submit"  class="btn blue">{{(isset($results))?'Update':'Add'}}</button></td>
		</tr>
</table>

{{Form::close()}} 

<!-- 
<div class="form-body">
		
			<div class="row">
				@foreach($parameters as $parameter)
					<div class="col-md-6 form-group">
						{{Form::label($parameter->parameter)}}
						{{Form::hidden('parameters[]',$parameter->parameter_id)}}
						{{Form::text('marks_'.$parameter->parameter_id,(isset($results[$parameter->parameter_id]))?$results[$parameter->parameter_id]:'',["class"=>"form-control "])}}
						<span class="error">{{$errors->first('event')}}</span>
					</div>
				@endforeach
				<div class="col-md-6 form-group">
					{{Form::label('Exam Status')}}
					{{Form::select('status',$status,(!empty($finalResult))?$finalResult->status:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('event')}}</span>
				</div>
				<div class="col-md-6 form-group">
					{{Form::label('Remarks')}}
					{{Form::text('remarks',(!empty($finalResult))?$finalResult->remarks:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('remarks')}}</span>
				</div>
			</div>
			
		
	</div>
	<div class="form-actions" style="margin-top:40px;">
		<button type="submit" class="btn blue">{{(isset($results))?'Update':'Add'}}</button>
	</div>
 -->