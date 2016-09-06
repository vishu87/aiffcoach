<?php

class PaymentController extends BaseController {
    protected $layout = 'layout';
    // admin panel function  starts
    public function index(){
        if(Input::has('course')){
            $sql = Payment::listing()->where('applications.course_id',Input::get('course'));
        }
        else{
            $sql = Payment::listing();
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
        $courses = [""=>"Select"]+Course::lists('name','id');
        $status = Application::status();
        $this->layout->sidebar = View::make('admin.sidebar',["sidebar"=>'payment','subsidebar'=>1]);
        $this->layout->main = View::make('admin.payment.list',['courses'=>$courses,'status'=>$status,'payments'=>$payments,"title"=>'Payment Due List','flag'=>1,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string]);
    }
    public function pendingPayments(){
        if(Input::has('course')){
            $sql = Payment::listing()->pendingPayments()->where('applications.course_id',Input::get('course'));
        }
        else{
            $sql = Payment::listing()->pendingPayments();
        }
        
        $total = $sql->count();
        $max_per_page = 100;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
          $page_id = Input::get('page');
        } else {
          $page_id = 1;
        }

        $input_string = 'admin/Payment/pending?';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $input_string .= ($count_string == 0)?'':'&';
            $input_string .= $key.'='.$value;
            $count_string++;
          }
        }
        $payments = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $courses = [""=>"Select"]+Course::lists('name','id');
        $status = Application::status();
        $this->layout->sidebar = View::make('admin.sidebar',["sidebar"=>'payment','subsidebar'=>2]);
        $this->layout->main = View::make('admin.payment.list',['flag'=>'2','courses'=>$courses,'status'=>$status,'payments'=>$payments,"title"=>'Payment Due List',"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string]);
    }
    public function approvePaymentStatus($id,$remarks,$count){
        $applicationId = Payment::select('application_id')->where('id',$id)->first();
        $paymentStatus = Payment::where('id',$id)->update(["status"=>1,'remarks'=>$remarks]);
        $applicationStatus = Application::where('id',$applicationId->application_id)->update(['status'=>3,'remarks'=>$remarks]);
        $payment = Payment::listing()->where('payment.id',$id)->first();
        $status = Application::status();
        $data['success']= 'true';
        $data['message'] = html_entity_decode(View::make('admin.payment.view',['status'=>$status,'data'=>$payment,"count"=>$count]));
        return json_encode($data);
    }
    public function disapprovePaymentStatus($id,$remarks,$count){
        $applicationId = Payment::select('application_id')->where('id',$id)->first();
        $paymentStatus = Payment::where('id',$id)->update(["status"=>0,'remarks'=>$remarks]);
        $applicationStatus = Application::where('id',$applicationId->application_id)->update(['status'=>2,'remarks'=>$remarks]);
        $payment = Payment::listing()->where('payment.id',$id)->first();
        $status = Application::status();
        $data['success']= 'true';
        $data['message'] = html_entity_decode(View::make('admin.payment.view',['status'=>$status,'data'=>$payment,"count"=>$count]));
        return json_encode($data);
    }
    //admin panel function ends

    // user panel function  starts here
    public function Payment($application_id){
        $application = Application::select('courses.fees','applications.id')->join('courses','applications.course_id','=','courses.id')->where('applications.id',$application_id)->first();
        return View::make('coaches.applications.payment',["application"=>$application]);
    }
    public function paymentOption($application_id){
        $application = Application::select('courses.fees')->join('courses','applications.course_id','=','courses.id')->where('applications.id',$application_id)->first();
        $cre = ["payment_method"=>Input::get('payment_method'),"cheque_date"=>Input::get('cheque_date'),"cheque_no"=>Input::get('cheque_no'),"bank_name"=>Input::get('bank_name')];
        $rules = ["payment_method"=>'required',"cheque_date"=>'required',"cheque_no"=>'required',"bank_name"=>'required'];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $payment = new Payment;
            $payment->application_id = $application_id;
            $payment->payment_method = Input::get('payment_method');
            $payment->fees = $application->fees;
            $payment->cheque_date = Input::get('cheque_date');
            $payment->cheque_number = Input::get('cheque_no');
            $payment->bank_name = Input::get('bank_name');
            $payment->remarks = Input::get('remarks');
            $payment->save();
            $application = Application::find($application_id);
            $application->status = 2;
            $application->save();
            $data['success'] = 'true';
            $data['message'] ='Payment Completed Successfully';
        }
        else{
            $data['message'] = 'All Fields Are Not Field';
        }
        $applications =  Application::select('applications.status','applications.remarks','applications.id as application_id','courses.fees','courses.name as course_name','courses.end_date','license.id as license_id','license.name as license_name','license.authorised_by','license.description')->join('courses','applications.course_id','=','courses.id')->join('license','courses.license_id','=','license.id')->where('applications.id',$application_id)->first();
        $status = Application::status();
        $count = Input::get('count');
        $data['row'] = html_entity_decode(View::make('coaches.applications.view',['count'=>$count,'status'=>$status,"data"=>$applications,'title'=>'Applied Applications']));
        return json_encode($data); 
    }
    //user panel function ends
}


