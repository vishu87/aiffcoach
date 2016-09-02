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
		return  array('0'=>'Pending','1' =>'Approved','2'=>'Referred Back','3'=>'Rejected' );
	}

	public static function get_status($status_id){
		if(isset(Approval::status()[$status_id])){
			return Approval::status()[$status_id];
		} else {
			return '';
		}
	}

	public static function approval_html($entity_type, $entity_id){
		$logs = Approval::select('approval.*','users.username as user_name')->join('users','users.id','=','approval.user_id')->where('entity_type',$entity_type)->where('entity_id',$entity_id)->orderBy('created_at','DESC')->get();
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
							<th>Document</th>
							<th>Status<th>
							<th>Created by</th>
							<th>Date</th>
						</tr>
					</thead>';
					foreach($logs as $log){
						if(!empty($log->document)){
							$url = '<a href='.url($log->document).' target=_blank>view</a>';
						}
						else{
							$url='';
						}

						$str .= '<tr>
							<th>'.$count_log++.'</th>
							<th>'.$log->remarks.'</th>
							<th>'.$url.'</th>
							<th>'.Approval::get_status($log->status).'</th>
							<th>'.$log->user_name.'</th>
							<th>'.date('d-m-Y',strtotime($log->created_at)).'</th>
						</tr>';
					}
				$str .= '</table>';
			}
		}
		return $str;
	}
}
