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
			<button type="button" class="btn blue " div-id="activity_{{$data->id}}"  action="{{'coach/courses/apply/'.$data->id}}">Already Applied <i class="fa fa-arrow-right"></i></button>
			@else
			<button type="button" class="btn blue apply-course" div-id="activity_{{$data->id}}"  action="{{'coach/courses/apply/'.$data->id}}">Apply <i class="fa fa-arrow-right"></i></button>
			@endif
		@else
			<button type="button" class="btn red" div-id="activity_{{$data->id}}"  action="{{'coach/courses/apply/'.$data->id}}"><i class="fa fa-remove"></i> Not Open </button>
		@endif	
	</td>
</tr>