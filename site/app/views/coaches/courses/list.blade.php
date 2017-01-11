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
				<th>Venue</th>
				<th>Course Start Date</th>
				<th>Registration Start Date</th>
				<th>Registration End Date</th>
				<th>Fees</th>
				<th>Manage</th>
				
			</tr></thead>
			<tbody id="courses">
				<?php $count = 1; ?>
				@foreach($courses as $data)
					@include('coaches.courses.view')
					<?php $count++ ?>
				@endforeach
			</tbody>
	</table>
</div>