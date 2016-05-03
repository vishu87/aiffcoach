<div class="row">
	<div class="col-md-9">
		<h3 class="page-title">Employment Details</h3>
	</div>
	<div class="col-md-3">
		<a href="{{url('/coach/addNewEmployment')}}" class="btn blue pull-right">Add Employment</a>
	</div>
</div>
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	{{Session::get('success')}}
</div>
@endif
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th style="width:50px">SN</th>
					<th>Employment</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>#</th>
				</tr>
			</thead>
			<?php $count = 1;?>
			@foreach($employment as $data)
				@include('coaches.view')
			<?php $count++;?>
			@endforeach
		</table>
	</div>
</div>
