<?php

class Payment extends Eloquent {

	protected $table = 'payment';

	public static function listing(){
		return Payment::select('coaches.full_name','applications.status as status_app','courses.name as course_name','payment.*','courses.user_type','applications.coach_id')->leftJoin('applications','payment.application_id','=','applications.id')->leftJoin('courses','applications.course_id','=','courses.id')->join('coaches','applications.coach_id','=','coaches.id');
	}

	public function scopePendingPayments($query){
		return $query->where('applications.status','!=',3);
	}

	public static function covertDate($date){
		$parts = explode('-', $date);

		if(!isset($parts[1])) return '';

		if(checkdate($parts[1], $parts[2], $parts[0])){
			return date("d-m-Y",strtotime($date));
		} else {
			return '';
		}
	}

	public function check_status($application){
		$var = false;
		if(Session::get('privilege') == 2 && $application->status == 2){
			$var = true;
		} else {
			if( ($application->status == 2) ){
				$var = true;
			}
		}
		return $var;
	}
}
