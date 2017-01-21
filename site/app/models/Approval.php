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
							<th>User Name</th>
							<th style="width:70px">Date</th>
						</tr>
					</thead>';
					foreach($logs as $log){
						if(!empty($log->document)){
							$url = '<a href='.url($log->document).' target=_blank>view</a>';
						}
						else{
							$url='N/A';
						}
						$str .= '<tr id=approval_log_'.$log->id.'>
							<td>'.$count_log.'</td>
							<td>';
						if($log->remarks != ''){
							$str .= $log->remarks;
						} else {
							if($log->status == 1) $str .= '<i>Re-submitted by '.$log->user_name.'</i>';
						}
						if (Auth::user()->privilege == 2) {
							$str .= ' <button class="btn btn-xs yellow edit-div" count='.$count_log.' modal-title="Edit Remarks" div-id=approval_log_'.$log->id.' action=admin/editRemark/'.$log->id.'><i class = "fa fa-edit" ></i></button>
								<button class="btn btn-xs red delete-div" count='.$count_log++.' div-id=approval_log_'.$log->id.' action=admin/deleteRemark/'.$log->id.'><i class = "fa fa-remove" ></i></button>';
						}
						$str .= '</td>
							<td>';
							if($log->privilege == 2){
								$str .= Approval::get_status($log->status);
							} else {
								$str .= '';
							}
							$str .= '</td><td>'.$log->user_name.'</td><td>'.date('d-m-y',strtotime($log->created_at)).'</td></tr>';
					}
				$str .= '</table>';
			}
		}
		return $str;
	}
}
