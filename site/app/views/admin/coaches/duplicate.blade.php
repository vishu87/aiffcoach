@if(sizeof($coaches) < 1)
<div class="row">
	<div class="col-md-12">
		<h4 class="modal-title">No duplicate records found</h4>
	</div>
</div>
@else
<table class="table">
	<thead>
		<tr>
			<th>SN</th>
			<th>Photo</th>
			<th>Reg Id</th>
			<th>Name</th>
			<th>DOB</th>
			<th>Email</th>
			<th>Mobile</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php $sn = 1;?>
		@foreach($coaches as $coach)
		<tr>
			<th>{{$sn++}}</th>
			<th><img src="{{url($coach->photo)}}" style="width: 120px"></th>
			<th>{{$coach->registration_id}}</th>
			<th><a href="{{url('/admin/viewCoachDetails/'.$coach->id)}}" target="_blank">{{$coach->full_name}}</a></th>
			<th>{{date('d-m-Y',strtotime($coach->dob))}}</th>
			<th>{{$coach->email}}</th>
			<th>{{$coach->mobile}}</th>
			<th>{{(isset($status[$coach->status]))?$status[$coach->status]:''}}</th>
		</tr>
		@endforeach
	</tbody>
</table>
@endif