<?php $count_main = 1; ?>
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
				<div class="row" >
					<table class="table table-bordered table-hover" style="width:100%">
						<tr>
							<td>DOB<br>
								<b>{{date("d-m-Y",strtotime($coach->dob))}}</b>
							</td>
						</tr><tr>
							<td>Email<br>
								<b>{{$coach->email}}</b>
							</td>
						</tr>
						<tr>
							<td>Gender<br>
								<b>{{($coach->gender==1)?'Male':'Female'}}</b>
							</td>
						</tr><tr>
							<td>State of Registration<br>
								<b>{{$coach->state_registation}}</b>
							</td>
						</tr>
						<tr>
							<td>Mobile<br><b>{{$coach->mobile}}</b></td>
						</tr>

						<tr>
							<td>Address<br>
								<b>{{$coach->address1.' '.$coach->address2.' '.$coach->city.' '.$coach->pincode}}</b>
							</td>
						</tr>
						@if($coach->is_doctor ==1 && $coach->doctor_degree != '')
						<tr>
							<td>Doctor / Physiotherapist Degree<br>
								<a style="font-weight: bold;color:#222" href="{{url($coach->doctor_degree)}}" target="_blank">View</a>
							</td>
						</tr>
						@endif

					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div style="margin-left:30px;">
			<h3 class="page-title">Status - {{$coachStatus[$coach->status]}}</h3>
			@if($coach->check_admin())
				<?php $entity_type=1; $entity_id = $coach->id; $show_refer = 1; ?>
				@include('approve_box')
			@endif
			{{Approval::approval_html(1, $coach->id)}}
		</div>
	</div>
</div>
<div>
	<h3>Documents</h3>
</div>
@if(sizeof($documents) > 0)
<?php $entity_type=2; ?>
<div class="row" style="padding:20px;">
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:50px;">SN</th>
			<th>Document Name</th>
			<th>Document Number</th>
			<th>Expiry Date</th>
			<th>Document</th>
			<th>Status</th>
			<th>Delete</th>
		</tr>
		<?php $count=1;?>
		@foreach($documents as $document)
			<tr id="document_{{$document->id}}">	
				<td>{{$count}}</td>
				<td>{{$document->document_name}}</td>
				<td>{{$document->number}}</td>
				<td>{{($document->expiry_date)?date('d-m-Y',strtotime($document->expiry_date)):''}}</td>
				<td>
					@if($document->file!='')
						<a href="{{url($document->file)}}" target="_blank">View </a>
					@endif
				</td>
				<td>
					{{isset($ApprovalStatus[$document->status])?$ApprovalStatus[$document->status]:''}}
				</td>
				<td>
					<button type="button" class="btn red btn-sm delete-div" div-id="document_{{$document->id}}"  action="{{'coach/addDocument/delete/'.$document->id}}"><i class="fa fa-remove"></i></button>
				</td>
			</tr>
			<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
				<td colspan="7">
					<div class="row" style="">
						@if($document->check_admin())
						<div class="col-md-6">
							<?php $entity_id = $document->id; $show_refer = 0;?>
							@include('approve_box')
						</div>
						@endif
						<div class="col-md-6">
							{{Approval::approval_html($entity_type, $document->id)}}
						</div>
					</div>
				</td>
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
<?php $entity_type=3; ?>
<div class="row" style="padding:20px;">
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:50px;">SN</th>
			<th>License Name</th>
			<th>License Number</th>
			<th>Issue Date</th>
			<th>Expiry Date</th>
			<th>Document</th>
			<th>Status</th>
			<th>Delete</th>
		</tr>
		<?php $count=1;?>
		@foreach($coachLicense as $license)
			<tr id="license_{{$license->id}}">	
				<td>{{$count}}</td>
				<td>{{$license->license_name}}
				@if($license->equivalent_license != '' )
					<br>({{$license->equivalent_license}})
				@endif
				@if($license->recc == 1 && $license->recc_document != '')
					<br> <a href="{{url($license->recc_document)}}" target="_blank">RECC Approval</a>
				@endif
				</td>
				<td>{{$license->number}}</td>
				<td>{{date('d-m-Y',strtotime($license->start_date))}}</td>
				<td>{{($license->end_date)?date('d-m-Y',strtotime($license->end_date)):''}}</td>
				<td>@if($license->document!='')<a href="{{url($license->document)}}" target="_blank">View </a>@endif</td>
				<td>{{$ApprovalStatus[$license->status]}}</td>
				<td>
					<button type="button" class="btn red btn-sm delete-div" div-id="license_{{$license->id}}"  action="{{'coach/coachLicense/delete/'.$license->id}}"> <i class="fa fa-remove"></i></button>
					<button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-xs blue showApprovals hidden"><i class="fa fa-angle-double-right"></i> Details</button>
				</td>
			</tr>
			<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
				<td colspan="8">
					<div class="row" style="">
						
						@if($license->check_admin())
						<div class="col-md-6">
							<?php $entity_id = $license->id; $show_refer = 0;?>
							@include('approve_box')
						</div>
						@endif

						<div class="col-md-6">
							{{Approval::approval_html($entity_type, $license->id)}}
						</div>
					</div>
				</td>
			</tr>
			<?php $count++?>
		@endforeach
	</table> 
