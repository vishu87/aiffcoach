<tr id="activity_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->name}}</td>
	<td>{{$data->venue}}</td>
	<td>{{date("d-m-Y",strtotime($data->start_date))}}</td>
	<td>{{date("d-m-Y",strtotime($data->registration_start))}}</td>
	<td>{{date("d-m-Y",strtotime($data->registration_end))}}</td>
	<td>{{$data->fees}}</td>
	<td>
		<a type="button" class="btn blue btn-sm " div-id="activity_{{$data->id}}"  href="{{url('coach/courses/details/'.$data->id)}}">View</a>
	</td>
</tr>