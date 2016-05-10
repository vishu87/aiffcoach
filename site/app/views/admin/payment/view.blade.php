<tr id="payment_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->first_name.' '.$data->middle_name.' '.$data->last_name}}</td>
	<td>{{$data->course_name}}</td>
	<td>{{$data->bank_name}}</td>
	<td>{{$data->fees}}</td>
	<td>@if($data->payment_method==1) Cheque @elseif($data->payment_method==2) Draft @elseif($data->payment_method==3) Cash @endif</td>
	<td>{{$data->remarks}}</td>
	<td>{{(isset($status[$data->status_app]))?$status[$data->status_app]:''}}</td>

	<td>
		@if($data->status_app==3)
			<button type="button" class="btn red approve-coach" count="{{$count}}" div-id="payment_{{$data->id}}"  action="{{'admin/Payment/disapprovePaymentStatus/'.$data->id}}">Disapprove <i class="fa fa-arrow-right"></i></button>
		@elseif($data->status_app==2)
			<button type="button" class="btn blue approve-coach" count="{{$count}}" div-id="payment_{{$data->id}}"  action="{{'admin/Payment/approvePaymentStatus/'.$data->id}}">Approve <i class="fa fa-arrow-right"></i></button>
		@elseif($data->status_app==1)
			Payment Pending
		@elseif($data->status_app==0)
		    Approval Pending
		@endif
	</td>
</tr>