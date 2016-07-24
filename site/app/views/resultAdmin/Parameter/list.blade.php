<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">Courses Parameters</h3>
	</div>
	<div class="col-md-6">
		<a class="btn green pull-right" href="{{url('/resultAdmin/Parameter/exportExcel')}}">Export Excel</a>

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
			{{Form::open(array("url"=>'resultAdmin/Parameter/update/'.$parameter->id,"method"=>'PUT',"class"=>"form  check_form","files"=>'true'))}}
			@else
			{{Form::open(array("url"=>'resultAdmin/Parameter/insert',"method"=>'post',"class"=>" form  check_form","files"=>'true'))}}
			@endif
            <div class="form-body">
                <div class="row">
					<div class="col-md-6 form-group">
						{{Form::label('Name')}}
						{{Form::text('parameter',(isset($parameter))?$parameter->parameter:'',["required"=>"true","class"=>"form-control","placeholder"=>"parameter"])}}
						<span class="error">{{$errors->first('parameter')}}</span>
					</div>
					<div class="col-md-6 form-group">
						{{Form::label('Maximum Marks')}}
						{{Form::text('max_marks',(isset($parameter))?$parameter->max_marks:'',["required"=>"true","class"=>"form-control","placeholder"=>"Maximum Marks"])}}
						<span class="error">{{$errors->first('max_marks')}}</span>
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
				<th>Parameter Name</th>
				<th>Maximum Marks</th>
				<th>#</th>
				
			</tr>
		</thead>
		<tbody id="society">
			<?php $count = 1; ?>
			@foreach($coursesParameter as $data)
			<tr id="parameter_{{$data->id}}">
				<td style="widtd:50px">{{$count}}</td>
				<td>{{$data->parameter}}</td>
				<td>{{$data->max_marks}}</td>
				<td>
					<a type="button" class="btn btn-sm yellow " href="{{url('resultAdmin/Parameter/edit/'.$data->id)}}" ><i class="fa fa-edit"></i> Edit</a>
					<button type="button" class="btn btn-sm red delete-div" div-id="parameter_{{$data->id}}"  action="{{'resultAdmin/Parameter/delete/'.$data->id}}"> <i class="fa fa-remove"></i></button>
				</td>
			</tr>
				<?php $count++ ?>
			@endforeach
		</tbody>
	</table>
</div>