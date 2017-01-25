<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">
			D licenses
		</h3>
	</div>
	<div class="col-md-5">
		<a href="{{url('/resultAdmin/d-license/add')}}" class="btn btn-sm blue pull-right" >Add New</a>
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


@if(sizeof($licenses) > 0)

<div class="row" style="padding:20px;">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px;">SN</th>
				<th>Course</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Venue</th>
				<th>Applicants</th>
				<!-- <th>#</th> -->
			</tr>
		</thead>
		
		<?php $count=1;?>
		@foreach($licenses as $license)
			<tr>	
				<td>{{$count}}</td>
				<td>{{$license->course_name}}</td>
				<td>{{($license->start_date)?date('d-m-Y',strtotime($license->start_date)):''}}</td>
				<td>{{($license->end_date)?date('d-m-Y',strtotime($license->end_date)):''}}</td>
				<td>{{$license->venue}}</td>
				<!-- <td>{{$license->applicant_name}}</td> -->
				<th>
					<a href="{{url('/resultAdmin/d-license/edit/'.$license->id)}}" class="btn btn-sm yellow"><i class="fa fa-edit"> </i> Edit </a>
					<a href="{{url('/resultAdmin/d-license/view/'.$license->id)}}" class="btn btn-sm blue">View</a>
				</th>
			</tr>
			<?php $count++?>
		@endforeach
	</table> 
</div>
@else
<div class="alert alert-warning">
	No licenses found
</div>
@endif
	