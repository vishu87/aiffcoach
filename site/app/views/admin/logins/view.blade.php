<tr id="payment_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->name}}</td>
	<td>{{$data->username}}</td>
	<td>
		<a href="{{url('admin/logins/'.$data->id)}}" class="btn blue">Login</a>
		<button action="{{('admin/reset-password/'.$data->id)}}" modal-title="Reset Password for - {{$data->name}}" class="btn yellow edit-div">Reset Password</button>
		<button class="btn btn-success edit-div" modal-title="Change Official Type" action="{{('admin/changeOfficialType/'.$data->id)}}">Change Official Type</button>
	</td>
</tr>