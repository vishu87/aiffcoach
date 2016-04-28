
	@if(Session::has('success'))
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		{{Session::get('success')}}
	</div>
	@endif

<div class="row">
	<div class="col-md-12">
		<h3 class="page-title">
		{{$title}}
	</h3>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th  style="width:50px">SN</th>
					<th data-placeholder="Search..">Name</th>
					<th data-placeholder="Search..">Email</th>
					<th data-placeholder="Search..">State of Reference</th>
					<th data-placeholder="Search..">Mobile</th>
					<th >#</th>
				</tr>
			</thead>
			<?php $count = 1;?>
			@foreach($coaches as $data)
				@include('admin.viewCoach')
			<?php $count++;?>
			@endforeach
			

		</table>
	</div>
</div>
