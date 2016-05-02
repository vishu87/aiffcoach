<tr id="course_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->name}}</td>
	<td>{{$data->start_date}}</td>
	<td>{{$data->end_date}}</td>
	<td>{{$data->license_name}} - {{($data->authorised_by==1)?'AFC':'AIFF'}}</td>

	<td>
		<a type="button" class="btn yellow "  href="{{url('admin/Courses/edit/'.$data->id)}}" count = "{{$count}}"> <i class="fa fa-edit"></i> Edit</a>

		<button type="button" class="btn red delete-div" div-id="course_{{$data->id}}"  action="{{'admin/Courses/delete/'.$data->id}}"> <i class="fa fa-remove"></i> Delete</button>
	</td>
</tr>