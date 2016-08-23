<tr id="activity_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->name}}</td>
	<td>{{$data->license_name}}</td>
	<td>{{($data->authorised_by==1)?'AFC':'AIFF'}}</td>
	<td>{{$data->end_date}}</td>
	<td>{{$data->fees}}</td>
	<td>
		@if(!isset($status))
			@if(in_array($data->id,$check))
			<a type="button" class="btn btn-primary btn-sm " div-id="activity_{{$data->id}}"  href="{{url('coach/courses/details/'.$data->id.'/1')}}">Already Applied </a>
			@else
			<a type="button" class="btn blue btn-sm " div-id="activity_{{$data->id}}"  href="{{url('coach/courses/details/'.$data->id.'/1')}}">Apply</a>
			@endif
		@else
			<a type="button" class="btn blue btn-sm " div-id="activity_{{$data->id}}"  href="{{url('coach/courses/details/'.$data->id.'/2')}}">View</a>
		@endif	
	</td>
</tr>