<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">{{$title}}</h3>
	</div>
	<div class="col-md-6">
		<a class="btn green pull-right" href="{{url('/admin/coursesExport/'.$flag)}}">Export Excel</a>

		<a type="button" class="btn green pull-right" style="margin-right:10px;" href="{{url('admin/Courses/add')}}"> <i class="fa fa-plus"></i> Add Course</a>
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
				<th>Name</th>
				<th>Course Start Date</th>
				<th>Registration Start Date</th>
				<th>Registration End Date</th>
				<th>Venue</th>
				<th>Manage</th>		
			</tr>
		</thead>
			<tbody id="courses">
				<?php $count = 1; ?>
				@foreach($courses as $data)
					@include('admin.courses.view')
					<?php $count++ ?>
				@endforeach
			</tbody>
	</table>
</div>