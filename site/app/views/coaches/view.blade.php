<tr id="emp_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->employment}}</td>
	<td>{{$data->start_date}}</td>
	<td>{{$data->end_date}}</td>
	<td id="emp_{{$data->id}}">
		<a type="button" class="btn yellow " href="{{url('coach/editEmployment/'.$data->id)}}"  <i class="fa fa-edit"></i> Edit</a>

		<button type="button" class="btn red delete-div" div-id="emp_{{$data->id}}"  action="{{'coach/deleteEmployment/'.$data->id}}"> <i class="fa fa-remove"></i> Delete</button>

		

		

	</td>
</tr>