<div class="row">
	<div class="col-md-8">
		<h3 class="page-title">{{$title}}</h3>
	</div>
	<div class="col-md-4">
		<a class="btn green pull-right" href="{{url('/admin/applicationExport/'.$flag.'/'.app('request')->input('course'))}}">Export Excel</a>
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

<div style="margin-bottom:20px;" class="row">
	<div class="col-md-7">
		{{Form::open(array('url'=>'/admin/Applications/all', 'method'=>'GET', 'class' => 'check_form'))}}
		<label>Filter by course</label>
		<div class="row">
			<div class="col-md-8">
				{{Form::select('course',$courses,(Input::has('course'))?Input::get('course'):'',["class"=>"form-control"])}}
			</div>
			<div class="col-md-4">
				{{Form::submit('Submit',["class"=>"btn blue"])}}
			</div>
		</div>
		{{Form::close()}}
	</div>
	<div class="col-md-5">
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

<div>
	<ul class="nav nav-tabs">
		@foreach($status as $val => $st)
			<li class="{{($val==$application_status)?'active':''}}">
				<a href="{{url('admin/Applications/all')}}?course={{Input::get('course')}}&amp;status={{$val}}" >{{$st}}</a>
			</li>
		@endforeach
	</ul>
</div>

@if(sizeof($applications)>0)
<div style="overflow-y:auto;margin-top:20px;">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>Course Name</th>
				<th>Coach Name</th>
				<th>Remark</th>
				<th>Status</th>
				<th>#</th>
			</tr></thead>
			<tbody id="applications">
				<?php $count = 1; ?>
				@foreach($applications as $data)
					@include('admin.applications.view')
					<?php $count++ ?>
				@endforeach
			</tbody>
	</table>
</div>
@else
<div class="alert alert-warning">No records found !</div>
@endif