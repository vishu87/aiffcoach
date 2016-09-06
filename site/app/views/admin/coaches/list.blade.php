<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">
			{{$title}}
		</h3>
	</div>
	<div class="col-md-5">
		<a class="btn green pull-right" href="{{url('/admin/coachExport/'.$flag)}}">Export Excel</a>
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

@if($flag==1)
{{ Form::open(array('url' => 'admin/approvedCoach', 'method' => 'GET','role' => 'form','class'=>"")) }}
@else
{{ Form::open(array('url' => 'admin/pendingCoach', 'method' => 'GET','role' => 'form','class'=>"")) }}
@endif
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
</div>
<div>
<button class="btn green" type="submit">Search</button>
</div>
{{Form::close()}}


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
					<th data-placeholder="Search..">Status</th>
					<th >#</th>
				</tr>
			</thead>
			<?php $count = 1;?>
			@foreach($coaches as $data)
				@include('admin.coaches.view')
			<?php $count++;?>
			@endforeach
		</table>
	</div>
</div>