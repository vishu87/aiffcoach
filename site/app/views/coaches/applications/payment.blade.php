<div class="portlet box blue" style="margin-bottom:0">
	<div class="portlet-title" >
		<div class="caption">
			Payment Details
		</div>
	</div>
	<div class="portlet-body">
		{{Form::open(["url"=>"control/payments/".$payment->id,"method"=>"put","class"=>"check_form"])}}
			<div class="row">
				<div class="col-md-4 form-group">
					{{Form::radio('payment_method',1,true,["required"=>"true","class"=>"payment-radio","div-id"=>"payment-cheque"])}} Cheque
					<span class="error">{{$errors->first('payment_method')}}</span>
				</div>
				<div class="col-md-4 form-group">
					{{Form::radio('payment_method',2,($payment->payment_method == 2)?true:false,["required"=>"true","class"=>"payment-radio","div-id"=>"payment-draft"])}} Demand Draft
					<span class="error">{{$errors->first('payment_method')}}</span>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-6 form-group">
					<label>Cheque / Draft Number</label><span class="error"> *</span>
					{{Form::text('cheque_no',$payment->cheque_number,["class"=>"form-control payment_details","placeholder"=>"Cheque/ Draft Number..."])}}
					<span class="error">{{$errors->first('cheque_no')}}</span>
				</div>
				<?php
					$date = Payment::covertDate($payment->cheque_date);
				?>
				<div class="col-md-6 form-group">
					<label>Cheque / Draft Date</label><span class="error"> *</span>
					{{Form::text('cheque_date',$date,["class"=>"form-control payment_details datepicker","date_en"=>"true"])}}
					<span class="error">{{$errors->first('cheque_date')}}</span>
				</div>
				<div class="col-md-12 form-group">
					<label>Bank Name</label><span class="error"> *</span>
					{{Form::text('bank_name',$payment->bank_name,["class"=>"form-control payment_details","placeholder"=>"Bank Name"])}}
					<span class="error">{{$errors->first('bank_name')}}</span>
				</div>
				<div class="col-md-12 form-group">
					<label>Amount</label><span class="error"> *</span>
					{{Form::text('amount',$payment->amount,["class"=>"form-control payment_details"])}}
					<span class="error">{{$errors->first('amount')}}</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 form-group">
					<label>Remarks</label>
					{{Form::text('remarks',$payment->remarks,["class"=>"form-control"])}}
				</div>
			</div>
			<div style="">
				<button type="submit" class="btn blue">Submit</button>
				@if(Session::get('privilege') == 2 && $payment->status == 0)
					<a href="{{url('/admin/payment/approve/'.$payment->id)}}" class="btn green">Approve Payment</a>
				@endif
			</div>
		{{Form::close()}}
	</div>
</div>