<tr id="license_{{$data->id}}">
	<td>{{$count}}</td>
	<td>{{$data->name}}</td>
	<td>
		<a type="button" class="btn yellow btn-sm "  href="{{url('admin/License/edit/'.$data->id)}}" count = "{{$count}}"> <i class="fa fa-edit"></i> Edit</a>
		<button type="button" class="btn red delete-div btn-sm" div-id="license_{{$data->id}}"  action="{{'admin/License/delete/'.$data->id}}"> <i class="fa fa-remove"></i> Delete</button>
	</td>
</tr>