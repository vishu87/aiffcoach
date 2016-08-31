<tr id="activity_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->course_name}}</td>
	<td>{{$data->license_name}}</td>
	<td>{{$data->first_name.' '.$data->middle_name.' '.$data->last_name}}</td>
	<td>{{$data->remarks}}</td>
	<td>{{($data->finalResult!='')?$resultStatus[$data->finalResult]:''}}</td>
	<td>
		<button type="button" class="btn btn-sm blue edit-div" modal-title="Result " div-id="activity_{{$data->id}}" count="{{$count}}" action="{{('/resultAdmin/result/view/'.$data->id)}}">View </button>
		<a type="button" class="btn yellow  btn-sm "  href="{{url('resultAdmin/result/editParameterMarks/'.$data->id)}}"> <i class="fa fa-edit"></i> Edit</a>		
	</td>
</tr>
