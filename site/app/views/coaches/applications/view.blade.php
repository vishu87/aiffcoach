<tr id="activity_{{$data->application_id}}">
	<td>{{$count}}</td>
	<td>{{$data->course_name}}</td>
	<td>{{$data->license_name}}</td>
	<td>{{($data->authorised_by==1)?'AFC':'AIFF'}}</td>
	<td>{{$data->end_date}}</td>
	<td>{{$data->fees}}</td>
	@if(!isset($value))

	<td>{{($data->status==1)?'Application Accepted':$data->remarks}}</td>
	<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>
	<td>{{($data->finalResult!='')?$resultStatus[$data->finalResult]:''}}</td>
	@endif	
	<td>
		<a class="btn blue btn-sm" href="{{url('control/applications/details/'.$data->application_id)}}">View</a>
	</td>
</tr>