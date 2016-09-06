<?php $count_main = 1; ?>
<h3 class="page-title">Pending Approvals</h3>
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
<ul class="nav nav-tabs">
	<li class="{{($docType=='pendingDocument')?'active':''}}">
		<a href="{{url('pendingApprovals/pendingDocument')}}" >
		Pending Documents </a>
	</li>
	<li class="{{($docType=='pendingLicenses')?'active':''}}">
		<a href="{{url('pendingApprovals/pendingLicenses')}}" >
		Pending License </a>
	</li>
	<li class="{{($docType=='pendingEmploymentDetails')?'active':''}}">
		<a href="{{url('pendingApprovals/pendingEmploymentDetails')}}" >
		Pending Employment Details </a>
	</li>
	<li class="{{($docType=='pendingActivities')?'active':''}}">
		<a href="{{url('pendingApprovals/pendingActivities')}}" >
		Pending Activities </a>
	</li>
</ul>


@if(isset($total))
<div class="row" style="margin-top:20px;">
	<div class="col-md-3">
		<h3 class="page-title"></h3>
	</div>
	<div class="col-md-9">
		<div class="pull-right hidden" style="font-style:italic; margin-top:5px;  margin-left:10px" >
			<a  href="{{url($input_string.'&show_all=true')}}"> Show All ({{$total}})</a>
		</div>
		@if(Input::has('show_all'))
			<div class="pull-right" style="font-style:italic; margin-top:5px; margin-right:10px">
				<a  href="{{url($input_string.'1')}}"> Paginate</a>
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
				<a  href="{{url($input_string.'1')}}"><i class="fa fa-angle-double-left"></i></a>
			</li>
			@if($page_id >= 3)
			<li>
				<a  href="{{url($input_string.($page_id - 2))}}"><i class="fa fa-angle-left"></i></a>
			</li>
			@endif
			@for($x = $first_page ; $x <= $max_page; $x++  )
				<li>
					@if($x != $page_id )
						<a  href="{{url($input_string.$x)}}">{{$x}}</a>
					@else
						<a  href="javascript:;"><b>{{$x}}</b></a>
					@endif
				</li>
			@endfor
			@if($x < $total_pages)
			<li>
				<a  href="{{url($input_string.$x)}}"><i class="fa fa-angle-right"></i></a>
			</li>
			@endif
			<li>
				<a  href="{{url($input_string.$total_pages)}}"><i class="fa fa-angle-double-right"></i></a>
			</li>
		</ul>
		<div class="pull-right" style="font-style:italic; margin-top:5px;">
			Showing {{ ($page_id - 1)*$max_per_page + 1  }} - {{ ($page_id*$max_per_page > $total)?$total:$page_id*$max_per_page  }} of <b>{{$total}}</b>
		</div>
		@endif
	</div>
</div>
@endif
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
						<td>{{$document->full_name}}</td>
						<td>{{$document->document_name}}</td>
						<td>{{$document->number}}</td>
						<td>{{date('d-m-Y',strtotime($document->expiry_date))}}</td>
						<td>@if($document->file!='')<a href="{{url($document->file)}}" target="_blank">View </a>@endif
						</td>
						<td>{{isset($ApprovalStatus[$document->status])?$ApprovalStatus[$document->status]:''}}</td>
						<td><button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-xs blue showApprovals"><i class="fa fa-angle-double-right"></i> Details</button></td>
					</tr>
					<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
						<td colspan="7">
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
		No License found
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
					<td>{{$license->full_name}}</td>
					<td>{{$license->license_name}}</td>
					<td>{{$license->number}}</td>
					<td>{{date('d-m-Y',strtotime($license->start_date))}}</td>
					<td>{{date('d-m-Y',strtotime($license->end_date))}}</td>
					<td>@if($license->document!='')<a href="{{url($license->document)}}" target="_blank">View </a>@endif</td>
					<td>{{$ApprovalStatus[$license->status]}}</td>
					<td><button  div-id="{{'approve_list_'.$count_main}}" class="btn btn-xs blue showApprovals"><i class="fa fa-angle-double-right"></i> Details</button></td>
				</tr>
				<tr id="{{'approve_list_'.$count_main++}}" style="display:none;">
					<td colspan="8">
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
		No License found
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
					<td>{{$employment->full_name}}</td>
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
		No employment details found
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
		No Activity found
	</div>
	@endif
@endif	