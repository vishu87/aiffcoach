<tr id="activity_{{$data->id}}">
	<td>{{($page_id-1)*$max_per_page + $count}}</td>
	<td>{{$data->course_name}}</td>
	<td>
		<a href="{{url('/admin/viewCoachDetails/'.$data->coach_id)}}" target="_blank">{{$data->full_name}}</a>
		
	</td>
	<td>{{$data->remarks}}</td>
	<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>
	<td>
		<a href="{{url('/control/applications/details/'.$data->id)}}" class="btn blue btn-sm" target="_blank">View</a>		
	</td>
</tr>