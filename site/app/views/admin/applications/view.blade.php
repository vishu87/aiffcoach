<tr id="activity_{{$data->id}}">
	<td>{{($page_id-1)*$max_per_page + $count}}</td>
	<td>{{$data->course_name}}</td>
	<td>{{$data->first_name.' '.$data->middle_name.' '.$data->last_name}}</td>
	<td>{{$data->remarks}}</td>
	<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>
	<td>
		<a href="{{url('/control/applications/'.$data->id)}}" class="btn blue btn-sm" target="_blank">View</a>			
	</td>
</tr>