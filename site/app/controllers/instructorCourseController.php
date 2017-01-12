<?php
class instructorCourseController extends BaseController {
    protected $layout = 'layout';

    public function index(){
    	$courses = CourseResultAdmin::select('courses.*')->join('courses','courses.id','=','course_result_admin.course_id')->where('result_admin_id',Auth::user()->id)->get();
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>12]);
        $this->layout->main = View::make('resultAdmin.courses.list',["courses" => $courses]);
    }

    public function courseApplications($course_id){
    	$course_details = Course::select('courses.name as course_name','license.name as license_name')->join('license','license.id','=','courses.license_id')->where('courses.id',$course_id)->first();

    	$applications = Application::select('coaches.full_name as coach_name','courses.name as course_name','applications.*','application_result.status as app_status','application_result.remarks as app_remarks')
    		->join('courses','applications.course_id','=','courses.id')
    		->join('coaches','applications.coach_id','=','coaches.id')
    		->leftJoin('application_result','applications.id','=','application_result.application_id')
    		->where('course_id',$course_id)
    		->where('applications.status',3)
    		->get();

    	$course_parameters = CourseParameter::select('parameters.parameter','parameters.max_marks')
    		->join('license','license.id','=','courses_parameter.license_id')
    		->join('parameters','parameters.id','=','courses_parameter.parameter_id')
    		->get();	
    	$this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>12]);
        $this->layout->main = View::make('resultAdmin.courses.applications',["applications" => $applications , "course_details" => $course_details , "course_parameters" => $course_parameters]);
    }
}