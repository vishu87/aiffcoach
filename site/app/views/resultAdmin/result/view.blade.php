<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">Update Score Card</h3>
	</div>
	<div class="col-md-6">
		<a href="{{url('resultAdmin')}}" class="btn btn-primary pull-right">Back</a>
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
<div class="portlet box blue">
    <div class="portlet-title"><div class="caption">Score Card</div></div>
        <div class="portlet-body form">
            {{Form::open(array("url"=>'resultAdmin/result/update/'.$application_id,"method"=>'POST',"class"=>"check_form","files"=>"true"))}}
            <div class="form-body">
                <div class="row">
					@foreach($parameters as $parameter)				
						<div class="col-md-4 form-group">
							{{Form::label($parameter->parameter)}}
							<div class="input-group">
								{{Form::hidden('parameters[]',$parameter->parameter_id)}}
								{{Form::text('marks_'.$parameter->parameter_id,(isset($results[$parameter->parameter_id]))?$results[$parameter->parameter_id]:'',["class"=>"form-control"])}}
								<span class="input-group-addon">/ {{$parameter->max_marks}}</span>
							</div>
							
							<span class="error">{{$errors->first('event')}}</span>
						</div>
					@endforeach
					<div class="col-md-4 form-group clear">
						{{Form::label('Exam Status')}}<span class="error">*</span>
						{{Form::select('status',$status,(!empty($finalResult))?$finalResult->status:'',["required"=>"true","class"=>"form-control"])}}
						<span class="error">{{$errors->first('event')}}</span>
					</div>
					<div class="col-md-4 form-group">
						{{Form::label('Remarks')}}
						{{Form::text('remarks',(!empty($finalResult))?$finalResult->remarks:'',["class"=>"form-control"])}}
						<span class="error">{{$errors->first('remarks')}}</span>
					</div>
					<div class="col-md-4 form-group">
						{{Form::label('Upload Marks')}}
						{{Form::file('upload_marks',["class"=>"form-control","pdf"=>true])}}
						<div style="margin-top:5px;">
							@if(!empty($finalResult->upload_marks))
								<a href="{{url($finalResult->upload_marks)}}" target="_blank">view current</a>
							@endif
						</div>
					</div>
				</div>
            </div> 
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">{{(isset($results))?'Update':'Add'}}</button>
            </div>   
            {{Form::close()}}  
        </div>
    </div>