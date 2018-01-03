<tr id="emp_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->employment}}</td>

	<td>{{(isset($emp_status[$data->emp_status]))?$emp_status[$data->emp_status]:''}}</td>

	<td>{{$data->referral_name.'<br>'.$data->referral_contact}}</td>
	<td>
		@if($data->start_date)
			{{date('d-m-Y',strtotime($data->start_date))}}
		@endif
	</td>
	<td>
		@if($data->end_date)
			{{date('d-m-Y',strtotime($data->end_date))}}
		@endif
	</td>
	<td>
		@if($data->contract!='')
			Contract - <a href="{{url($data->contract)}}" target="_blank">view</a> <br>
		@endif
		@if($data->cv!='')
			CV - <a href="{{url($data->cv)}}" target="_blank">view</a>
		@endif
	</td>
	<td id="emp_{{$data->id}}" style="width: 120px">
		<a type="button" class="btn yellow btn-sm" href="{{url('coach/editEmployment/'.$data->id)}}"  <i class="fa fa-edit"></i> Edit</a>
		<button type="button" class="btn red delete-div btn-sm" div-id="emp_{{$data->id}}"  action="{{'coach/deleteEmployment/'.$data->id}}"> <i class="fa fa-remove"></i></button>
	</td>
</tr>