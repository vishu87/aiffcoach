<div class="row">
	<div class="col-md-6">
		<span class="page-title">Select an Option To Pay Rs. {{$application->fees}}</span>
	</div>
</div>
{{Form::open(["url"=>"coach/Payment/option/".$application->id,"method"=>"post","class"=>"ajax_add_payment check_form"])}}
	<div class="row">
		<div class="col-md-2 form-group">
			{{Form::radio('payment_method',1,'',["required"=>"true","class"=>"payment-radio","div-id"=>"payment-cheque"])}}{{Form::label('Cheque')}}
			<span class="error">{{$errors->first('payment_method')}}</span>
		</div>
		<div class="col-md-2 form-group">
			{{Form::radio('payment_method',2,'',["required"=>"true","class"=>"payment-radio","div-id"=>"payment-draft"])}}{{Form::label('Demand Draft')}}
			<span class="error">{{$errors->first('payment_method')}}</span>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-4 form-group">
			<label>Cheque / Draft Number</label><span class="error"> *</span>
			{{Form::text('cheque_no','',["class"=>"form-control payment_details","placeholder"=>"Cheque/ Draft Number..."])}}
			<span class="error">{{$errors->first('cheque_no')}}</span>
		</div>
		<div class="col-md-4 form-group">
			<label>Cheque / Draft Date</label><span class="error"> *</span>
			{{Form::text('cheque_date','',["class"=>"form-control payment_details datepicker","date_en"=>"true"])}}
			<span class="error">{{$errors->first('cheque_date')}}</span>
		</div>
		<div class="col-md-4 form-group">
			<label>Bank Name</label><span class="error"> *</span>
			{{Form::text('bank_name','',["class"=>"form-control payment_details","placeholder"=>"Bank Name..."])}}
			<span class="error">{{$errors->first('bank_name')}}</span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 form-group">
			<label>Remarks</label>
			{{Form::textarea('remarks','',["class"=>"form-control","placeholder"=>"Remark For Payment","rows"=>3])}}
		</div>
	</div>
	<div style="margin-top:40px;text-align:center">
		<button type="submit" class="btn blue">Proceed</button>
	</div>
{{Form::close()}}