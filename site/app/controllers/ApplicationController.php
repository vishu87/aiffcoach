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
        $applications =  Application::select('applications.status','applications.remarks','applications.id as application_id','courses.fees','courses.name as course_name','courses.end_date','license.id as license_id','license.name as license_name','license.authorised_by','license.description')->join('courses','applications.course_id','=','courses.id')->join('license','courses.license_id','=','license.id')->where('applications.coach_id',Auth::User()->coach_id)->get();
        $status = Application::status();
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>'4','subsidebar'=>1]);
        $this->layout->main = View::make('coaches.applications.list',['status'=>$status,"applications"=>$applications,'title'=>'Applied Applications']);

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
        Application::find($id)->delete();
        $data['success'] = true;
        $data['message'] = 'Deleted';
        return json_encode($data);
    }
    
    /************ Coaches Apply For Courses **********/

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


