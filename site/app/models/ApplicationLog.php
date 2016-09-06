<?php
//
class ApplicationLog extends Eloquent {

	protected $table = 'application_log';

	public function closed_status(){
		$var = '';
		switch ($this->type) {
			case 1:
				$var = "<i class='fa fa-check'></i>"; // approved
				break;
			case 4:
				$var = "<i class='fa fa-question-circle'></i>"; // referred back
				break;
			case 5:
				$var = "<i class='fa fa-remove'></i>";
				break;
			default:
				$var = "<i class='fa fa-angle-left'></i><i class='fa fa-angle-right'></i>";
				break;
		}
		return $var;
	}

	public function get_status_name($coach_name){
		$var = '';
		switch ($this->status) {
			case 0:
				$var = 'AIFF';
				break;
			case 1:
				$var = $coach_name;
				break;
			case 2:
				$var = 'AIFF';
				break;
			default:
				$var = $coach_name;
				break;
		}
		return $var;
	}

	public function checkAuth($application){
		$var = false;
		if($application->status == 0 || $application->status == 2){
			if(Session::get('privilege') == 2) $var = true;
		}
		else {
			if(Session::get('privilege') == 1 && $application->coach_id = Auth::user()->coach_id) $var = true;
		}
		return $var;
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
