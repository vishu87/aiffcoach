<?php


class Payment extends Eloquent {

	protected $table = 'payment';

	public static function listing(){
		return Payment::select('coaches.full_name','applications.status as status_app','courses.name as course_name','payment.*')->leftJoin('applications','payment.application_id','=','applications.id')->leftJoin('courses','applications.course_id','=','courses.id')->join('coaches','applications.coach_id','=','coaches.id');
	}

	public function scopePendingPayments($query){
		return $query->where('applications.status','!=',3);
	}
}
