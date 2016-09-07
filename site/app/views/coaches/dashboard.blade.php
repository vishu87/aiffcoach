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
<div style="overflow-y:auto">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>Course Name</th>
				<th>License Name</th>
				<th>Start Date</th>
				<th>Venue</th>
				<th>#</th>
				
				
			</tr></thead>
			<tbody id="courses">
				<?php $count = 1; ?>
				@foreach($courses as $data)
				<tr id="activity_{{$data->id}}">
					<td>{{$count}}</td>
					<td>{{$data->name}}</td>
					<td>{{$data->license_name}}</td>
					<td>{{$data->start_date}}</td>
					<td>{{$data->venue}}</td>
					<td>
						@if(!isset($status))
							@if(in_array($data->id,$check))
							<a type="button" class="btn blue btn-sm " div-id="activity_{{$data->id}}"  href="{{url('coach/courses/details/'.$data->id)}}">Already Applied</button>
							@else
							<a type="button" class="btn blue btn-sm " div-id="activity_{{$data->id}}"  href="{{url('coach/courses/details/'.$data->id)}}">Apply</button>
							@endif
						@endif	
					</td>
				</tr>
					<?php $count++ ?>
				@endforeach
			</tbody>
	</table>
</div>