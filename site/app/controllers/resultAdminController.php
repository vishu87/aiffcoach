
<?php
class resultAdminController extends BaseController {
    protected $layout = 'layout';

    public function index(){
        $status = Application::status();$courses = ["" => "Select Course"] + Course::lists('name','id');
        if(Input::has('course')){
            $applications = Application::applications()->where('applications.status',3)->where('applications.course_id',Input::get('course'))->get();
        } else {
            $applications = [];
            // $applications = Application::applications()->where('applications.status',3)->get();
        }
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>1,'subsidebar'=>1]);
        $this->layout->main = View::make('resultAdmin.index',['status'=>$status,"applications"=>$applications,'title'=>'Applications Results','flag'=>1, "courses" => $courses]);
    }


    
}