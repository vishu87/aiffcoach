<tr id="activity_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->event}}</td>
	<td>{{date('d-m-Y',strtotime($data->from_date))}}</td>
	<td>{{date('d-m-Y',strtotime($data->to_date))}}</td>
	<td>{{$data->participants}}</td>
	<td>{{$data->position_role}}</td>

	<td>
		<a type="button" class="btn yellow btn-sm"  href="{{url('coach/activity/edit/'.$data->id)}}" count = "{{$count}}"> <i class="fa fa-edit"></i> Edit</a>

		<button type="button" class="btn red delete-div btn-sm" div-id="activity_{{$data->id}}"  action="{{'coach/activity/delete/'.$data->id}}"> <i class="fa fa-remove"></i> Delete</button>
	</td>
</tr>