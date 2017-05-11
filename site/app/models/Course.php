<?php

class Course extends Eloquent {

	protected $table = 'courses';

	public static function Active(){
		$currentDate = date('y-m-d',strtotime('now'));
		$query = DB::table('courses')->select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')
            ->where('registration_start','<=',$currentDate)
            ->where('registration_end','>=',$currentDate);
		return $query;
	}

	public static function Upcoming(){
		$currentDate = date('y-m-d',strtotime('now'));
		$query = DB::table('courses')->select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')
            ->where(function($query) use ($currentDate){
            	$query->where('registration_start','>',$currentDate)
			          ->orWhere('registration_start',null)
			          ->orWhere('registration_end',null);
            });
		return $query;
	}

	public static function Inactive(){
		$currentDate = date('y-m-d',strtotime('now'));
		$query = DB::table('courses')->select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->where('registration_end','<',$currentDate);
		return $query;
	}

	public static function allCourses(){
		$query = DB::table('courses')->select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id');
		return $query;
	}

	public static function courselist(){
		return [""=>"Select"]+Course::where('active',0)->lists('name','id');

	}
	
}
