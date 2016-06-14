
{{Form::open(array("url"=>'resultAdmin/result/update/'.$application_id,"method"=>'put',"class"=>"update-marks"))}}
	<div class="form-body">
		<!--- my form start -->
			<div class="row">
				@foreach($parameters as $parameter)
					<div class="col-md-6 form-group">
						{{Form::label($parameter->parameter)}}
						{{Form::hidden('parameters[]',$parameter->parameter_id)}}
						{{Form::text('marks_'.$parameter->parameter_id,(isset($results[$parameter->parameter_id]))?$results[$parameter->parameter_id]:'',["class"=>"form-control "])}}
						<span class="error">{{$errors->first('event')}}</span>
					</div>
				@endforeach
			</div>
		<!---my form end-->
	</div>
	<div class="form-actions" style="margin-top:40px;">
		<button type="submit" class="btn blue">{{(isset($results))?'Update':'Add'}}</button>
	</div>
{{Form::close()}}

