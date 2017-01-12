<div class="row">
	<div class="col-md-7">
		<h3 class="page-title">
		Results - {{$course_details->course_name}}
		</h3>
	</div>
	<div class="col-md-5">
		<a href="{{url('resultAdmin/courses')}}" class="btn btn-sm blue pull-right">Go Back</a>
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


@if(sizeof($applications) > 0)
	{{Form::open(["url"=>'resultAdmin/addResult',"method"=>"post"])}}

	<div class="row" style="padding:20px;">
		<table class="table table-bordered table-hover">
			<tr>
				<th style="width:50px;">SN</th>
				<th>Coach Name</th>
				@foreach($course_parameters as $parameter)
					<th>{{$parameter->parameter}}</th>
				@endforeach
			</tr>
			<?php $count=1;?>
			@foreach($applications as $application)
				<tr>	
					<td>{{$count}}</td>
					<td>{{$application->coach_name}}</td>
					<?php for ($i=0; $i <sizeof($course_parameters) ; $i++) { ?>
						<td>
							{{Form::text('mark_id','')}}
						</td>
					<?php }?>
				</tr>
				<?php $count++?>
			@endforeach
		</table> 
	</div>
	<div style="text-align: center;">
		<button class="btn block blue " >Submit</button>
	</div>
	{{Form::close()}}
@endif
