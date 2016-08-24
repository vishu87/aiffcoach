<div class="row">
	<div class="col-md-8">
		<h3 class="page-title">{{$title}}</h3>
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
<div style="margin-bottom:20px;" class="row">
	<div class="col-md-9">
	
	{{Form::open(array('url'=>'/resultAdmin', 'method'=>'GET', 'class' => 'check_form'))}}
	
		Filter by course
		<div class="row">
			<div class="col-md-4">
				{{Form::select('course',$courses,(Input::has('course'))?Input::get('course'):'',["class"=>"form-control", "required" => "true"])}}
			</div>
			<div class="col-md-4">
				{{Form::submit('Submit',["class"=>"btn blue"])}}
			</div>
		</div>
	{{Form::close()}}

	</div>
	<div class="col-md-3">
		<a class="btn green pull-right" href="{{url('/resultAdmin/exportApplications/'.app('request')->input('course'))}}">Export Results</a>
	</div>
</div>

<div style="overflow-y:auto">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>Course Name</th>
				<th>License Name</th>
				<th>Coach Name</th>
				<th>Remark</th>
				<th>Status</th>
				<th>#</th>
			</tr></thead>
			<tbody id="applications">
				<?php $count = 1; ?>
				@foreach($applications as $data)
					@include('resultAdmin.view')
					<?php $count++ ?>
				@endforeach
			</tbody>
	</table>
</div>