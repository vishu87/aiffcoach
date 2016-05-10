<tr id="activity_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->course_name}}</td>
	<td>{{$data->first_name.' '.$data->middle_name.' '.$data->last_name}}</td>
	<td>{{$data->remarks}}</td>
	<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>
	<td>
		@if(!isset($flag))
		<button type="button" class="btn blue approve-coach" div-id="activity_{{$data->id}}"  action="{{'admin/Applications/markApplication/'.$data->id}}">Approve <i class="fa fa-arrow-right"></i></button>
		@else
			<button type="button" class="btn red approve-coach" div-id="activity_{{$data->id}}"  action="{{'admin/Applications/markApplication/'.$data->id}}">Disaprove <i class="fa fa-arrow-right"></i></button>
		@endif			
	</td>
</tr>