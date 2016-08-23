<tr id="activity_{{$data->application_id}}">
	<td>{{$count}}</td>
	<td>{{$data->course_name}}</td>
	<td>{{$data->license_name}}</td>
	<td>{{($data->authorised_by==1)?'AFC':'AIFF'}}</td>
	<td>{{$data->end_date}}</td>
	<td>{{$data->fees}}</td>
	@if(!isset($value))

	<td>{{($data->status==1)?'Application Accepted':$data->remarks}}</td>
	<td>{{(isset($status[$data->status]))?$status[$data->status]:''}}</td>
	<td>{{($data->finalResult!='')?$resultStatus[$data->finalResult]:''}}</td>
	@endif	
	<td>
		@if(!isset($value))
			@if(strtotime($data->end_date)>strtotime('now'))
				<button type="button" class="btn red btn-sm delete-div" div-id="activity_{{$data->application_id}}"  action="{{'coach/applications/delete/'.$data->application_id}}"> <i class="fa fa-remove"></i> Cancel</button>
			@endif	
		@else
			@if($value==1)
				<button type="button" class="btn green btn-sm approve-coach" div-id="activity_{{$data->application_id}}"  action="{{'coach/activity/delete/'.$data->application_id}}">Apply <i class="fa fa-arrow-right"></i></button>
			@endif	
		@endif

		@if($data->status==1 || $data->status==0)
			<button type="button" class="btn blue btn-sm add-div" div-id="activity_{{$data->application_id}}" count="{{$count}}" modal-title="Select Payment Option"  action="{{'coach/Payment/'.$data->application_id}}">Pay Fee </button>
		@endif	
		@if($data->finalResult!='')	
		<button type="button" class="btn yellow btn-sm edit-div"  modal-title="MarksSheet for {{$data->course_name}}" action="{{('coach/applications/viewMarks/'.$data->application_id)}}"> View Marks</button>
		@endif
	</td>
</tr>