<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">License Parameters</h3>
	</div>
	<div class="col-md-6">
		<a class="btn green pull-right" href="{{url('/resultAdmin/coursesParameter/exportExcel')}}">Export Excel</a>

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
    <div class="portlet-title"><div class="caption">@if(!isset($parameter))Add @else Update - {{$parameter->name}} @endif</div></div>
        <div class="portlet-body form">
            @if(isset($parameter))
			{{Form::open(array("url"=>'resultAdmin/coursesParameter/update/'.$parameter->id,"method"=>'PUT',"class"=>"form  check_form","files"=>'true'))}}
			@else
			{{Form::open(array("url"=>'resultAdmin/coursesParameter/insert',"method"=>'post',"class"=>" form  check_form","files"=>'true'))}}
			@endif
            <div class="form-body">
                <div class="row">
					<div class="col-md-6 form-group">
						{{Form::label('License')}}
						{{Form::select('license_id',$licenses,(isset($parameter))?$parameter->license_id:'',["required"=>"true","class"=>"form-control","placeholder"=>"parameter"])}}
						<span class="error">{{$errors->first('license_id')}}</span>
					</div>
					<div class="col-md-12 form-group">
						{{Form::label('Parameters')}}<br>
						@foreach($parameters as $parameter_value)
							{{Form::checkbox('parameter_id[]',$parameter_value->id,(isset($selectedParameters))?(in_array($parameter_value->id,$selectedParameters))?$parameter_value->id:'':'')}} {{$parameter_value->parameter}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						@endforeach
						<!-- {{Form::select('parameter_id[]',$parameters,(isset($parameter))?$selectedParameters:'',["required"=>"true","class"=>"form-control select","placeholder"=>"Maximum Marks","multiple"=>'true'])}} -->
						<span class="error">{{$errors->first('parameter_id')}}</span>
					</div>
				</div>
            </div> 
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">{{(isset($parameter))?'Update':'Add'}}</button>
            </div>   
            {{Form::close()}}  
        </div>
    </div>
<div style="overflow-y:auto">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>License Name</th>
				<th>Parameter Name</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody id="society">
			<?php $count = 1; ?>
			@foreach($coursesParameter as $data)
				<tr id="parameter_{{$data->id}}">
					<td style="width:50px">{{$count}}</td>
					<td>{{$data->license_name}}</td>
					<td>{{$data->parameter}}</td>
					<td>
						<a type="button" class="btn btn-sm yellow " href="{{url('resultAdmin/coursesParameter/edit/'.$data->id)}}" ><i class="fa fa-edit"></i> Edit</a>
						<button type="button" class="btn btn-sm red delete-div" div-id="parameter_{{$data->id}}"  action="{{'resultAdmin/coursesParameter/delete/'.$data->id}}"> <i class="fa fa-remove"></i></button>
					</td>
				</tr>
				<?php $count++ ?>
			@endforeach
		</tbody>
	</table>
</div>