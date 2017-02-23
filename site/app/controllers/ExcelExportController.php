<?php
class ExcelExportController extends BaseController {
    public function coachExport($flag){
        // flag = "1"=>Approved Coach,"2"=>pending Coach,"3"=>All Coaches
        if($flag==1){
            $sql = Coach::listing()->approved()->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%');  
        }
        if($flag==2){
            $sql = Coach::listing()->pending()->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%');    
            
            $pending_type = 0;

            if(Input::has('pending_type')){
              $pending_type = Input::get('pending_type');
            }

            if(Session::get('privilege') == 4){
              $sql = $sql->where('coaches.status', $pending_type);
            } else {
              $sql = $sql->where('coaches.status', $pending_type)->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%');
            }
        }
        if($flag==3){
            $sql = Coach::listing();    
        }

        if(Input::get("registration_id") != ''){
          $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
        }

        if(Input::get("license_id") != ''){
          $sql = $sql->join('coach_licenses','coach_licenses.coach_id','=','coaches.id')->where('coach_licenses.license_id','=',Input::get('license_id'));
        }

        if(Input::get("official_name") != ''){
          $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
        }

        if(Input::get("state_id") != ''){
          $sql = $sql->where('coaches.state_id',Input::get('state_id'));
        }

        $coaches =$sql->get();

        if(sizeof($coaches)>0){
            include(app_path().'/libraries/Classes/PHPExcel.php');
            include(app_path().'/libraries/export/coach.php'); 
        } else {
            return Redirect::back()->with('failure','No data found to export');
        }
        
    }
    public function exportLicence(){
        $licenses = License::where('user_type',Auth::user()->manage_official_type)->get();
        if(sizeof($licenses)>0){
            include(app_path().'/libraries/Classes/PHPExcel.php');
            include(app_path().'/libraries/export/coach.php'); 
        } else {
            return Redirect::back()->with('failure','No data found to export');
        }
    }
    public function coursesExport($flag){
        if($flag==1){
            $courses = Course::allCourses()->where('courses.user_type',Auth::user()->manage_official_type)->get();  
        }
        if($flag==2){
            $courses = Course::Active()->where('courses.user_type',Auth::user()->manage_official_type)->get();    
        }
        if(sizeof($courses)>0){
            include(app_path().'/libraries/Classes/PHPExcel.php');
            include(app_path().'/libraries/export/coach.php'); 
        } else {
            return Redirect::back()->with('failure','No data found to export');
        }
    }
    public function applicationExport($flag,$course_id=0){
        if($flag==1){
            if($course_id!=''){
                $applications = Application::applications()->where('applications.status',3)->where('course_id',$course_id)->get();
            }
            else{
                $applications = Application::applications()->where('applications.status',3)->get();
            }
        }
        if($flag==2){
            if($course_id!=''){
                $applications = Application::applications()->where('applications.status','!=',3)->where('course_id',$course_id)->get();
            }
            else{
                $applications = Application::applications()->where('applications.status','!=',3)->get();
            }  
        }
        if(sizeof($applications)>0){
            include(app_path().'/libraries/Classes/PHPExcel.php');
            include(app_path().'/libraries/export/coach.php'); 
        } else {
            return Redirect::back()->with('failure','No data found to export');
        }
    }
    public function paymentExport($flag,$course_id=0){
        if($flag==1){
            if($course_id!='' && $course_id!=0){
                $payments = Payment::listing()->where('applications.course_id',$course_id)->get();
            }
            else{
                $payments = Payment::listing()->get();
            }
        }
        if($flag==2){
            if($course_id!='' && $course_id!=0){
                $payments = Payment::listing()->pendingPayments()->where('applications.course_id',$course_id)->get();
            }
            else{
                $payments = Payment::listing()->pendingPayments()->get();
            }  
        }
        if(sizeof($payments)>0){
            include(app_path().'/libraries/Classes/PHPExcel.php');
            include(app_path().'/libraries/export/coach.php'); 
        } else {
            return Redirect::back()->with('failure','No data found to export');
        }
    }
    public function resultExport(){
        $results = [];
        if(sizeof($results)>0){
            include(app_path().'/libraries/Classes/PHPExcel.php');
            include(app_path().'/libraries/export/coach.php'); 
        } else {
            return Redirect::back()->with('failure','No data found to export');
        }
    }

    public function exportCoaches(){
        $sql = Coach::listing()->addSelect('license.name as latest_license')->join('coach_licenses','coach_licenses.coach_id','=','coaches.id')->join('license','coach_licenses.license_id','=','license.id')->orderBy('coach_licenses.start_date','desc')->approved();
        
        if(Input::get("license_id") != ''){
          $sql = $sql->where('coach_licenses.license_id','=',Input::get('license_id'));
        }
        if(Input::get("registration_id") != ''){
          $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
        }
        if(Input::get("official_name") != ''){
          $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
        }


        if(Input::get("state_id") != ''){
          $sql = $sql->where('coaches.state_id',Input::get('state_id'));
        }

        $exportCoaches = $sql->get();

        $status = Coach::Status();
        // $licenses = License::licenseList();
        $states = State::states();

        $coach_licenses_sql = CoachLicense::select('coach_id','start_date','license_id','license.name as license_name')->join('license','license.id','=','coach_licenses.license_id')->where('status',1)->orderBy('start_date','desc');

        if(Input::get("license_id") != ''){
          $coach_licenses_sql = $coach_licenses_sql->where('coach_licenses.license_id','!=',Input::get('license_id'));
        }

        $coach_licenses = $coach_licenses_sql->get();

        $latest_license = [];

        foreach ($coach_licenses as $license) {
            if(!isset($latest_license[$license->coach_id]))
                $latest_license[$license->coach_id] = array();
                array_push($latest_license[$license->coach_id], $license->license_name);
        }

        $coach_emps = EmploymentDetails::select('coach_id','employment')->where('status',1)->orderBy('start_date','desc')->get();

        $latest_emps = [];

        foreach ($coach_emps as $emps) {
            if(!isset($latest_emps[$emps->coach_id]))
                $latest_emps[$emps->coach_id] = $emps->employment;
        }

        if(sizeof($exportCoaches)>0){
            include(app_path().'/libraries/Classes/PHPExcel.php');
            include(app_path().'/libraries/export/coach.php'); 
        } else {
            return Redirect::back()->with('failure','No data found to export');
        }
        
        
    }

}