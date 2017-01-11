<?php $count_main = 1; ?>
<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">
			Pending Approvals
		</h3>
	</div>
	<div class="col-md-5 hidden ">
		<a class="btn green pull-right" href="#">Export Excel</a>
	</div>
</div>

@if(Session::has('success'))
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		{{Session::get('success')}}
	</div>
@endif
@if(Session::has('failure'))
	<div class="alert alert-danger">
    	<button type="button" class="close" data-dismiss="alert">×</button>
    	<i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
   	</div>
@endif


<div class="row">
	<div class="col-md-6">
		@if(isset($documents))
			{{ Form::open(array('url' => 'pendingApprovals/pendingDocument', 'method' => 'GET','role' => 'form','class'=>"")) }}
		@elseif(isset($coachLicense))
			{{ Form::open(array('url' => 'pendingApprovals/pendingLicenses', 'method' => 'GET','role' => 'form','class'=>"")) }}
		@elseif(isset($employmentDetails))
			{{ Form::open(array('url' => 'pendingApprovals/pendingEmploymentDetails', 'method' => 'GET','role' => 'form','class'=>"")) }}
		@else(isset($activities))
			{{ Form::open(array('url' => 'pendingApprovals/pendingActivities', 'method' => 'GET','role' => 'form','class'=>"")) }}
		@endif
		<div class="row">
			<div class="form-group col-md-6">
				<label>Registration ID</label>
				{{Form::text('registration_id',(Input::has('registration_id'))?Input::get('registration_id'):'',["class"=>"form-control"])}}
				<span class="error"><?php echo $errors->first('registration_id'); ?></span>
			</div>
			<div class="form-group col-md-6">
				<label>Name</label>
				{{Form::text('official_name',(Input::has('official_name'))?Input::get('official_name'):'',["class"=>"form-control"])}}
				<span class="error"><?php echo $errors->first('official_name'); ?></span>
			</div>
		</div>
		<div style="margin-bottom:20px;">
			<button class="btn green" type="submit">Search</button>
		</div>
		{{Form::close()}}
	</div>
	<div class="col-md-6">
		@if(isset($total))
			<div class="row" style="margin:20px 0;">
				<div class="col-md-3">
					<h3 class="page-title"></h3>
				</div>
				<div class="col-md-9">
					<div class="pull-right hidden" style="font-style:italic; margin-top:5px;  margin-left:10px" >
						<a  href="{{url($input_string.'&page=1&show_all=true')}}"> Show All ({{$total}})</a>
					</div>
					@if(Input::has('show_all'))
						<div class="pull-right" style="font-style:italic; margin-top:5px; margin-right:10px">
							<a  href="{{url($input_string.'&page=1')}}"> Paginate</a>
						</div>
					@endif
					@if(isset($total) && !Input::has('show_all'))
					<?php
						$max_page = $page_id + 9;
						if($max_page > $total_pages) $max_page = $total_pages;

						$first_page = $page_id - 1;
						if($first_page <= 0) $first_page = $page_id;
					?>
					<ul class="pagination pull-right" style="margin: 0 0 0 10px">
						<li>
							<a  href="{{url($input_string.'&page=1')}}"><i class="fa fa-angle-double-left"></i></a>
						</li>
						@if($page_id >= 3)
						<li>
							<a  href="{{url($input_string.'&page='.($page_id - 2))}}"><i class="fa fa-angle-left"></i></a>
						</li>
						@endif
						@for($x = $first_page ; $x <= $max_page; $x++  )
							<li>
								@if($x != $page_id )
									<a  href="{{url($input_string.'&page='.$x)}}">{{$x}}</a>
								@else
									<a  href="javascript:;"><b>{{$x}}</b></a>
								@endif
							</li>
						@endfor
						@if($x < $total_pages)
						<li>
							<a  href="{{url($input_string.'&page='.$x)}}"><i class="fa fa-angle-right"></i></a>
						</li>
						@endif
						<li>
							<a  href="{{url($input_string.'&page='.$total_pages)}}"><i class="fa fa-angle-double-right"></i></a>
						</li>
					</ul>
					<div class="pull-right" style="font-style:italic; margin-top:5px;">
						Showing {{ ($page_id - 1)*$max_per_page + 1  }} - {{ ($page_id*$max_per_page > $total)?$total:$page_id*$max_per_page  }} of <b>{{$total}}</b>
					</div>
					@endif
				</div>
			</div>
		@endif
	</div>
