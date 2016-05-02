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
<div style="overflow-y:auto">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>Course Name</th>
				<th>Coach Name</th>
				<th>Remark</th>
				<th>Status</th>
				<th>#</th>
				
				
			</tr></thead>
			<tbody id="applications">
				<?php $count = 1; ?>
				@foreach($applications as $data)
					@include('admin.applications.view')
					<?php $count++ ?>
				@endforeach
			</tbody>
	</table>
</div>