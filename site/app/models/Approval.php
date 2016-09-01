<?php
//
class Approval extends Eloquent {

	protected $table = 'approval';

	public static function types(){
		return array(
			"1" => "Coach",
			"2" => "Coach Document",
			"3" => ""
		);
	}

	public static function approval_html($entity_type, $entity_id){
		$logs = Approval::select('approval.*','users.username as user_name')->join('users','users.id','=','approval.user_id')->where('entity_type',$entity_type)->where('entity_id',$entity_id)->orderBy('created_at','DESC')->get();
		$str = '';
		if(isset($logs)){
			if(sizeof($logs) > 0){
				$count_log = 0;
				$str .='
				<table class="table">
					<thead>
						<tr>
							<th>SN</th>
							<th>Remarks</th>
							<th>Document</th>
							<th>Created by</th>
							<th>Date</th>
						</tr>
					</thead>';
					foreach($logs as $log){
						$str .= '<tr>
							<th>'.$count_log++.'</th>
							<th>'.$log->remarks.'</th>
							<th>Document</th>
							<th>'.$log->user_name.'</th>
							<th>Date</th>
						</tr>';
					}
				$str .= '</table>';
			}
		}
		return $str;
	}
}
