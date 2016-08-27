<div class="row">
	<div class="col-md-6">
		<h2 class="page-title">{{strtoupper($coach->full_name)}}<br>{{strtoupper($coach->registration_id)}}</h2>
	</div>
	<div class="col-md-6">
		<a href="#" class="btn yellow pull-right">Edit</a>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-6">
				<div class="profile-pic">
					<img src="{{url($coach->photo)}}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="row" style="padding:10px;">
					<table class="table table-bordered table-hover">
						<tr>
							<td>DOB<br>
								<b>{{date("d-m-Y",strtotime($coach->dob))}}</b>
							</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>{{$coach->email}}</td>
						</tr>
						<tr>
							<td>State of Registration</td>
							<td>{{$coach->state_registation}}</td>
						</tr>
						<tr>
							<td>Gender</td>
							<td>{{($coach->gender==1)?'Male':'Female'}}</td>
						</tr>
						<tr>
							<td>Address</td>
							<td>{{$coach->address1.' '.$coach->address2.' '.$coach->city.' '.$coach->pincode}}</td>
						</tr>
						<tr>
							<td>Mobile</td>
							<td>{{$coach->mobile}}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div>
	<h3>Documents</h3>
</div>
<div>
	<h3>Licenses</h3>
</div>
<div>
	<h3>Employment Details</h3>
</div>
@if(sizeof($employmentDetails) > 0)
<div class="row" style="padding:20px;">
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:50px;">SN</th>
			<th>Employment</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>#</th>
		</tr>
		<?php $count=1;?>
		@foreach($employmentDetails as $employment)
			<tr>	
				<td>{{$count}}</td>
				<td>{{$employment->employment}}</td>
				<td>{{$employment->start_date}}</td>
				<td>{{$employment->end_date}}</td>
				<td>@if($employment->contract!='')<a href="{{url($employment->contract)}}" target="_blank">View Contract</a>@endif</td>
			</tr>
			<?php $count++?>
		@endforeach
	</table> 
</div>
@else
<div class="alert alert-warning">
	No employment details found
</div>
@endif
<div>
	<h3>Activity Details</h3>
</div>
<div>
	<h3>Courses Enrolled</h3>
</div>
