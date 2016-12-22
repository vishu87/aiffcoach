<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">Employment Details</h3>
	</div>
	<div class="col-md-5">
		<a href="{{url('/coach/addNewEmployment')}}" class="btn green pull-right">Add Employment</a>
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

@if(sizeof($employment) > 0)
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th style="width:50px">SN</th>
					<th>Employment</th>
					<th>Status</th>
					<th>Referral</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Contract</th>
					<th>Approval Status</th>
					<th>#</th>
				</tr>
			</thead>
			<?php $count = 1;?>
			@foreach($employment as $data)
				@include('coaches.employments.view')
			<?php $count++;?>
			@endforeach
		</table>
	</div>
</div>
@else
	<div class="alert alert-danger">
    	There are no entries in this section
   	</div>
@endif
