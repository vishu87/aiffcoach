<tr id="course_{{$data->id}}">
	<td>{{$count}}</td>
	<td>
		{{$data->name}}
		@if($data->postponed == 1)
			<span class="badge badge-danger badge-roundless"> Postponed </span>
		@endif
	</td>
	<td>{{date('d-m-Y',strtotime($data->start_date))}}</td>
	<td>{{date('d-m-Y',strtotime($data->registration_start))}}</td>
	<td>{{date('d-m-Y',strtotime($data->registration_end))}}</td>
	<td>{{$data->venue}}</td>
	<td style="min-width: 170px">
		<a type="button" class="btn yellow btn-sm "  href="{{url('admin/Courses/edit/'.$data->id)}}" count = "{{$count}}"> <i class="fa fa-edit"></i> Edit</a>

		<button type="button" class="btn btn-sm red delete-div" div-id="course_{{$data->id}}"  action="{{'admin/Courses/delete/'.$data->id}}"> <i class="fa fa-remove"></i> Delete</button>
	</td>
</tr>