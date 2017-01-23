<tr id="coach_{{$data->id}}">
	<td>{{($page_id-1)*$max_per_page + $count}}</td>
	<td>{{$data->course_name}}</td>
	<td>{{$data->venue}}</td>
	<td>
		<a href="{{url('/admin/viewCoachDetails/'.$data->coach_id)}}" target="_blank">{{$data->full_name}}</a>
		
	</td>
	<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>
	<td>
		<a href="{{url('/control/applications/details/'.$data->id)}}" class="btn blue btn-sm" target="_blank">View</a>
		@if($data->status == 1)
		<button type="button" class="btn green btn-sm delete-div" div-id="coach_{{$data->id}}"  action="{{'admin/Applications/select/'.$data->id}}">Select <i class="fa fa-angle-double-right"></i></button>
		@endif

		<button class="btn btn-sm btn-danger delete-div" div-id="coach_{{$data->id}}" action="{{'coach/applications/delete/'.$data->id}}"><i class="fa fa-remove"></i>
		</button>

	</td>
</tr>