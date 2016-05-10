<?php


class Application extends Eloquent {

	protected $table = 'applications';

	public static function Status(){
		return array(
			"0" => "Approval Pending",
			"1" => "Payment Pending",
			"2" => "Payment Approval Pending",
			"3" => "Approved",
		);
	}

	public static function applications(){
		return Application::select('courses.name as course_name','courses.id as course_id','applications.id','applications.status','applications.remarks','coaches.first_name','coaches.last_name','coaches.middle_name')->join('coaches','applications.coach_id','=','coaches.id')->join('courses','applications.course_id','=','courses.id');
	}
}