</div>
<ul class="nav nav-tabs">
	<li class="{{($docType=='pendingDocument')?'active':''}}">
		<a href="{{url('pendingApprovals/pendingDocument?'.$link_string)}}" >
		Documents </a>
	</li>
	<li class="{{($docType=='pendingLicenses')?'active':''}}">
		<a href="{{url('pendingApprovals/pendingLicenses?'.$link_string)}}" >
		License </a>
	</li>
	<li class="{{($docType=='pendingEmploymentDetails')?'active':''}}">
		<a href="{{url('pendingApprovals/pendingEmploymentDetails?'.$link_string)}}" >
		Employment Details </a>
	</li>
	<li class="{{($docType=='all')?'active':''}}">
		<a href="{{url('pendingApprovals/pendingDocument?'.$link_string.'&view=all')}}" >
		All Document </a>
	</li>
	<!-- <li class="{{($docType=='pendingActivities')?'active':''}}">
		<a href="{{url('pendingApprovals/pendingActivities?'.$link_string)}}" >
		Activities </a>
	</li> -->
</ul>

@if(isset($documents))
	<div>
		<!-- <h3>Pending Documents</h3> -->
	</div>
	@if(sizeof($documents) > 0)
	<?php $entity_type=2; ?>
		<div class="row" style="padding:20px;">
			<table class="table table-bordered table-hover">
				<tr>
					<th style="width:50px;">SN</th>
					<th>Coach Name</th>
					<th>doc id</th>
					<th>Document Name</th>
					<th>Document Number</th>
					<th>Expiry Date</th>
					<th>Document</th>
					<th>Status</th>
					<th>#</th>
				</tr>
				<?php $count=1;?>
				@foreach($documents as $document)
					<tr>	
						<td>{{($page_id-1)*$max_per_page + $count}}</td>
						<td>
							<a href="{{url('/admin/viewCoachDetails/'.$document->coach_id)}}" target="_blank">{{$document->full_name}}</a>
						</td>
						<td>{{$document->id}}</td>
						<td>{{$document->document_name}}</td>
						<td>{{$document->number}}</td>
						<td>@if($document->document_id != 2) {{date('d-m-Y',strtotime($document->expiry_date))}} @endif </td>
						<td>@if($document->file!='')<a href="{{url($document->file)}}" target="_blank">View </a>@endif
						</td>
						<td>{{isset($ApprovalStatus[$document->status])?$ApprovalStatus[$document->status]:''}}</td>
						<td><button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-xs blue showApprovals"><i class="fa fa-angle-double-right"></i> Details</button></td>
					</tr>
					<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
						<td colspan="8">
							<div class="row" style="">
								@if($document->check_admin())
								<div class="col-md-6">
									<?php $entity_id = $document->id;?>
									@include('approve_box')
								</div>
								@endif
								<div class="col-md-6">
									{{Approval::approval_html($entity_type, $document->id)}}
								</div>
							</div>
						</td>
					</tr>
					<?php $count++?>
				@endforeach
			</table> 
		</div>
	@else
	<div class="alert alert-warning">
		No pending documents found for approved coaches
	</div>
	@endif
@endif

@if(isset($coachLicense))
	<div>
		<!-- <h3>Pending Licenses</h3> -->
	</div>
	@if(sizeof($coachLicense) > 0)
	<?php $entity_type=3; ?>
	<div class="row" style="padding:20px;">
		<table class="table table-bordered table-hover">
			<tr>
				<th style="width:50px;">SN</th>
				<th>Coach Name</th>
				<th>License Name</th>
				<th>License Number</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Document</th>
				<th>Status</th>
				<th>#</th>
			</tr>
			<?php $count=1;?>
			@foreach($coachLicense as $license)
				<tr>	
					<td>{{($page_id-1)*$max_per_page + $count}}</td>
					<td>
						<a href="{{url('/admin/viewCoachDetails/'.$license->coach_id)}}" target="_blank">{{$license->full_name}}</a>
					</td>

					<td>{{$license->license_name}}</td>
					<td>{{$license->number}}</td>
					<td>{{date('d-m-Y',strtotime($license->start_date))}}</td>
					<td>{{date('d-m-Y',strtotime($license->end_date))}}</td>
					<td>@if($license->document!='')<a href="{{url($license->document)}}" target="_blank">View </a>@endif</td>
					<td>{{$ApprovalStatus[$license->status]}}</td>
					<td><button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-xs blue showApprovals"><i class="fa fa-angle-double-right"></i> Details</button></td>
				</tr>
				<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
					<td colspan="9">
						<div class="row" style="">
							
							@if($license->check_admin())
							<div class="col-md-6">
								<?php $entity_id = $license->id;?>
								@include('approve_box')
							</div>
							@endif

							<div class="col-md-6">
								{{Approval::approval_html($entity_type, $license->id)}}
							</div>
						</div>
					</td>
				</tr>
				<?php $count++?>
			@endforeach
		</table> 
	</div>
	@else
	<div class="alert alert-warning">
		No pending licenses found for approved coaches
	</div>
	@endif
