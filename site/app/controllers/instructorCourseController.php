<?php
class instructorCourseController extends BaseController {
    protected $layout = 'layout';

    public function index(){
    	$courses = CourseResultAdmin::select('courses.*')->join('courses','courses.id','=','course_result_admin.course_id')->where('result_admin_id',Auth::user()->id)->get();
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>12]);
        $this->layout->main = View::make('resultAdmin.courses.list',["courses" => $courses]);
    }

    public function courseApplications($course_id){
    	$course_details = Course::select('courses.name as course_name','license.name as license_name','courses.license_id')->join('license','license.id','=','courses.license_id')->where('courses.id',$course_id)->first();

    	$applications = Application::select('coaches.full_name as coach_name','courses.name as course_name','applications.*','application_result.status as app_status','application_result.remarks as app_remarks')
    		->join('courses','applications.course_id','=','courses.id')
    		->join('coaches','applications.coach_id','=','coaches.id')
    		->leftJoin('application_result','applications.id','=','application_result.application_id')
            ->leftJoin('payment','payment.application_id','=','applications.id')
    		->where('course_id',$course_id)
    		->where('payment.status',1)
    		->get();

    	$course_parameters = CourseParameter::select('parameters.*')
    		->join('license','license.id','=','courses_parameter.license_id')
    		->join('parameters','parameters.id','=','courses_parameter.parameter_id')
            ->where('courses_parameter.license_id',$course_details->license_id)
    		->get();


        $evaluated_apps = [];
        if(sizeof($applications) > 0){
            foreach ($applications as $app) {
                array_push($evaluated_apps,$app->id);
            }
        }

        $app_marks = [];
        $app_result_status = [];
        
        if(sizeof($evaluated_apps) > 0){
            $app_marks_data = Result::select('application_id','parameter_id','marks')->whereIn('application_id',$evaluated_apps)->get();

            foreach ($app_marks_data as $data) {
                if(!isset($app_marks[$data->application_id][$data->parameter_id]))$app_marks[$data->application_id][$data->parameter_id] = $data->marks;
            }

            $app_result_status = ApplicationResult::whereIn('application_id',$evaluated_apps)->lists('status','application_id');
        }



        $result_status = Result::status();  
        
    	$this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>12]);
        $this->layout->main = View::make('resultAdmin.courses.applications',["applications" => $applications , "course_details" => $course_details , "course_parameters" => $course_parameters , "result_status" => $result_status , "course_id" => $course_id , "app_result_status" => $app_result_status , "app_marks" => $app_marks]);
    }

    public function addResult(){

        $course_id = Input::get('course_id');

        $course_details = Course::select('courses.license_id')->where('courses.id',$course_id)->first();

        $applications = Application::select('applications.id')
            ->leftJoin('payment','payment.application_id','=','applications.id')
            ->where('course_id',$course_id)
            ->where('payment.status',1)
            ->get();

        $course_parameters = CourseParameter::select('parameter_id')
            ->where('license_id',$course_details->license_id)
            ->get();

        foreach ($applications as $application){

            foreach ($course_parameters as $parameter) {

                $result = Result::where('application_id',$application->id)->where('parameter_id',$parameter->parameter_id)->first();

                if(sizeof($result) < 1 ){

                    $new_result = new Result;
                    $new_result->application_id = $application->id;
                    $new_result->parameter_id = $parameter->parameter_id;
                    $new_result->marks = Input::get('parameter_'.$application->id.'_'.$parameter->parameter_id);
                    $new_result->save();

                }else{
                    $result->marks = Input::get('parameter_'.$application->id.'_'.$parameter->parameter_id);
                    $result->save();
                }

            }

            $application_result = ApplicationResult::where('application_id',$application->id)->first();
            if(sizeof($application_result) > 0){
                $application_result->status = Input::get('status_'.$application->id);
                $application_result->save();
            }else{
                $new_app_status = new ApplicationResult;
                $new_app_status->status = Input::get('status_'.$application->id);
                $new_app_status->application_id = $application->id;
                $new_app_status->save();
            }
        }    

        return Redirect::back()->with('success','Marks updated');
    }
}