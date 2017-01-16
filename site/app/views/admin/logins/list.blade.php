<div class="row">
	<div class="col-md-8">
		<h3 class="page-title">Users</h3>
	</div>
</div>

@if(sizeof($users)>0)
<div style="overflow-y:auto">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>Name</th>
				<th>Email</th>
				<th>Login</th>
				<!-- <th>#</th> -->
			</tr>
		</thead>
		<tbody id="users">
			<?php $count = 1; ?>
			@foreach($users as $data)
				@include('admin.logins.view')
				<?php $count++ ?>
			@endforeach
		</tbody>
	</table>
</div>
@else
<div class="alert alert-warning">
	No record found
</div>
@endif