@endif

@if(isset($employmentDetails))
	<div class="row">
		<div class="col-md-6">
			<!-- <h3>Pending Employment Details</h3> -->
		</div>
		<div class="col-md-6">
			<!-- <a href="#" class="btn yellow pull-right" style="margin-top:20px">Edit</a> -->
		</div>
	</div>
	@if(sizeof($employmentDetails) > 0)
	<?php $entity_type=4; ?>
	<div class="row" style="padding:20px;">
		<table class="table table-bordered table-hover">
			<tr>
				<th style="width:50px;">SN</th>
				<th>Coach Name</th>
				<th>Employment</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Status</th>
				<th>Document</th>
				<th>#</th>
			</tr>
			<?php $count=1;?>
			@foreach($employmentDetails as $employment)
				<tr>	
					<td>{{($page_id-1)*$max_per_page + $count}}</td>
					<td>
						<a href="{{url('/admin/viewCoachDetails/'.$employment->coach_id)}}" target="_blank">{{$employment->full_name}}</a>
					</td>
					<td>{{$employment->employment}}</td>
					<td>{{date('d-m-Y',strtotime($employment->start_date))}}</td>
					<td>{{date('d-m-Y',strtotime($employment->end_date))}}</td>
					<td>{{$ApprovalStatus[$employment->status]}}</td>
					<td>@if($employment->contract!='')<a href="{{url($employment->contract)}}" target="_blank">View </a>@endif</td>
					<td>
						<button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-xs blue showApprovals"><i class="fa fa-angle-double-right"></i> Details</button></td>
					</td>
				</tr>
				<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
					<td colspan="8">
						<div class="row" style="">
							
							@if($employment->check_admin())
							<div class="col-md-6">
								<?php $entity_id = $employment->id;?>
								@include('approve_box')
							</div>
							@endif

							<div class="col-md-6">
								{{Approval::approval_html($entity_type, $employment->id)}}
							</div>
						</div>
					</td>
				</tr>
				<?php $count++?>
			@endforeach
		</table> 
	</div>
	@else
	<div class="alert alert-warning">
		No pending employment details found for approved coaches
	</div>
	@endif
@endif
@if(isset($activities))
	<div>
		<!-- <h3>Pending Activities</h3> -->
	</div>
	@if(sizeof($activities) > 0)
	<?php $entity_type=5; ?>
	<div class="row" style="padding:20px;">
		<table class="table table-bordered table-hover">
			<tr>
				<th style="width:50px;">SN</th>
				<th>Coach Name</th>
				<th>Activity</th>
				<th>Place</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Status</th>
				<th>#</th>
			</tr>
			<?php $count=1;?>
			@foreach($activities as $activity)
				<tr>	
					<td>{{($page_id-1)*$max_per_page + $count}}</td>
					<td>{{$activity->full_name}}</td>
					<td>{{$activity->event}}</td>
					<td>{{$activity->place}}</td>
					<td>{{date('d-m-Y',strtotime($activity->from_date))}}</td>
					<td>{{date('d-m-Y',strtotime($activity->to_date))}}</td>
					<td>{{$ApprovalStatus[$activity->status]}}</td>
					<td>
						<button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-xs blue showApprovals"><i class="fa fa-angle-double-right"></i> Details</button></td>
					</td>
				</tr>
				<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
					<td colspan="8">
						<div class="row" style="">
							
							@if($activity->check_admin())
							<div class="col-md-6">
								<?php $entity_id = $activity->id;?>
								@include('approve_box')
							</div>
							@endif

							<div class="col-md-6">
								{{Approval::approval_html($entity_type, $activity->id)}}
							</div>
						</div>
					</td>
				</tr>
				<?php $count++?>
			@endforeach
		</table> 
	</div>
	@else
	<div class="alert alert-warning">
		No pending activities found
	</div>
	@endif
@endif	