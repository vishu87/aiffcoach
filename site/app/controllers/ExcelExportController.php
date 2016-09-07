<?php
class ExcelExportController extends BaseController {
    public function coachExport($flag){
        // flag = "1"=>Approved Coach,"2"=>pending Coach,"3"=>All Coaches
        if($flag==1){
            $coaches = Coach::listing()->approved()->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->get();  
        }
        if($flag==2){
            $coaches = Coach::listing()->pending()->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->get();    
        }
        if($flag==3){
            $coaches = Coach::listing()->get();    
        }
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

}