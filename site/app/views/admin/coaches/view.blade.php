@if(isset($data))
	<tr id="coach_{{$data->id}}">
		<td>{{($page_id-1)*$max_per_page + $count}}</td>
		<td><a href="{{url('/admin/viewCoachDetails/'.$data->id)}}" target="_blank">{{$data->full_name}}</a></td>
		<td>{{$data->registration_id}}</td>
		<td>{{$data->email}} / {{$data->mobile}}</td>
		<td>{{$data->state_reference}}</td>
		<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>
		<td id="emp_{{$data->id}}">		
			<a href="{{url('admin/viewCoachDetails/'.$data->id)}}" class="btn btn-sm blue" modal-title="{{$data->first_name.' '.$data->middle_name.' '.$data->last_name}}" target="_blank">Profile</a>
			@if(Auth::user()->privilege == 2 && $data->status == 3)
				<button class="btn btn-sm btn-danger delete-div" div-id="coach_{{$data->id}}" action="{{'admin/deleteCoachProfile/'.$data->id}}"><i class="fa fa-remove"></i></button>
			@endif
		</td>
	</tr>
@endif