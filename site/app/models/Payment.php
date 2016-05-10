<?php


class Payment extends Eloquent {

	protected $table = 'payment';

	/*
	"0" => "Approval Pending",
	"1" => "Payment Pending",
	"2" => "Payment Approval Pending",
	"3" => "Approved",
	*/
	public static function listing(){
		return Payment::select('coaches.first_name','coaches.middle_name','applications.status as status_app','coaches.last_name','courses.name as course_name','payment.*')->join('applications','payment.application_id','=','applications.id')->join('courses','applications.course_id','=','courses.id')->join('coaches','applications.coach_id','=','coaches.id');
	}

	public function scopePendingPayments($query){
		return $query->where('applications.status','!=',3);
	}
}
