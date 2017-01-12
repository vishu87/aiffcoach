<tr id="activity_{{$data->application_id}}">
	<td>{{$count}}</td>
	<td>{{$data->course_name}}, {{$data->venue}}</td>
	<td style="width: 100px">{{date("d-m-Y",strtotime($data->created_at))}}</td>
	<td>{{$data->fees}} Rs</td>
	<td>
		{{(isset($status[$data->status]))?$status[$data->status]:''}}
		@if($data->status == 1)
			<span class="badge badge-danger badge-roundless"> Please fill payment details </span>
		@endif
	</td>
	<td style="width: 200px">
		<a class="btn blue btn-sm" href="{{url('control/applications/details/'.$data->application_id)}}">View</a>
		<a class="btn default btn-sm" href="{{url('coach/courses/details/'.$data->course_id)}}">View Course</a>
		@if($data->status == 0 || $data->status == 4)
			<button class="btn btn-sm btn-danger delete-div" div-id="activity_{{$data->application_id}}" action="{{'coach/applications/delete/'.$data->id}}"><i class="fa fa-remove"></i>
			</button>
		@endif
	</td>
</tr>