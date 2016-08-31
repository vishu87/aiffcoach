<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">Upload License for {{$coach->full_name}}</h3>
	</div>
	<div class="col-md-6">
		<a href="{{url('admin/ApplicationResults')}}" class="btn blue pull-right">Go Back</a>
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

{{Form::open(array("url"=>'admin/ApplicationResults/storeLicense/'.$coach->id,"method"=>'post',"class"=>"check_form","files"=>"true"))}}
	<div class="form-body">
		<!--- my form start -->
			<div class="row">
	        	<div class="col-md-6 form-group">
	        		<label class="form-label">License Name <span class="error">*</span></label>
		            {{Form::select('license_id',$licenses,(isset($editLicense))?$editLicense->license_id:'',["class"=>"form-control","required"=>"true"])}}
		            <span class="dob-error">{{$errors->first('license_id')}}</span>
		        </div>
	        	<div class="col-md-6">
			        <div class="form-group"> 
			            <label class="form-label">License Number <span class="error">*</span></label><br>
			            {{Form::text('number',(isset($editLicense))?$editLicense->number:'',["class"=>"form-control",'required'=>'true'])}}
			            {{Form::hidden('course_id',(isset($editLicense))?$editLicense->license_id:$coach->course_id)}}
			            <span class="error">{{$errors->first('number')}}</span>
			        </div>
		        </div>
		        <div class="col-md-6 clear">
		          <div class="form-group"> 
		            <label class="form-label">Start Date <span class="error">*</span></label><br>
		            {{Form::text('start_date',(isset($editLicense))?date('d-m-Y',strtotime($editLicense->start_date)):'',["class"=>"form-control datepicker",'required'=>'true',"date_en"=>"true"])}}
		            <span class="error">{{$errors->first('start_date')}}</span>
		          </div>
		        </div>
		        <div class="col-md-6">
		          <div class="form-group"> 
		            <label class="form-label">End Date</label><br>
		            {{Form::text('end_date',(isset($editLicense))?date('d-m-Y',strtotime($editLicense->end_date)):'',["class"=>"form-control datepicker","date_en"=>"true"])}}
		            <span class="error">{{$errors->first('end_date')}}</span>
		          </div>
		        </div>
            	<div class="col-md-6 form-group clear">
            		<label class="form-label">Document Copy</label><br>
            		{{Form::file('document',["class"=>"form-control"])}}
            		@if(isset($editLicense))
            			@if($editLicense->document!='')
            				<a href="{{url($editLicense->document)}}">view current</a>
            			@endif
            		@endif
            	</div>	
            </div>
		<!---my form end-->
	</div>
	<div class="form-actions" style="margin-top:40px;">
		<button type="submit" class="btn blue">Upload</button>
	</div>
{{Form::close()}}

@if(sizeof($coachLicense)>0)
   <div style="overflow-y:auto;margin-top:40px;">
   	<div style="margin-bottom:20px"><h3>Coach License</h3></div>
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>License Name</th>
				<th>License Number</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody id="licenses">
			<?php $count = 1; ?>
			@foreach($coachLicense as $data)
			<tr id="document_{{$data->id}}">
				<td>{{$count}}</td>
				<td>{{$data->license_name}}</td>
				<td>{{$data->number}}</td>
				<td>{{date('d-m-Y',strtotime($data->start_date))}}</td>
				<td>{{date('d-m-Y',strtotime($data->end_date))}}</td>
				<td>
					@if($data->document!='')
						<a type="button" class="btn yellow btn-sm "  href="{{url($data->document)}}" target="_blank"> <i class="fa fa-cube"></i> View</a>
					@else
					
					@endif	

					<button type="button" class="btn red btn-sm delete-div" div-id="document_{{$data->id}}"  action="{{'admin/ApplicationResults/delete/'.$data->id}}"> <i class="fa fa-remove"></i> Delete</button>
				</td>
			</tr>
			<?php $count++ ?>
			@endforeach
		</tbody>
	</table>
</div>  
@else
<div class="alert alert-warning" style="margin-top:20px;">
	No License found
</div>
@endif 