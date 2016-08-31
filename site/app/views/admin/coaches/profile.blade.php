<div class="row">
	<div class="col-md-6">
		<h2 class="page-title">{{strtoupper($coach->full_name)}}<br>{{strtoupper($coach->registration_id)}}</h2>
	</div>
	<div class="col-md-6">
		<a href="{{url('admin/editCoachProfile/'.$coach->id)}}" class="btn yellow pull-right" style="margin-top:10px">Edit</a>
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
							<td>Email<br>
								<b>{{$coach->email}}</b>
							</td>
						</tr>
						<tr>
							<td>Gender<br>
								<b>{{($coach->gender==1)?'Male':'Female'}}</b>
							</td>
							<td>State of Registration<br>
								<b>{{$coach->state_registation}}</b>
							</td>
						</tr>
						<tr>
							<td>Mobile<br><b>{{$coach->mobile}}</b></td>
							<td>Address<br>
								<b>{{$coach->address1.' '.$coach->address2.' '.$coach->city.' '.$coach->pincode}}</b>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div style="margin:10px;">
			<h3 class="page-title">Status - {{$coachStatus[$coach->status]}}</h3>
		</div>

	</div>
</div>
<div>
	<h3>Documents</h3>
</div>
@if(sizeof($documents) > 0)
<div class="row" style="padding:20px;">
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:50px;">SN</th>
			<th>Document Name</th>
			<th>Document Number</th>
			<th>Expiry Date</th>
			<th>#</th>
		</tr>
		<?php $count=1;?>
		@foreach($documents as $document)
			<tr>	
				<td>{{$count}}</td>
				<td>{{$document->document_name}}</td>
				<td>{{$document->number}}</td>
				<td>{{date('d-m-Y',strtotime($document->expiry_date))}}</td>
				<td>@if($document->file!='')<a href="{{url($document->file)}}" target="_blank">View </a>@endif</td>
			</tr>
			<?php $count++?>
		@endforeach
	</table> 
</div>
@else
<div class="alert alert-warning">
	No Document found
</div>
@endif
<div>
	<h3>Licenses</h3>
</div>
@if(sizeof($coachLicense) > 0)
<div class="row" style="padding:20px;">
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:50px;">SN</th>
			<th>License Name</th>
			<th>License Number</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>#</th>
		</tr>
		<?php $count=1;?>
		@foreach($coachLicense as $license)
			<tr>	
				<td>{{$count}}</td>
				<td>{{$license->license_name}}</td>
				<td>{{$license->number}}</td>
				<td>{{date('d-m-Y',strtotime($license->start_date))}}</td>
				<td>{{date('d-m-Y',strtotime($license->end_date))}}</td>
				<td>@if($license->document!='')<a href="{{url($license->document)}}" target="_blank">View </a>@endif</td>
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
<div class="row">
	<div class="col-md-6">
		<h3>Employment Details</h3>
	</div>
	<div class="col-md-6">
		<!-- <a href="#" class="btn yellow pull-right" style="margin-top:20px">Edit</a> -->
	</div>
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
				<td>{{date('d-m-Y',strtotime($employment->start_date))}}</td>
				<td>{{date('d-m-Y',strtotime($employment->end_date))}}</td>
				<td>@if($employment->contract!='')<a href="{{url($employment->contract)}}" target="_blank">View </a>@endif</td>
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
@if(sizeof($activities) > 0)
<div class="row" style="padding:20px;">
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:50px;">SN</th>
			<th>Activity</th>
			<th>Place</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>#</th>
		</tr>
		<?php $count=1;?>
		@foreach($activities as $activity)
			<tr>	
				<td>{{$count}}</td>
				<td>{{$activity->event}}</td>
				<td>{{$activity->place}}</td>
				<td>{{date('d-m-Y',strtotime($activity->from_date))}}</td>
				<td>{{date('d-m-Y',strtotime($activity->to_date))}}</td>
				<td></td>
			</tr>
			<?php $count++?>
		@endforeach
	</table> 
</div>
@else
<div class="alert alert-warning">
	No Activity found
</div>
@endif

<div class="row">
	<div class="col-md-6">
		<h3>Courses Enrolled</h3>
	</div>
	<div class="col-md-6">
		<!-- <a href="#" class="btn yellow pull-right" style="margin-top:20px">Edit</a> -->
	</div>
</div>
@if(sizeof($courses) > 0)
<div class="row" style="padding:20px;">
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:50px;">SN</th>
			<th>Course Name</th>
			<th>Course License</th>
			<th>Prerequisite</th>
			<th>End Date</th>
			<th>#</th>
		</tr>
		<?php $count=1;?>
		@foreach($courses as $course)
			<tr>	
				<td>{{$count}}</td>
				<td>{{$course->course_name}}</td>
				<td>{{$course->license_name}}</td>
				<td>
					<?php if($course->prerequisite_id!=''){
						   $prerequisites = explode(',',$course->prerequisite_id);	
						   foreach ($prerequisites as $prerequisite) {
						   		echo $licenseList[$prerequisite].', ';
						   }
						}
						else{

							}?>
				</td>
				<td>{{date('d-m-Y',strtotime($course->end_date))}}</td>
				<td>@if($course->documents!='')<a href="{{url($course->documents)}}" target="_blank">View </a>@endif</td>
			</tr>
			<?php $count++?>
		@endforeach
	</table> 
</div>
@else
<div class="alert alert-warning">
	No Courses found
</div>
@endif
