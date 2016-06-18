
<div class="row" style="margin-bottom:25px;">
	<div class="col-md-12">
		<a href="{{url('coach/activity')}}" class="btn blue pull-right">Go Back</a>
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

<div class="portlet box blue">
	<div class="portlet-title"><div class="caption">@if(!isset($activity))Add New Activity @else Edit Activity Details @endif</div></div>

<div class="portlet-body form">


@if(isset($activity))
{{Form::open(array("url"=>'coach/activity/update/'.$activity->id,"method"=>'PUT',"class"=>""))}}
@else
{{Form::open(array("url"=>'coach/activity/insert',"method"=>'post',"class"=>"check_form"))}}
@endif
	<div class="form-body">
		<!--- my form start -->
			<div class="row">
				<div class="col-md-6 form-group">
					{{Form::label('Event')}}
					{{Form::text('event',(isset($activity))?$activity->event:'',["class"=>"form-control ","required"=>"true"])}}
					<span class="error">{{$errors->first('event')}}</span>
				</div>
				<div class="col-md-6 form-group">
					{{Form::label('From')}}
					{{Form::text('from_date',(isset($activity))?$activity->from_date:'',["class"=>"form-control datepicker","required"=>"true","date"=>'true'])}}
					<span class="error">{{$errors->first('from_date')}}</span>
				</div>
			</div>
			<div class="row">	
				<div class="col-md-6 form-group">
					{{Form::label('To')}}
					{{Form::text('to_date',(isset($activity))?$activity->to_date:'',["class"=>"form-control datepicker","required"=>"true","date"=>'true'])}}
					<span class="error">{{$errors->first('to_date')}}</span>
				</div>
				<div class="col-md-6 form-group">
					{{Form::label('Place')}}
					{{Form::text('place',(isset($activity))?$activity->place:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('place')}}</span>
				</div>
			</div>
			<div class="row">	
				<div class="col-md-6 form-group">
					{{Form::label('No of Participants')}}
					{{Form::text('participants',(isset($activity))?$activity->participants:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('participants')}}</span>
				</div>
				<div class="col-md-6 form-group">
					{{Form::label('Position / Role')}}
					{{Form::text('position_role',(isset($activity))?$activity->position_role:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('position_role')}}</span>
				</div>
			</div>
		<!---my form end-->
	</div>
	<div class="form-actions" style="margin-top:40px;">
		<button type="submit" class="btn blue">{{(isset($activity))?'Update':'Add'}}</button>
	</div>
{{Form::close()}}

</div>
</div>