<?php
class ApplicationController extends BaseController {
    protected $layout = 'layout';

    public function ApprovedApplications(){

        $courses = array();
        $courses[""] = "All Courses";

        $courses_get = Course::where('user_type',Auth::user()->manage_official_type)->get();
        foreach ($courses_get as $course) {
            $courses[$course->id] = $course->name.', '.$course->venue.', '.date("d-m-Y", strtotime($course->start_date));
        }

        $status = Application::status();

        $sql = Application::applicationsWithPayments()->where('courses.user_type',Auth::user()->manage_official_type);

        $application_status = 0;

        if(Input::has('status')){
            if(Input::get('status') != '' && Input::get('status') != 0){
                $application_status = Input::get('status');
            }
        }

        if($application_status == 3){
            $sql = $sql->where('payment.status',1);
        } else {
            $sql = $sql->where('applications.status',$application_status);
        }

        if(Input::has('course')){
            if(Input::get('course') != '' && Input::get('course') != 0){
                $sql = $sql->where('applications.course_id',Input::get('course'));
            }
        }


        $input_string = 'admin/Applications/all?';

        $total = $sql->count();
        $max_per_page = 100;
        $total_pages = ceil($total/$max_per_page);

        if(Input::has('page')){
          $page_id = Input::get('page');
        } else {
          $page_id = 1;
        }

        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $input_string .= ($count_string == 0)?'':'&';
            $input_string .= $key.'='.$value;
            $count_string++;
          }
        }
        $applications = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();

        if(Input::has('excel_export') && Input::get('excel_export') == 1 ){
            $sql = $sql->addSelect('states.name as state_registration','coach_parameters.email','coach_parameters.mobile')->join('coach_parameters','coach_parameters.coach_id','=','coaches.id')->leftJoin('states','states.id','=','coaches.state_id');

            $export_applications = $sql->get(); 
            $present_emp = [];
            $past_emp = [];
            $d_license_date = [];

            foreach ($export_applications as $application) {
                $coach_present_emp = EmploymentDetails::select('employment')->where('coach_id',$application->coach_id)->where('emp_status',1)->where('status',1)->orderBy('start_date','desc')->first();
                $coach_past_emp = EmploymentDetails::select('employment')->where('coach_id',$application->coach_id)->where('emp_status',2)->where('status',1)->orderBy('start_date','desc')->first();
                $coach_dlicense = CoachLicense::select('start_date')->where('coach_id',$application->coach_id)->where('license_id',8)->orderBy('start_date','desc')->first();

                if(sizeof($coach_present_emp)>0){
                    if($coach_present_emp->employment != ''){

                        if(!isset($present_emp[$application->coach_id]))$present_emp[$application->coach_id]=array();
                        $present_emp[$application->coach_id] = $coach_present_emp->employment;
                    }
                }

                if(sizeof($coach_past_emp) > 0){
                    if($coach_past_emp->employment != ''){

                        if(!isset($past_emp[$application->coach_id]))$past_emp[$application->coach_id]=array();
                        $past_emp[$application->coach_id] = $coach_past_emp->employment;
                    }
                }

                if(sizeof($coach_dlicense) > 0){
                    if($coach_dlicense->start_date != ''){

                        if(!isset($d_license_date[$application->coach_id]))$d_license_date[$application->coach_id] = array();
                        $d_license_date[$application->coach_id] =  $coach_dlicense->start_date;
                    }
                }

            }

            if(sizeof($export_applications)>0){
                include(app_path().'/libraries/Classes/PHPExcel.php');
                include(app_path().'/libraries/export/applicationsExport.php'); 
            }else{
                return Redirect::back()->with('failure','No Data Found to export');
            }
        }

        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'Applications','subsidebar'=>2]);
        
        $this->layout->main = View::make('admin.applications.list',['status'=>$status,"applications"=>$applications,'title'=>'Applications','flag'=>1, "courses" => $courses,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string, "application_status" => $application_status]);


    }

    /************* Coaches methods return here********/
    public function applied(){

        $applications =  Application::select('applications.status','application_result.status as finalResult','applications.remarks','applications.id as application_id','courses.fees','courses.name as course_name','courses.venue', 'applications.created_at', 'courses.id as course_id','courses.venue')
            ->join('courses','applications.course_id','=','courses.id')
            ->leftJoin('application_result','applications.id','=','application_result.application_id')
            ->where('applications.coach_id',Auth::User()->coach_id)
            ->get();
        $status = Application::status();
        $resultStatus = Result::status();
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>'4','subsidebar'=>1]);
        $this->layout->main = View::make('coaches.applications.list',['resultStatus'=>$resultStatus,'status'=>$status,"applications"=>$applications,'title'=>'My Applications']);
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
            $data['message'] = 'This Application does not exist';
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

        $course = Course::select('courses.*','license.name as license_name','license.prerequisite_id','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->where('courses.id',$course_id)->first();

        $is_applied = Application::where('course_id',$course_id)->where('coach_id',Auth::user()->coach_id)->first();

        if($course->prerequisite_id != '')
            $prerequisites = explode(',',$course->prerequisite_id);
        else $prerequisites = array();

        $coach_licenses = array();

        if($course->prerequisite_id != ''){
            $coach_licenses_fetch = CoachLicense::select('coach_licenses.*','license.duration')->join('license','license.id','=','coach_licenses.license_id')->where('coach_id', Auth::user()->coach_id)->whereIn('license_id',$prerequisites)->get();
            foreach ($coach_licenses_fetch as $license) {
                $coach_licenses[$license->license_id] = array("start_date"=>$license->start_date, "duration" => $license->duration, "status" => $license->status );
            }
        }

        $licenses = License::licenseList();
      
        $tab = 5;
        $tab_sub = 0;

        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>$tab,'subsidebar'=>$tab_sub]);

        $this->layout->main = View::make('coaches.courses.details',["course"=>$course, 'is_applied'=>$is_applied,"prerequisites"=>$prerequisites, "licenses"=>$licenses, "coach_licenses" => $coach_licenses]);
    }

    public function detailsApplication($application_id){

        $application = Application::select('applications.*','license.name as license_name','coaches.full_name', 'coaches.status as coach_status')->join('coaches','applications.coach_id','=','coaches.id')->join('courses','applications.course_id','=','courses.id')->leftJoin('license','courses.license_id','=','license.id')->where('applications.id',$application_id)->first();
        $course = Course::select('courses.*','license.name as license_name','license.prerequisite_id','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')->where('courses.id',$application->course_id)->first();
        $ApplicationStatus = Application::status();
        if($course->prerequisite_id != '')
        $prerequisites = explode(',',$course->prerequisite_id);
        else $prerequisites = array();

        $coach_licenses = array();

        if($course->prerequisite_id != ''){

            $coach_licenses_fetch = CoachLicense::select('coach_licenses.*','license.duration')->join('license','license.id','=','coach_licenses.license_id')->where('coach_id', $application->coach_id)->whereIn('license_id',$prerequisites)->get();
            foreach ($coach_licenses_fetch as $license) {
                $coach_licenses[$license->license_id] = array("start_date"=>$license->start_date, "duration" => $license->duration, "status" => $license->status );
            } 
        }

        $licenses = License::licenseList();

        $check_date_year = date("Y",strtotime($course->start_date));
        $check_date_year = $check_date_year - 2;
        $check_date = $check_date_year.'-'.date("m",strtotime($course->start_date)).'-'.date("d",strtotime($course->start_date));

        if(Session::get('privilege') == 1){
            $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>4,'subsidebar'=>0]);
        } else {
            $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'Applications','subsidebar'=>0]);
        }
        
        $application_log = ApplicationLog::where('application_log.entity_id',$application_id)->orderBy('created_at','DESC')->get();

        $payment = Payment::where('application_id',$application_id)->first();

        $this->layout->main = View::make('admin.applications.details',["course"=>$course, "prerequisites"=>$prerequisites, "licenses"=>$licenses, "coach_licenses" => $coach_licenses, "check_date" => $check_date, "application" => $application, "application_log" => $application_log, "payment" => $payment, "ApplicationStatus" => $ApplicationStatus]);
    }

    public function applyCourse($course_id){
        $check = Application::where('course_id',$course_id)->where('coach_id',Auth::user()->coach_id)->count();
        if($check == 0){
           
            $application = new Application;
            $application->course_id = $course_id;
            $application->coach_id = Auth::user()->coach_id;
            $application->status = 0;
            $application->remarks = '';
            $application->save(); 
            
            $log = new ApplicationLog;
            $log->entity_id = $application->id;
            $log->status = 0;
            $log->save();

            return Redirect::back()->with('success','You have successfully applied for the course');
        
        } else {
            return Redirect::back()->with('failure','You have already applied for this course');
        }
    }

    public function selectApplication($application_id){
        
        $application = Application::find($application_id);
        $application->status = 2;
        $application->save();

        $course = Course::find($application->course_id);
        
        $check_payment = Payment::where('application_id',$application_id)->count();
        if($check_payment == 0){
            $payment = new Payment;
            $payment->application_id = $application_id;
            $course_row = Course::select('fees')->where('id',$application->course_id)->first();
            $payment->fees = $course_row->fees;
            $payment->save();
        }

        $email = User::where('coach_id',$application->coach_id)->pluck('username');

        require app_path().'/classes/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isMail();
        $mail->setFrom('info@the-aiff.com', 'All India Football Federation');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "AIFF - your application is selected";
        $mail->Body = View::make('mail',["type" => 5, "course" => $course]);
        $mail->send();

        $data['success'] = true;
        $data['message'] = 'Selected';
        return json_encode($data);
    }

    public function notSelectApplication($application_id){
        
        $application = Application::find($application_id);
        $application->status = 6;
        $application->save();
        
        // $check_payment = Payment::where('application_id',$application_id)->count();
        // if($check_payment == 0){
        //     $payment = new Payment;
        //     $payment->application_id = $application_id;
        //     $course_row = Course::select('fees')->where('id',$application->course_id)->first();
        //     $payment->fees = $course_row->fees;
        //     $payment->save();
        // }

        $data['success'] = true;
        $data['message'] = 'Not Selected';
        return json_encode($data);
    }


    public function postLog($log_id){
        $cre=[
            "remarks"=>Input::get('remarks'),
            "type"=>Input::get('type')
        ];
        $rules=[
            "remarks"=>"required",
            "type"=>"required"
        ];
        $validation=Validator::make($cre,$rules);
        if($validation->passes()){

            $log = ApplicationLog::find($log_id);
            $application = Application::where('id',$log->entity_id)->first();
            if($log->closed == 0){

                $current_status = $log->status;

                $type = Input::get('type');
                //save current log
                $log->user_id = Auth::id();
                $log->type = $type;
                $log->remarks = Input::get('remarks');
                
                if(Input::hasFile('document')){
                    $destinationPath = "approval_docs/";
                    $extension = Input::file('document')->getClientOriginalExtension();
                    $filename = $log_id.'-LogDocument-'.strtotime("now").'.'.$extension;
                    Input::file('document')->move($destinationPath,$filename);
                    $log->document = $destinationPath.$filename;
                }

                $log->closed = 1;
                $log->save();

                if($type == 1){

                    if($current_status == 0){
                        $application->status = ++$current_status;
                    } else { 
                        //for referred back re-submit by user
                        $new_log = new ApplicationLog;
                        $new_log->entity_id = $application->id;
                        $new_log->status = 0;
                        $new_log->save();
                        $application->status = 0;
                    }

                    // if($current_status == 2){
                    //     //create a payment
                    //     $check_payment = Payment::where('application_id',$application->id)->count();

                    //     if($check_payment == 0){
                    //         $payment = new Payment;
                    //         $payment->application_id = $application->id;
                    //         $course_row = Course::select('fees')->where('id',$application->course_id)->first();
                    //         $payment->fees = $course_row->fees;
                    //         $payment->save();
                    //     }
                        
                    // }


                    // if($current_status == 1 || $current_status == 2){
                    //     //create new log entry
                    //     $new_log = new ApplicationLog;
                    //     $new_log->entity_id = $application->id;
                    //     $new_log->status = $current_status;
                    //     $new_log->save();
                    // } elseif($current_status == 3){
                    //     // do nothing
                    // } else {
                    //     //create new log entry for association
                    //     $new_log = new ApplicationLog;
                    //     $new_log->entity_id = $application->id;
                    //     $new_log->status = 0;
                    //     $new_log->save();
                    //     $application->status = 0;
                    // }
                } else {
                    $application->status = $type;
                    if($type == 4){ // if referred back
                        //create new log entry for application
                        $new_log = new ApplicationLog;
                        $new_log->entity_id = $application->id;
                        $new_log->status = $type;
                        $new_log->save();
                    }
                }

                if($type == 4 || $type == 5){
                    $email = User::where('coach_id',$application->coach_id)->pluck('username');
                    $ref_type = ($type == 4)?'referred back':'rejected';
                    require app_path().'/classes/PHPMailerAutoload.php';
                    $mail = new PHPMailer;
                    $mail->isMail();
                    $mail->setFrom('info@the-aiff.com', 'All India Football Federation');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = "AIFF - Problem with your application";
                    $mail->Body = View::make('mail',["type" => 4, "ref_type" => $ref_type, "remarks" => Input::get('remarks')]);
                    $mail->send();
                }
                $application->save();
     
                return Redirect::Back();
            } else {
                return Redirect::Back()->with('failure','Log has been closed');
            }
        } else {
            return Redirect::Back()->with('failure','Please provide all fields');
        }

    }

    public function editAppLog($log_id){
        $log = ApplicationLog::find($log_id);
        return View::make('admin.applications.editLog',['log'=>$log , 'flag'=>false]);
    }
    public function updateAppLog($log_id){
        $log = ApplicationLog::find($log_id);
        $log->remarks = Input::get('remarks');
        $log->save();
        $data['success'] = true;
        $data['message'] = html_entity_decode(View::make('admin.applications.editLog',['log'=>$log , 'flag'=>true]));
        return json_encode($data);

    }

    public function deleteAppLog($log_id){
        $log = ApplicationLog::find($log_id)->delete();

        if($log){
          $data['success'] = true;
          $data['message'] = 'Remark Deleted Successfully';
        }else{
          $data['success'] = false;
          $data['message'] = 'Remark no longer exist';
        }
        return json_encode($data);
    }
}