<div class="portlet {{($count_log != 0)?'grey':'green'}} box {{($count_log++ != 0)?'opaque':''}}" style="margin-bottom:0">
	<div class="portlet-title" >
		<div class="caption">
			{{$log->closed_status()}}
			{{$log->get_status_name($application->full_name)}}
		</div>
		<div class="tools">
			<span>{{date("d-M-y H:i:s",strtotime($log->updated_at))}}</span>
			<a href="javascript:;" class="{{($log->closed == 1)?'expand':'collapse'}}" data-original-title="" title="">
			</a>
		</div>
	</div>
	<div class="portlet-body log-body" @if($log->closed == 1) style="display:none" @endif >
		@if($log->closed != 0)
			<div class="row">
				@if($log->status == 1)
					<div class="col-md-12" style="margin-bottom:10px; font-weight:bold; font-size:13px;">
						Payment has been confirmed
					</div>
				@endif
				<div class="col-md-12">
					<span>Remarks</span>
					<div class="log-remarks">
						{{$log->remarks}}
					</div>
				</div>
			</div>
		@else
			<div class="row">
				@if($log->status == 1)
					<div class="col-md-12" style="margin-bottom:10px; font-weight:bold; font-size:13px; color: #F00">
						Please fill the payment details and confirm the payment by submitting this form
					</div>
				@endif

				@if($log->checkAuth($application))
					{{Form::open(array('url'=>'/control/applications/log/'.$log->id,'method'=>'post','files'=>'true'))}}
						<div class="col-md-3 {{($log->status == 1 || $log->status == 4)?'hidden':''}}">
							<label>Status</label><br>
							{{Form::radio('type',1, true)}} Approve <br>
							{{Form::radio('type',4)}} Refer Back <br>
							{{Form::radio('type',5)}} Reject <br>
						</div>
						<div class="col-md-5">
							<label>Remarks <span class="required">*</span></label><br>
							{{Form::text('remarks','',["class"=>"form-control"])}}
						</div>
						<div class="col-md-12">
							<?php
								$submit_text = ($log->status == 1)?'Confirm Payment':'Submit';
							?>
							{{Form::submit($submit_text,["class"=>"btn green btn-sm","style"=>"margin-top:20px"])}}
						</div>
					{{Form::close()}}
				@else
					<div class="col-md-4">
						<span>Status</span>
						<div class="log-status">
							Pending
						</div>
					</div>
					<div class="col-md-8">
						@if(Session::get('privilege') == 2)
						<div style="background:#faabab; padding:10px;">
							{{Form::open(array('url'=>'/control/applications/log/'.$log->id,'method'=>'post','files'=>'true'))}}
								<div class="row">
									<div class="col-md-6">
										<label>Admin - Override</label><br>
										{{Form::radio('type',1, true)}} Approve <br>
										{{Form::radio('type',4)}} Refer Back <br>
										{{Form::radio('type',5)}} Reject <br>
									</div>
									<div class="col-md-6">
										{{Form::text('remarks','Auto Approve',["class"=>"form-control"])}}
									</div>
								</div>
								<div class="">
									{{Form::submit('Submit',["class"=>"btn green btn-sm","style"=>"margin-top:10px"])}}
								</div>
							{{Form::close()}}
						</div>
						@endif
					</div>
				@endif
			</div>
		@endif
	</div>
</div>