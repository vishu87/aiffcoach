<?php


class Course extends Eloquent {

	protected $table = 'courses';

	public static function Active(){
		$currentDate = date('y-m-d',strtotime('now'));
		$query = DB::table('courses')->select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->where('end_date','>=',$currentDate)->get();
		return $query;
	}
	public static function Inactive(){
		$currentDate = date('y-m-d',strtotime('now'));
		$query = DB::table('courses')->select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->where('end_date','<',$currentDate)->get();
		return $query;
	}
	public static function allCourses(){
		$query = DB::table('courses')->select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->get();
		return $query;
	}

	public static function courselist(){
		return [""=>"Select"]+Course::where('active',0)->lists('name','id');

	}
}
