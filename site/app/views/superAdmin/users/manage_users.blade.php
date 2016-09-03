<div class="row">
	<div class="col-md-6">
		<h3 class="page-title">Manage Logins</h3>
	</div>
	<div class="col-md-6">
		<a class="btn green pull-right" href="{{url('superAdmin/manage_logins/add')}}">Add</a>

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
<div style="overflow-y:auto;margin-top:30px">
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th style="width:50px">SN</th>
				<th>Name</th>
				<th>Type</th>
				<th>Username</th>
				<th>Mobile</th>
				<th>#</th>
				
			</tr>
		</thead>
		<tbody id="society">
			<?php $count = 1; ?>
			@foreach($users as $user)
			<tr id="parameter_{{$user->id}}">
				<td style="widtd:50px">{{$count}}</td>
				<td>{{$user->name}}</td>
				<td>
					@if($user->privilege==1 && $user->official_types != '')
						<?php $official_type = explode(',',$user->official_types);?>	
						@foreach($official_type as $key=>$value)
							{{$officialTypes[$value]}} ,
						@endforeach 
					@else
						{{$UserTypes[$user->privilege]}} 
					@endif
				</td>
				<td>{{$user->username}}</td>
				<td>{{$user->mobile}}</td>
				<td>
					<a type="button" class="btn btn-sm yellow " href="{{url('superAdmin/manage_logins/edit/'.$user->id)}}" ><i class="fa fa-edit"></i> Edit</a>
					<button type="button" class="btn btn-sm red delete-div" div-id="parameter_{{$user->id}}"  action="{{'superAdmin/manage_logins/delete/'.$user->id}}"> <i class="fa fa-remove"></i></button>
				</td>
			</tr>
				<?php $count++ ?>
			@endforeach
		</tbody>
	</table>
</div>