<tr id="emp_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->employment}}</td>
	<td>{{date('d-m-Y',strtotime($data->start_date))}}</td>
	<td>{{date('d-m-Y',strtotime($data->end_date))}}</td>
	<td>@if($data->contract!='')<a href="{{url($data->contract)}}" target="_blank">view</a>@endif</td>
	<td id="emp_{{$data->id}}">
		<a type="button" class="btn yellow btn-sm" href="{{url('coach/editEmployment/'.$data->id)}}"  <i class="fa fa-edit"></i> Edit</a>
		<button type="button" class="btn red delete-div btn-sm" div-id="emp_{{$data->id}}"  action="{{'coach/deleteEmployment/'.$data->id}}"> <i class="fa fa-remove"></i> Delete</button>
	</td>
</tr>