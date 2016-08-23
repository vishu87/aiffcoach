<?php
class ExcelExportController extends BaseController {
    public function coachExport($flag){
        // flag = "1"=>Approved Coach,"2"=>pending Coach,"3"=>All Coaches
        if($flag==1){
            $coaches = Coach::listing()->approved()->get();  
        }
        if($flag==2){
            $coaches = Coach::listing()->pending()->get();    
        }
        if($flag==3){
            $coaches = Coach::listing()->get();    
        }
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/coach.php'); 
    }
    public function exportLicence(){
        $licenses = License::get();
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/coach.php');
    }
    public function coursesExport($flag){
        if($flag==1){
            $courses = Course::allCourses();  
        }
        if($flag==2){
            $courses = Course::Active();    
        }
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/coach.php');
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
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/coach.php');
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
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/coach.php');
    }
}