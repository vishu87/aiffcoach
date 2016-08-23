@if(isset($data))
	<tr id="coach_{{$data->id}}">
		<td>{{$count}}</td>
		<td>{{$data->first_name}} {{$data->middle_name}} {{$data->last_name}}</td>
		<td>{{$data->email}} / {{$data->mobile}}</td>
		<td>{{$data->state_reference}}</td>
		<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>
		<td id="emp_{{$data->id}}" style="width:250px">		
			<button action="{{url('admin/viewCoach/'.$data->id)}}" class="btn btn-sm yellow details" modal-title="{{$data->first_name.' '.$data->middle_name.' '.$data->last_name}}">View</button>
			<a href="{{url('admin/viewCoachDetails/'.$data->id)}}" class="btn btn-sm blue" modal-title="{{$data->first_name.' '.$data->middle_name.' '.$data->last_name}}" target="_blank">Details</a>

			@if($data->status == 1 || $data->status==0)
				<button type="button" class="btn btn-sm green  approve-coach" action="{{'admin/markCoachStatus/1/'.$data->id}}" count="{{$count}}"  div-id="coach_{{$data->id}}">Approve</button>
			@elseif($data->status==2)
				<button type="button" class="btn btn-sm green hidden approve-coach" action="{{'admin/markCoachStatus/4/'.$data->id}}" count="{{$count}}"  div-id="coach_{{$data->id}}">Mark Inactive</button>
				<button type="button" class="btn btn-sm red  approve-coach" action="{{'admin/markCoachStatus/2/'.$data->id}}" count="{{$count}}"  div-id="coach_{{$data->id}}">Disapprove</button>
			@else
			<button type="button" class="btn btn-sm green  approve-coach" action="{{'admin/markCoachStatus/3/'.$data->id}}" count="{{$count}}"  div-id="coach_{{$data->id}}">Mark Active</button>	
			@endif
		</td>
	</tr>
@endif
@if(isset($coach))
	<div class="row">
		<div class="col-md-5">
			<div class="profile-pic">
				<img src="{{url($coach->photo)}}" alt="Image not Found">
			</div>
		</div>
		<div class="col-md-7">
			<div class="row" style="padding:10px;">
				<table class="table table-bordered table-hover">
					<tr>
						<td>Name</td>
						<td>{{$coach->first_name}} {{$coach->middle_name}} {{$coach->last_name}}</td>
					</tr>
					<tr>
						<td>DOB</td>
						<td>{{$coach->dob}}</td>
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
	<div class="row" >
		<div class="col-md-12">
			<div class="caption"><h2>Employment Details</h2></div>
		</div>
	</div>
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
@endif