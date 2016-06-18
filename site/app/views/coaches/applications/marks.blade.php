
<table class="table table-bordered table-hover">
	<tr>
		<th>Exam Name</th>
		<th>Obtained Marks</th>
		<th>Maximum Marks</th>
	</tr>
	<?php $count=1;?>
	@foreach($parameters as $data)
	<tr>
		<td>{{$data->parameter}}</td>
		<td>
			
			@foreach($results as $result)
				@if($result->parameter_id==$data->parameter_id)
					{{$result->marks}}
				@endif	
			@endforeach

		</td>
		<td>{{$data->max_marks}}</td>
	</tr>
	<?php $count++;?>
	@endforeach
</table>
	