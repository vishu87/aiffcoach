<div class="row">
	<div class="col-md-8">
		<h3 class="page-title">Licenses</h3>
	</div>
	<div class="col-md-4">
		<a type="button" class="btn green pull-right" href="{{url('admin/License/add')}}"> <i class="fa fa-plus"></i> Add License</a>
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
				<th>Name</th>
				<th>Desccription</th>
				<th>Authorised By</th>
				<th>#</th>
				
				
			</tr></thead>
			<tbody id="licenses">
				<?php $count = 1; ?>
				@foreach($licenses as $data)
					@include('admin.license.view')
					<?php $count++ ?>
				@endforeach
			</tbody>
	</table>
</div>