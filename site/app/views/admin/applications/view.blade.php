<tr id="coach_{{$data->id}}">
	<td>{{($page_id-1)*$max_per_page + $count}}</td>
	<td>{{$data->course_name}}</td>
	<td>{{$data->venue}}</td>
	<td>
		<a href="{{url('/admin/viewCoachDetails/'.$data->coach_id)}}" target="_blank">{{$data->full_name}}</a>
	</td>
	<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>

	@if(Input::get('status') == 2 || Input::get('status') == 3)
		<td>
			{{($data->payment_status == 0)?'Not Approved':'Approved'}}
			@if($data->payment_status == 0)
				@if($data->amount != 0 && $data->bank_name != '' && $data->cheque_number != 0 && $data->cheque_number != '')
					<span class="badge badge-success badge-roundless">Available</span>
				@endif
			@endif
		</td>
	@endif

	<td>
		<a href="{{url('/control/applications/details/'.$data->id)}}" class="btn blue btn-sm" target="_blank">View</a>
		@if($data->status == 1 || $data->status == 2)

			@if($data->status != 2 )


				<button type="button" class="btn green btn-sm delete-div" div-id="coach_{{$data->id}}"  action="{{'admin/Applications/select/'.$data->id}}">Select <i class="fa fa-angle-double-right"></i></button>
			@endif
			<button type="button" class="btn yellow btn-sm delete-div" div-id="coach_{{$data->id}}"  action="{{'admin/Applications/not-select/'.$data->id}}">Not Select <i class="fa fa-angle-double-right"></i></button>



		@endif

		<button class="btn btn-sm btn-danger delete-div" div-id="coach_{{$data->id}}" action="{{'coach/applications/delete/'.$data->id}}"><i class="fa fa-remove"></i>
		</button>

	</td>
</tr>