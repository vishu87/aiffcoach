<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">
			Employment Details of Coaches
		</h3>
	</div>
	<div class="col-md-5">
		<a class="btn green pull-right" href="{{url('/admin/coach-employments?exportExcel=1')}}">Export Excel</a>
	</div>
	
	<div class="col-md-12">
		
		@if(Session::has('failure'))
			<div class="alert alert-danger">
		    	<button type="button" class="close" data-dismiss="alert">×</button>
		    	<i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
		   	</div>
		@endif
	</div>
	<div class="col-md-12">
		@if(isset($total))
			<div class="row" style="margin-bottom:20px;">
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
<?php $count=1;?>
@foreach($coaches as $coach)

	<div class="note {{($count%2==0?'note-info':'note-warning')}}">
	    <strong>{{$coach->full_name}}</strong> &nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
	    <strong>{{$coach->registration_id}}</strong>&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
	    <strong>{{$coach->email}}</strong><br>

	    <table class="table">
	    	<tr>
	    		<th>Organization</th>
	    		<th>Designation</th>
	    		<th>Coaching Employments</th>
	    		<th>Contract</th>
	    	</tr>
	    	
	    	<tr>
	    		<td>{{$coach->club_name}}</td>
	    		<td>{{$coach->designation}}</td>
	    		<td>{{$coach->employments}}</td>
	    		<td>
	    			@if($coach->contract != '')
	    			<a href="{{url($coach->contract)}}" target="_blank" class="btn blue">view</a>
	    			@else
	    				N/A
	    			@endif
	    		</td>
	    	</tr>

	    </table>
	</div>
	<?php $count++?>
@endforeach