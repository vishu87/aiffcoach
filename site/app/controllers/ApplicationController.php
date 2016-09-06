<?php
class ApplicationController extends BaseController {
    protected $layout = 'layout';

    public function ApprovedApplications(){
        $courses = ["" => "Select Course"] + Course::where('user_type',Auth::user()->manage_official_type)->lists('name','id');
        $status = Application::status();
        if(Input::has('course')){
            $sql = Application::applications()->where('applications.status','!=',0)->where('applications.course_id',Input::get('course'));
            $url_link = 'admin/Applications/approved?course='.Input::get('course').'&page=';
        } else {
            $sql = Application::applications()->where('applications.status','!=',0);
            $url_link = 'admin/Applications/approved?page=';
        }
        
        $total = $sql->count();
        $max_per_page = 25;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
            $page_id = Input::get('page');
        } else {
            $page_id = 1;
        }
        $applications = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'Applications','subsidebar'=>2]);
        $this->layout->main = View::make('admin.applications.list',['status'=>$status,"applications"=>$applications,'title'=>'Approved Applications','flag'=>1, "courses" => $courses,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'url_link'=>$url_link]);
    }
    
    public function PendingApplications(){
        $status = Application::status();
        $courses = ["" => "Select Course"] + Course::lists('name','id');
        if(Input::has('course')){
            $sql = Application::applications()->where('applications.status','=',0)->where('applications.course_id',Input::get('course'));
            $url_link = 'admin/Applications/pending?course='.Input::get('course').'&page=';
        } else {
            $sql = Application::applications()->where('applications.status','=',0);
            $url_link = 'admin/Applications/pending?page=';
        }
        $total = $sql->count();
        $max_per_page = 25;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
            $page_id = Input::get('page');
        } else {
            $page_id = 1;
        }
        $applications = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'Applications','subsidebar'=>3]);
        $this->layout->main = View::make('admin.applications.list',['status'=>$status,"courses" => $courses,"applications"=>$applications,'title'=>'Pending Applications','flag'=>2,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'url_link'=>$url_link]);
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
    public function details($course_id){

        $course = Course::select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->where('courses.id',$course_id)->first();

        $is_applied = Application::where('course_id',$course_id)->where('coach_id',Auth::user()->coach_id)->first();

        if($course->prerequisite_id != '')
        $prerequisites = explode(',',$course->prerequisite_id);
        else $prerequisites = array();

        $coach_licenses = array();

        if($course->prerequisite_id != ''){
            $coach_licenses_fetch = CoachLicense::where('coach_id', Auth::user()->coach_id)->whereIn('license_id',$prerequisites)->where('status',1)->get();
            foreach ($coach_licenses_fetch as $license) {
                $coach_licenses[$license->license_id] = array("start_date"=>$license->start_date);
            } 
        }

        $licenses = License::licenseList();
      
        $tab = 5;
        $tab_sub = 0;

        $check_date_year = date("Y",strtotime($course->start_date));
        $check_date_year = $check_date_year - 2;
        $check_date = $check_date_year.'-'.date("m",strtotime($course->start_date)).'-'.date("d",strtotime($course->start_date));

        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>$tab,'subsidebar'=>$tab_sub]);

        $this->layout->main = View::make('coaches.courses.details',["course"=>$course, 'is_applied'=>$is_applied,"prerequisites"=>$prerequisites, "licenses"=>$licenses, "coach_licenses" => $coach_licenses, "check_date" => $check_date]);
    }

    public function applyCourse($course_id){
        $check = Application::where('course_id',$course_id)->where('coach_id',Auth::user()->coach_id)->count();
        if($check == 0){
            $cre=[
                "remarks"=>Input::get('remarks')
            ];
            $rules=[
                "remarks"=>"required"
            ];
            $validation=Validator::make($cre,$rules);
            if($validation->passes()){
                $application = new Application;
                $application->course_id = $course_id;
                $application->coach_id = Auth::user()->coach_id;
                $application->status = 0;
                $application->remarks = '';
                $application->save(); 
                
                $log = new ApplicationLog;
                $log->entity_id = $application->id;
                $log->status = 0;
                $log->user_id = Auth::id();
                $log->remarks = Input::get('remarks');

                return Redirect::back()->with('success','You have successfully applied for the course');
            } else {
                return Redirect::back()->with('failure','Please fill mandatory fields');
            }
        } else {
            return Redirect::back()->with('failure','You have already applied for this course');
        }
    }
}