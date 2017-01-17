<?php


class Application extends Eloquent {

	protected $table = 'applications';

	public static function Status(){
		return array(
			"0" => "Pending for Approval",
			"1" => "Shortlisted",
			"2" => "Selected",
			"3" => "Payments Approved",
			"4" => "Referred Back",
			"5" => "Rejected"
		);
	}

	public static function applications(){
		return Application::select('courses.name as course_name', 'courses.venue','courses.id as course_id','applications.id','applications.status','applications.remarks','coaches.first_name','coaches.last_name','coaches.middle_name','license.name as license_name','coaches.full_name','coaches.id as coach_id')->join('coaches','applications.coach_id','=','coaches.id')->join('courses','applications.course_id','=','courses.id')->leftJoin('license','courses.license_id','=','license.id');
	}
	public static function applicationsResult(){
		return Application::select('courses.name as course_name', 'courses.venue','courses.id as course_id','applications.id','applications.status','application_result.remarks','coaches.first_name','coaches.last_name','coaches.middle_name','coaches.full_name','license.name as license_name','application_result.status as finalResult')->leftJoin('application_result','application_result.application_id','=','applications.id')->join('coaches','applications.coach_id','=','coaches.id')->join('courses','applications.course_id','=','courses.id')->leftJoin('license','courses.license_id','=','license.id');
	}
}

