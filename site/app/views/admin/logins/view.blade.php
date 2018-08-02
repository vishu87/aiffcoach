<tr id="payment_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->name}}</td>
	<td>{{$data->username}}</td>
	<td>
		<a href="{{url('admin/logins/'.$data->id)}}" class="btn btn-sm blue">Login</a>

		<button action="{{('admin/reset-password/'.$data->id)}}" modal-title="Reset Password for - {{$data->name}}" class="btn btn-sm yellow edit-div">Reset Password</button>

		<button class="btn btn-sm btn-success edit-div" modal-title="Change Official Types of {{$data->name}}" action="{{('admin/changeOfficialType/'.$data->id)}}">Change Official Type</button>

		<button class="btn btn-sm btn-warning edit-div" div-id="payment_{{$data->id}}" count="{{$count}}" modal-title="Change Email of {{$data->name}}" action="{{('admin/changeEmail/'.$data->id)}}">Update Email</button>
	</td>
</tr>