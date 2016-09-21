<?php
//
class Approval extends Eloquent {

	protected $table = 'approval';

	public static function types(){
		return array(
			"1" => "Coach",
			"2" => "Coach Document",
			"3" => "Coach License",
			"4" => "Coach Employment",
			"5" => "Coach Activity"
		);
	}

	public static function status(){
		return  array('0'=>'Pending for Approval','1' =>'Approved','2'=>'Referred Back','3'=>'Rejected' );
	}

	public static function get_status($status_id){
		if(isset(Approval::status()[$status_id])){
			return Approval::status()[$status_id];
		} else {
			return '';
		}
	}

	public static function approval_html($entity_type, $entity_id){
		$logs = Approval::select('approval.*','users.name as user_name', 'users.privilege')->join('users','users.id','=','approval.user_id')->where('entity_type',$entity_type)->where('entity_id',$entity_id)->orderBy('created_at','DESC')->get();
		$str = '';
		if(isset($logs)){
			if(sizeof($logs) > 0){
				$count_log = 1;
				$str .='
				<table class="table">
					<thead>
						<tr>
							<th>SN</th>
							<th>Remarks</th>
							<th>Status</th>
							<th>Date</th>
							<th>Document</th>
						</tr>
					</thead>';
					foreach($logs as $log){
						if(!empty($log->document)){
							$url = '<a href='.url($log->document).' target=_blank>view</a>';
						}
						else{
							$url='N/A';
						}
						$str .= '<tr>
							<td>'.$count_log++.'</td>
							<td>'.$log->remarks.'</td>
							<td>';
						if($log->privilege == 2){
							$str .= Approval::get_status($log->status);
						} else {
							$str .= '';
						}
						$str .= '</td>
							<td>'.$log->user_name.'<br>'.date('d-m-Y',strtotime($log->created_at)).'</td>
						<td>'.$url.'</td></tr>';
					}
				$str .= '</table>';
			}
		}
		return $str;
	}
}
