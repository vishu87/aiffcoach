<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">
			<!-- Course Name - {{$license->course_name}} <br>
			Start Date - {{($license->start_date)?date('d-m-Y',strtotime($license->start_date)):''}} -->
			{{$license->course_name}}
		</h3>
	</div>
	<div class="col-md-5">
		<a href="{{url('/resultAdmin/d-license')}}" class="btn btn-sm blue pull-right" >Go Back</a>
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
					<th>Applicant Name</th>
					<th>License Issue Date</th>
					<th>License Number</th>
					<th>Remarks</th>
				</tr>
			</thead>
			
			<?php $count=1;?>
			@foreach($licenses as $license)
				<tr>	
					<td>{{$count}}</td>
					<td>{{$license->applicant_name}}</td>
					<td>{{($license->license_issue_date)?date('d-m-Y',strtotime($license->license_issue_date)):''}}</td>
					<td>{{$license->license_number}}</td>
					<td>{{$license->remarks}}</td>
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
	