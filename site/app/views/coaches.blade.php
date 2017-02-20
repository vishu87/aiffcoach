@include('header')
<body class="page-header-fixed page-quick-sidebar-over-content ">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
  <!-- BEGIN HEADER INNER -->
  <div class="page-header-inner">
    <!-- BEGIN LOGO -->
    <div class="page-logo" style="padding-top:10px; width: 500px;">
    
<!--       {{HTML::image("assets/admin/img/logo.png","Logo",["class"=>"logo-default","style"=>"width:40px"])}} -->
      <span class="">AIFF Coach Education Registration System</span>
      <div class="menu-toggler sidebar-toggler hide">
        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
      </div>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
    </a>

    <!-- END RESPONSIVE MENU TOGGLER -->
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu pull-right">
     
    </div>
    <!-- END TOP NAVIGATION MENU -->
  </div>
  <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container" style="background: #fff">
	<div class="container" style="min-height: 640px;">
	  	<div class="row" style="margin-top: 20px;">
			<div class="col-md-7">
				<h3 class="page-title">
					{{$title}}
				</h3>
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
				
			{{ Form::open(array('url' => '/view-all-coaches', 'method' => 'GET','role' => 'form','class'=>"")) }}
			
			<div class="row">
				<div class="form-group col-md-3">
					<label>Registration ID</label>
					{{Form::text('registration_id',(Input::has('registration_id'))?Input::get('registration_id'):'',["class"=>"form-control"])}}
					<span class="error"><?php echo $errors->first('registration_id'); ?></span>
				</div>
				<div class="form-group col-md-3">
					<label>Name</label>
					{{Form::text('official_name',(Input::has('official_name'))?Input::get('official_name'):'',["class"=>"form-control"])}}
					<span class="error"><?php echo $errors->first('official_name'); ?></span>
				</div>
				<div class="form-group col-md-3">
					<label>License</label>
					{{Form::select('license_id',$licenses,(Input::has('license_id'))?Input::get('license_id'):'',["class"=>"form-control"])}}
					<span class="error"><?php echo $errors->first('license_id'); ?></span>
				</div>

				<div class="form-group col-md-3">
					<label>State</label>
					{{Form::select('state_id',$states,(Input::has('state_id'))?Input::get('state_id'):'',["class"=>"form-control"])}}
					<span class="error"><?php echo $errors->first('state_id'); ?></span>
				</div>
			</div>
			<div>
				<button class="btn green" type="submit">Search</button>
			</div>
			{{Form::close()}}

			@if(isset($total))
				<div class="row" style="margin-bottom:20px">
					<?php 
						$inputs = Input::all();
						$str = '/exportCoaches?type=1';
						if(sizeof($inputs) > 0){
							foreach ($inputs as $key => $value) {
								$str .= "&".$key."=".$value;
							}
						}
					?>
					<div class="col-md-3">
						<a href="{{url($str)}}" class="btn btn-sm blue" style="margin-top: 10px;">Export Excel</a>
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
		

		@if(sizeof($coaches) > 0)
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered table-hover tablesorter">
					<thead>
						<tr>
							<th  style="width:50px">SN</th>
							<th data-placeholder="Search..">Name</th>
							<th data-placeholder="Search..">Registration ID</th>
							<th data-placeholder="Search..">Contact Details</th>
							<th data-placeholder="Search..">State</th>
							@if(Input::has('license_id') && Input::get('license_id') !='')
							<th data-placeholder="Search..">License</th>
							@endif
							<th data-placeholder="Search..">{{(Input::has('license_id') && Input::get('license_id') !='')?'Other License':'Licenses'}}</th>
							<th data-placeholder="Search..">Employment</th>
							<!-- <th >#</th> -->
						</tr>
					</thead>
					<?php $count = 1;?>
					@foreach($coaches as $data)
						@if(isset($data))
							<tr id="coach_{{$data->id}}">
								<td>{{($page_id-1)*$max_per_page + $count}}</td>
								<td>{{$data->full_name}}
								</td>
								<td>{{$data->registration_id}}</td>
								<td>{{$data->email}}</td>
								<td>{{$data->state_reference}}</td>
								@if(Input::has('license_id') && Input::get('license_id') !='')
									<td>
										{{$data->latest_license}}
									</td>
								@endif
								<td>
									{{(isset($latest_license[$data->id]))?implode(',<br>',$latest_license[$data->id]):''}}
								</td>
								<td>{{(isset($latest_emps[$data->id]))?$latest_emps[$data->id]:''}}</td>
								
							</tr>
						@endif
					<?php $count++;?>
					@endforeach
				</table>
			</div>
		</div>
		@else
			<div class="alert alert-danger">No records found !</div>
		@endif
	</div>
</div>
<!-- END CONTAINER -->
@include('footer')