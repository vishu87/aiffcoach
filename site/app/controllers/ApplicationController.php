<?php

class ApplicationController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected $layout = 'layout';

    public function ApprovedApplications(){

        $courses = ["" => "Select Course"] + Course::lists('name','id');
        $status = Application::status();
        if(Input::has('course')){
            $applications = Application::applications()->where('applications.status','!=',0)->where('applications.course_id',Input::get('course'))->get();
        } else {
            $applications = Application::applications()->where('applications.status','!=',0)->get();
        }
        
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'Applications','subsidebar'=>2]);
        $this->layout->main = View::make('admin.applications.list',['status'=>$status,"applications"=>$applications,'title'=>'Approved Applications','flag'=>1, "courses" => $courses]);
    }
    
    public function PendingApplications(){
        $status = Application::status();
        $courses = ["" => "Select Course"] + Course::lists('name','id');
        if(Input::has('course')){
            $applications = Application::applications()->where('applications.status','=',0)->where('applications.course_id',Input::get('course'))->get();
        } else {
            $applications = Application::applications()->where('applications.status','=',0)->get();
        }
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'Applications','subsidebar'=>3]);
        $this->layout->main = View::make('admin.applications.list',['status'=>$status,"courses" => $courses,"applications"=>$applications,'title'=>'Pending Applications','flag'=>2]);
    }

    public function markApplication($id,$count){
        $application = Application::find($id);
        if($application->status==0){
            DB::table('applications')->where('id',$id)->update(["status"=>1]);
            
            $flag = 1;
        }
        else{
            DB::table('applications')->where('id',$id)->update(["status"=>0]);
            
            $flag = 0;

        }
        $status = Application::status();
        
        $application->save();
        $applications = Application::applications()->where('applications.id',$id)->first();
        $data['success'] = true;
        $data['message'] = html_entity_decode(View::make('admin.applications.view',['status'=>$status,'data'=>$applications,'count'=>$count,'flag'=>$flag]));
        return json_encode($data);
    }

    /************* Coaches methods return here********/
    public function applied(){
        $applications =  Application::select('applications.status','application_result.status as finalResult','applications.remarks','applications.id as application_id','courses.fees','courses.name as course_name','courses.end_date','license.id as license_id','license.name as license_name','license.authorised_by','license.description')
            ->join('courses','applications.course_id','=','courses.id')
            ->join('license','courses.license_id','=','license.id')
            ->leftJoin('application_result','applications.id','=','application_result.application_id')
            ->where('applications.coach_id',Auth::User()->coach_id)
            ->get();
        $status = Application::status();
        $resultStatus = Result::status();
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>'4','subsidebar'=>1]);
        $this->layout->main = View::make('coaches.applications.list',['resultStatus'=>$resultStatus,'status'=>$status,"applications"=>$applications,'title'=>'Applied Applications']);

    }

    public function viewMarks($application_id){
        $course = Application::select('license.id as license_id')->join('courses','applications.course_id','=','courses.id')->join('license','courses.license_id','=','license.id')->where('applications.id',$application_id)->first();
        $parameters = CourseParameter::select('parameters.parameter','parameters.max_marks','courses_parameter.parameter_id')
            ->join('parameters','courses_parameter.parameter_id','=','parameters.id')
            ->where('license_id',$course->license_id)
            ->where('courses_parameter.active',0)
            ->get();
        $results = Result::where('application_id',$application_id)->get();   
        return View::make('coaches.applications.marks',['parameters'=>$parameters,'application_id'=>$application_id,"results"=>$results]);
    }
    public function active(){
        $currentDate = date('y-m-d',strtotime('now'));
        $applications =  Course::select('courses.id','courses.name as course_name','courses.end_date','courses.fees','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->where('end_date','>=',$currentDate)->get();
         $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>'4','subsidebar'=>2]);
        $this->layout->main = View::make('coaches.applications.list',["applications"=>$applications,'value'=>1,'title'=>'Active Applications']);
    }
    public function inactive(){
        $currentDate = date('y-m-d',strtotime('now'));
        $applications =  Course::select('courses.id','courses.name as course_name','courses.end_date','courses.fees','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->where('end_date','<',$currentDate)->get();
         $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>'4','subsidebar'=>3]);
        $this->layout->main = View::make('coaches.applications.list',["applications"=>$applications,'value'=>2,'title'=>'Active Applications']);
    }

    public function deleteCoachApplication($id){
        $count = Application::where('id',$id)->count();
        if($count<1){
            $data['success'] = false;
            $data['message'] = 'This Item does not exist';
        }
        else{
            Application::find($id)->delete();
            $data['success'] = true;
            $data['message'] = 'Deleted';
        }
        return json_encode($data);
    }
    
    /************ Coaches Apply For Courses **********/

    public function details($course_id,$tab_type){
        $course = Course::select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->where('courses.id',$course_id)->first();
        $appliedCourses = Application::where('course_id',$course_id)->where('coach_id',Auth::User()->coach_id)->get();
        $checkAppliedCourses = array();
        foreach ($appliedCourses as $value) {
                $checkAppliedCourses[] =$value->course_id; 
            }    
        switch ($tab_type) {
                case 1:
                    $tab = 5;
                    $tab_sub = 1;
                    break;
                case 2:
                    $tab = 5;
                    $tab_sub = 2;
                    break;
                case 3:
                    $tab = 'dashboard';
                    $tab_sub = '';
                default:
                    $tab = 'dashboard';
                    $tab_sub = '';
                    break;
            }    
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>$tab,'subsidebar'=>$tab_sub]);
        $this->layout->main = View::make('coaches.courses.details',["course"=>$course,'checkAppliedCourses'=>$checkAppliedCourses,'tab_type'=>$tab_type]);
    } 

    public function applyCourse($course_id){
        $application = new Application;
        $application->course_id = $course_id;
        $application->coach_id = Auth::User()->coach_id;
        $application->status = 0;
        $application->remarks = 'Applied | Pending';
        $application->save(); 
        $data['success'] = true;
        $data['btn_title'] = 'Applied';
        $data['remove_class'] = 'apply-course';
        $data['message'] = 'You Have Successfully Applied For This Course';
        return json_encode($data);
    }
}


