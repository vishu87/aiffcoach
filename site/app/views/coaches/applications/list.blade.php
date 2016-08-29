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
@if(sizeof($applications)>0)
	<div style="overflow-y:auto">
		<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th style="width:50px">SN</th>
					<th>Course Name</th>
					<th>License Name</th>
					<th>Authorised By</th>
					<th>Last Date</th>
					<th style="width:50px">Fees</th>
					@if(!isset($value))
					<th>Remark</th>
					<th>Application Status</th>
					@endif
					<th>Result Status</th>
					<th style="width:200px">#</th>
				</tr>
			</thead>
			<tbody id="applications">
				<?php $count = 1; ?>
				@foreach($applications as $data)
					@include('coaches.applications.view')
					<?php $count++ ?>
				@endforeach
			</tbody>
		</table>
	</div>
@else
	<div class="alert alert-warning">
		There are no entries in this section
	</div>	
@endif