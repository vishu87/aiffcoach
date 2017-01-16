<div class="portlet box blue" style="margin-bottom:0">
	<div class="portlet-title" >
		<div class="caption">
			Payment Details
		</div>
	</div>
	<div class="portlet-body">
		@if($payment->status == 1)
			<div class="alert alert-success">Payment has been approved</div>
		@endif
		<div class="row">
			<div class="col-md-12 form-group">
				<label>Payment Method</label><br>
				<div class="log-status">
					{{($payment->payment_method == 1)?'Cheque':'Demand Draft'}}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 form-group">
				<label>Cheque / Draft Number</label><br>
				<div class="log-status">
					{{$payment->cheque_number}}
				</div>
			</div>
			<?php
				$date = Payment::covertDate($payment->cheque_date);
			?>
			<div class="col-md-6 form-group">
				<label>Cheque / Draft Date</label><br>
				<div class="log-status">
					{{$date}}
				</div>
			</div>
			<div class="col-md-12 form-group">
				<label>Bank Name</label><br>
				<div class="log-status">
					{{$payment->bank_name}}
				</div>
			</div>
			<div class="col-md-12 form-group">
				<label>Amount</label><br>
				<div class="log-status">
					{{$payment->amount}}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 form-group">
				<label>Remarks</label><br>
				<div >
					{{$payment->remarks}}
				</div>
			</div>
		</div>
		@if(Session::get('privilege') == 2 && $payment->status == 1)
			<a href="{{url('/admin/payment/approve/'.$payment->id)}}" class="btn red">Disapprove Payment</a>
		@endif
	</div>

</div>