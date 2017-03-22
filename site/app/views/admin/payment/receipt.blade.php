<div class="container">
	<div class="full-width">
		<div class="logo">
			<img src="{{url('assets/img/aiff.png')}}">
		</div>
		<hr>
	</div>

	<div class="content">
		<h1>Payment Receipt</h1>
		<p>
			Your payment is Received with {{$payment->bank_name}} DD No- {{$payment->cheque_number}} , DD Date - {{date('d-m-Y',strtotime($payment->cheque_date))}} , Amount - Rs. {{$payment->amount}}
		</p>

	</div>
	<div class="footer-image">
		<!-- <img src="{{url('assets/img/receipt_border.png')}}"> -->
	</div>
</div>

<style type="text/css">
	.container{
		width: 100%;
		font-size: 20px;
	}
	.content{
		position: relative;
		width: 100%;
		min-height: 490px !important;
		margin-top: 25px;
	}
	.content h1{
		text-align: center;	
		font-size: 26px;
	}

	.footer-image{
		width: 100%;
	}
	.footer-image img{
		width: 300px;
		position: absolute;
		right: 0;
		bottom: 0;
	}
	.logo{
		width: 170px;
	}
	.logo img{
		width: 100%
	}
</style>