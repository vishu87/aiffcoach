<tr id="activity_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->course_name}}</td>
	<td>{{$data->first_name.' '.$data->middle_name.' '.$data->last_name}}</td>
	<td>{{$data->remarks}}</td>
	<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>
	<td>
		@if($flag==0)
		<button type="button" class="btn blue mark-application" div-id="activity_{{$data->id}}" count="{{$count}}"  action="{{'admin/Applications/markApplication/'.$data->id}}">Approve <i class="fa fa-arrow-right"></i></button>
		@elseif($flag==1)
			<button type="button" class="btn red mark-application" div-id="activity_{{$data->id}}" count="{{$count}}" action="{{'admin/Applications/markApplication/'.$data->id}}">Disaprove <i class="fa fa-arrow-right"></i></button>
		@else
			{{(isset($status[$data->status]))?$status[$data->status]:''}}	
		@endif			
	</td>
</tr>