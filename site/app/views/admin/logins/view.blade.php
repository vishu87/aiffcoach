<tr id="payment_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->name}}</td>
	<td>{{$data->username}}</td>
	<td>
		<a href="{{url('admin/logins/'.$data->id)}}" class="btn blue">Login</a>
	</td>
</tr>