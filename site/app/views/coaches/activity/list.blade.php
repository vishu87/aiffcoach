<div class="row">
	<div class="col-md-8">
		<h3 class="page-title">Activities</h3>
	</div>
	<div class="col-md-4">
		<a type="button" class="btn green pull-right" href="{{url('coach/activity/add')}}"> <i class="fa fa-plus"></i> Add New Activity</a>
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
@if(sizeof($activities)>0)
<div style="overflow-y:auto">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>Event</th>
				<th>From</th>
				<th>To</th>
				<th>Participants</th>
				<th>Postion / Role</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody id="activities">
			<?php $count = 1; ?>
			@foreach($activities as $data)
				@include('coaches.activity.view')
				<?php $count++ ?>
			@endforeach
		</tbody>
	</table>
</div>
@else
<div class="alert alert-danger">
	There are no entries in this section
</div>
@endif