<?php

class PaymentController extends BaseController {
    protected $layout = 'layout';
    // admin panel function  starts
    public function index(){

        if(Input::has('course')){
            $sql = Payment::listing()->where('courses.user_type',Auth::user()->manage_official_type)->where('applications.course_id',Input::get('course'));
        }
        else{
            $sql = Payment::listing()->where('courses.user_type',Auth::user()->manage_official_type);
        }
        
        $total = $sql->count();
        $max_per_page = 100;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
          $page_id = Input::get('page');
        } else {
          $page_id = 1;
        }

        $input_string = 'admin/Payment?';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $input_string .= ($count_string == 0)?'':'&';
            $input_string .= $key.'='.$value;
            $count_string++;
          }
        }
        $payments = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        
        $courses[""] = "All Courses";
        $courses_get = Course::where('user_type',Auth::user()->manage_official_type)->orderBy('start_date')->get();
        foreach ($courses_get as $course) {
            $courses[$course->id] = $course->name.', '.$course->venue.', '.date("d-m-Y", strtotime($course->start_date));
        }

        $status = Application::status();

        if(Input::has('type') && Input::get('type')=='export'){
            $exportPayment = $sql->get();
            if(sizeof($exportPayment)>0){
                include(app_path().'/libraries/Classes/PHPExcel.php');
                include(app_path().'/libraries/export/export-payment.php'); 
            } else {
                return Redirect::back()->with('failure','No data found to export');
            }
        }
        
        $this->layout->sidebar = View::make('admin.sidebar',["sidebar"=>'payment','subsidebar'=>1]);
        $this->layout->main = View::make('admin.payment.list',['courses'=>$courses,'status'=>$status,'payments'=>$payments,"title"=>'Payment Due List','flag'=>1,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string]);
    }
    // public function pendingPayments(){
    //     if(Input::has('course')){
    //         $sql = Payment::listing()->pendingPayments()->where('applications.course_id',Input::get('course'));
    //     }
    //     else{
    //         $sql = Payment::listing()->pendingPayments();
    //     }
        
    //     $total = $sql->count();
    //     $max_per_page = 100;
    //     $total_pages = ceil($total/$max_per_page);
    //     if(Input::has('page')){
    //       $page_id = Input::get('page');
    //     } else {
    //       $page_id = 1;
    //     }

    //     $input_string = 'admin/Payment/pending?';
    //     $count_string = 0;
    //     foreach (Input::all() as $key => $value) {
    //       if($key != 'page'){
    //         $input_string .= ($count_string == 0)?'':'&';
    //         $input_string .= $key.'='.$value;
    //         $count_string++;
    //       }
    //     }
    //     $payments = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
    //     $courses = [""=>"Select"]+Course::lists('name','id');
    //     $status = Application::status();
    //     $this->layout->sidebar = View::make('admin.sidebar',["sidebar"=>'payment','subsidebar'=>2]);
    //     $this->layout->main = View::make('admin.payment.list',['flag'=>'2','courses'=>$courses,'status'=>$status,'payments'=>$payments,"title"=>'Payment Due List',"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string]);
    // }
    // public function approvePaymentStatus($id,$remarks,$count){
    //     $applicationId = Payment::select('application_id')->where('id',$id)->first();
    //     $paymentStatus = Payment::where('id',$id)->update(["status"=>1,'remarks'=>$remarks]);
    //     $applicationStatus = Application::where('id',$applicationId->application_id)->update(['status'=>3,'remarks'=>$remarks]);
    //     $payment = Payment::listing()->where('payment.id',$id)->first();
    //     $status = Application::status();
    //     $data['success']= 'true';
    //     $data['message'] = html_entity_decode(View::make('admin.payment.view',['status'=>$status,'data'=>$payment,"count"=>$count]));
    //     return json_encode($data);
    // }
    // public function disapprovePaymentStatus($id,$remarks,$count){
    //     $applicationId = Payment::select('application_id')->where('id',$id)->first();
    //     $paymentStatus = Payment::where('id',$id)->update(["status"=>0,'remarks'=>$remarks]);
    //     $applicationStatus = Application::where('id',$applicationId->application_id)->update(['status'=>2,'remarks'=>$remarks]);
    //     $payment = Payment::listing()->where('payment.id',$id)->first();
    //     $status = Application::status();
    //     $data['success']= 'true';
    //     $data['message'] = html_entity_decode(View::make('admin.payment.view',['status'=>$status,'data'=>$payment,"count"=>$count]));
    //     return json_encode($data);
    // }
    //admin panel function ends

    // user panel function  starts here
    public function Payment($application_id){
        $application = Application::select('courses.fees','applications.id')->join('courses','applications.course_id','=','courses.id')->where('applications.id',$application_id)->first();
        return View::make('coaches.applications.payment',["application"=>$application]);
    }

    public function putPayment($payment_id){
        $cre = ["payment_method"=>Input::get('payment_method'),"cheque_date"=>Input::get('cheque_date'),"cheque_no"=>Input::get('cheque_no'),"bank_name"=>Input::get('bank_name') , "amount" => Input::get('amount')];
        $rules = ["payment_method"=>'required',"cheque_date"=>'required',"cheque_no"=>'required',"bank_name"=>'required' , 'amount' => 'required | numeric'];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $payment = Payment::find($payment_id);
            $payment->payment_method = Input::get('payment_method');
            $payment->cheque_date = date("Y-m-d",strtotime(Input::get('cheque_date')));
            $payment->cheque_number = Input::get('cheque_no');
            $payment->bank_name = Input::get('bank_name');
            $payment->amount = Input::get('amount');
            $payment->remarks = Input::get('remarks');
            $payment->save();
            return Redirect::back()->with('success','Payment details are successfully updated.');
        }
        else{
            return Redirect::back()->withInput()->with('failure','Please fill all the fields');
        }
    }

    public function approvePaymentStatus($payment_id){
        $payment = Payment::find($payment_id);
        
        $payment->status = ($payment->status == 0)?1:0;
        $payment->save();

        if($payment->status == 1){

            $user = Payment::select('users.username')
                ->join('applications','payment.application_id','=','applications.id')
                ->join('users','users.coach_id','=','applications.coach_id')
                ->where('payment.id',$payment_id)
                ->first();
            $html = View::make('admin.payment.receipt',["payment" => $payment]);
            $pdf_path = 'coaches_doc/';
            include(app_path().'/dompdf/dompdf_config.inc.php');
            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            $pdf_name = $pdf_path.'Receipt_'.strtotime("now").'.pdf';  
            file_put_contents($pdf_name,$dompdf->output());

            require app_path().'/classes/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->isMail();
            $mail->setFrom('info@the-aiff.com', 'All India Football Federation');
            $mail->addAddress($user->username);
            // $mail->addAddress("chiragverma2207@gmail.com");

            $mail->isHTML(true);
            $mail->Subject = "Payment Approval - AIFF Official Registration System";
            $mail->Body = "Your payment has been approved please find the attached receipt";
            $mail->AddAttachment($pdf_name , 'Payment Receipt');
            $mail->send();
        }

        return Redirect::back();
    }
}


