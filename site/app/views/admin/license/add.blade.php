
	<div class="row">
		<div class="col-md-6">
			<h3 class="page-title">License</h3>
		</div>
		<div class="col-md-6">
			<a href="{{url('admin/License')}}" class="btn blue pull-right">Go Back</a>
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
	<div class="portlet-title"><div class="caption">@if(!isset($license))Add New License @else Edit License Details @endif</div></div>

<div class="portlet-body form">


@if(isset($license))
{{Form::open(array("url"=>'admin/License/update/'.$license->id,"method"=>'PUT',"class"=>"check_form"))}}
@else
{{Form::open(array("url"=>'admin/License/insert',"method"=>'post',"class"=>"check_form"))}}
@endif
	<div class="form-body">
		<!--- my form start -->
			<div class="row">
				<div class="col-md-6 form-group">
					{{Form::label('Name')}} <span class="error"> *</span>
					{{Form::text('name',(isset($license))?$license->name:'',["class"=>"form-control ","required"=>"true"])}}
					<span class="error">{{$errors->first('name')}}</span>
				</div>
				<div class="col-md-6 form-group">
					{{Form::label('Authorised By')}} <span class="error"> *</span>
					{{Form::select('authorised_by',$authority,(isset($license))?$license->authorised_by:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('authorised_by')}}</span>
				</div>
				
				
			</div>
			
			<div class="row">	
				<div class="col-md-6 form-group">
					{{Form::label('Prerequisites')}}
					{{Form::select('prerequisite_id[]',$licenses,(isset($selectedPrerequisites))?$selectedPrerequisites:'',["class"=>"form-control","multiple"=>"true"])}}
					<span class="error">{{$errors->first('prerequisite_id')}}</span>
				</div>
				<div class="col-md-6 form-group">
					{{Form::label('Description')}} <span class="error"> *</span>
					{{Form::textarea('description',(isset($license))?$license->description:'',["class"=>"form-control","required"=>"true"])}}
					<span class="error">{{$errors->first('description')}}</span>
				</div>
			</div>
		<!---my form end-->
	</div>
	<div class="form-actions" style="margin-top:40px;">
		<button type="submit" class="btn blue">{{(isset($license))?'Update':'Add'}}</button>
	</div>
{{Form::close()}}

</div>
</div>