</div>
@else
<div class="alert alert-warning">
	No License found
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
<?php $entity_type=4; ?>
<div class="row" style="padding:20px;">
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:50px;">SN</th>
			<th>Employment</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Employment Status</th>
			<th>Status</th>
			<th>Document</th>
			<th style="display: none">#</th>
		</tr>
		<?php $count=1;?>
		@foreach($employmentDetails as $employment)
			<tr>	
				<td>{{$count}}</td>
				<td>{{$employment->employment}}</td>
				<td>{{date('d-m-Y',strtotime($employment->start_date))}}</td>
				<td>@if($employment->end_date){{date('d-m-Y',strtotime($employment->end_date))}}@endif</td>
				<td>
					<?php $emp_status = EmploymentDetails::emp_status(); ?>
					{{(isset($emp_status[$employment->emp_status]))?$emp_status[$employment->emp_status]:''}}
				</td>
				<td>{{$ApprovalStatus[$employment->status]}}</td>
				<td>
					@if($employment->contract!='')<a href="{{url($employment->contract)}}" target="_blank">Contract<br></a>@endif
					@if($employment->cv!='')<a href="{{url($employment->cv)}}" target="_blank">CV<br></a>@endif
				</td>
				<td style="display: none">
					<button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-xs blue showApprovals"><i class="fa fa-angle-double-right"></i> Details</button></td>
				</td>
			</tr>
			<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
				<td colspan="8">
					<div class="row" style="">
						
						@if($employment->check_admin())
						<div class="col-md-6">
							<?php $entity_id = $employment->id; $show_refer = 0;?>
							@include('approve_box')
						</div>
						@endif

						<div class="col-md-6">
							{{Approval::approval_html($entity_type, $employment->id)}}
						</div>
					</div>
				</td>
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
<div style="display: none">
	<h3>Activity Details</h3>
</div>
@if(sizeof($activities) > 0)
<?php $entity_type=5; ?>
<div class="row" style="padding:20px;display: none">
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:50px;">SN</th>
			<th>Activity</th>
			<th>Place</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Status</th>
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
				<td>{{$ApprovalStatus[$activity->status]}}</td>
				<td>
					<button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-xs blue showApprovals"><i class="fa fa-angle-double-right"></i> Details</button></td>
				</td>
			</tr>
			<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
				<td colspan="8">
					<div class="row" style="">
						
						@if($activity->check_admin())
						<div class="col-md-6">
							<?php $entity_id = $activity->id; $show_refer = 0;?>
							@include('approve_box')
						</div>
						@endif

						<div class="col-md-6">
							{{Approval::approval_html($entity_type, $activity->id)}}
						</div>
					</div>
				</td>
			</tr>
			<?php $count++?>
		@endforeach
	</table> 
</div>
@else
<div class="alert alert-warning" style="display: none">
	No Activities found
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
			<th>Venue</th>
			<th>Application Date</th>
			<th>Manage</th>
		</tr>
		<?php $count=1;?>
		@foreach($courses as $course)
			<tr>	
				<td>{{$count}}</td>
				<td>{{$course->course_name}}</td>
				<td>{{$course->venue}}</td>
				<td>{{date('d-m-Y',strtotime($course->created_at))}}</td>
				<td>
					<a href="{{url('control/applications/details/'.$course->id)}}" class="btn btn-xs blue">View</a>
				</td>
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
