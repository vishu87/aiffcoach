<?php if($tab_type==1){$link='courses/active';}else if($tab_type==2){$link='courses/inactive';}else if($tab_type==3){$link='dashboard';} ?>
<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">Details of {{$course->name}}</h3>
	</div>
	<div class="col-md-6 ">
		<a href="{{url('/coach/'.$link)}}" class="btn btn-sm blue pull-right">Back</a>
	</div>
</div>

<div >
	<table class="table table-bordered table-hover">
		<tr>
			<td style="width:33.33%"><b>Course Name </b><br><br>
				{{$course->name}}
			</td>
			<td style="width:33.33%"><b>License Name </b><br><br>
				{{$course->license_name}}
			</td>	
			<td style="width:33.33%"><b>Start Date</b><br><br>
				{{date('d-m-Y',strtotime($course->start_date))}}
			</td>
			
		</tr>

		<tr>
			<td style="width:33.33%"><b>End Date </b><br><br>
				{{date('d-m-Y',strtotime($course->end_date))}}
			</td>
			<td style="width:33.33%"><b>Fees</b><br><br>
				{{$course->fees}}
			</td>
			<td style="width:33.33%"><b>Venue </b><br><br>
				{{$course->venue}}
			</td>	
			
		</tr>
		<tr>
			<td colspan="2"><b>Description</b><br><br>
				{{$course->description}}
			</td>
			<td>
				<a href="{{url($course->documents)}}" target="_blank" style="font-size:16px;">View ocument</a>
			</td>
		</tr>
		
	</table>
</div>

<div class="row">
	<div class=" col-offset-4 col-md-4">
		@if($tab_type!=2)
		<button class="btn btn-sm blue {{(in_array($course->id,$checkAppliedCourses))?'':'apply-course'}}" action = "{{'coach/courses/apply/'.$course->id}}">{{(in_array($course->id,$checkAppliedCourses))?'Alredy Applied':'Apply'}}</button>
		@else
			<button class="btn btn-sm red">Not open</button>
		@endif
	</div>
	

</div>