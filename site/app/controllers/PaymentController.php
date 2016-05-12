<?php

class PaymentController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected $layout = 'layout';

    // admin panel function  starts
    public function index(){
        if(Input::has('course')){
            $payments = Payment::listing()->where('applications.course_id',Input::get('course'))->get();

        }
        else{
            $payments = Payment::listing()->get();

        }


        $courses = [""=>"Select"]+Course::lists('name','id');
        $status = Application::status();
        $this->layout->sidebar = View::make('admin.sidebar',["sidebar"=>'payment','subsidebar'=>1]);
        $this->layout->main = View::make('admin.payment.list',['courses'=>$courses,'status'=>$status,'payments'=>$payments,"title"=>'Payment Due List']);

    }

    public function pendingPayments(){
        if(Input::has('course')){
            $payments = Payment::listing()->pendingPayments()->where('applications.course_id',Input::get('course'))->get();

        }
        else{
            $payments = Payment::listing()->pendingPayments()->get();

        }


        $courses = [""=>"Select"]+Course::lists('name','id');
        $status = Application::status();
        $this->layout->sidebar = View::make('admin.sidebar',["sidebar"=>'payment','subsidebar'=>2]);
        $this->layout->main = View::make('admin.payment.list',['flag'=>'true','courses'=>$courses,'status'=>$status,'payments'=>$payments,"title"=>'Payment Due List']);
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
    public function Payment($id){
        $application = Application::select('courses.fees','applications.id')->join('courses','applications.course_id','=','courses.id')->where('applications.id',$id)->first();
        return View::make('coaches.applications.payment',["application"=>$application]);

    }

    public function paymentOption($id){

        $application = Application::select('courses.fees')->join('courses','applications.course_id','=','courses.id')->where('applications.id',$id)->first();

        $cre = ["payment_method"=>Input::get('payment_method')];
        $rules = ["payment_method"=>'required'];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            if(Input::get('payment_method')!=3){
                // return 'welcome';
                $cre_1 = ["cheque_date"=>Input::get('cheque_date'),"cheque_no"=>Input::get('cheque_no'),"bank_name"=>Input::get('bank_name')]; 
                $rules_1 = [
                    "cheque_date"=>'required',
                    "cheque_no"=>'required',
                    "bank_name"=>'required'
                    ]; 
                $validator1 = Validator::make($cre_1,$rules_1);
                if($validator1->passes()){
                    $payment = new Payment;
                    $payment->application_id = $id;
                    $payment->payment_method = Input::get('payment_method');
                    $payment->fees = $application->fees;
                    $payment->cheque_date = Input::get('cheque_date');
                    $payment->cheque_number = Input::get('cheque_no');
                    $payment->bank_name = Input::get('bank_name');
                    $payment->remarks = Input::get('remarks');
                    $payment->save();

                    $application = Application::find($id);
                    $application->status = 2;
                    $application->save();
                    $data['success'] = 'true';
                    $data['message'] ='Payment Completed Successfully';
                    

                }
                else{
                    $data['message'] = 'All Fields Are Not Field';
                }
                    

            }
            else{
                    $payment = new Payment;
                    $payment->application_id = $id;
                    $payment->remarks = Input::get('remarks');
                    $payment->payment_method = Input::get('payment_method');
                    $payment->fees = $application->fees;
                    $payment->save();


                    $application = Application::find($id);
                    $application->status = 2;
                    $application->save();

                    $data['success'] = 'true';
                    $data['message'] = 'Payment Completed Successfully';  
            }
        }
        else{
            $data['message'] = 'All Fields Are Not Field';
        }
        $applications =  Application::select('applications.status','applications.remarks','applications.id as application_id','courses.fees','courses.name as course_name','courses.end_date','license.id as license_id','license.name as license_name','license.authorised_by','license.description')->join('courses','applications.course_id','=','courses.id')->join('license','courses.license_id','=','license.id')->where('applications.id',$id)->first();
        $status = Application::status();
        $count = Input::get('count');
        $data['row'] = html_entity_decode(View::make('coaches.applications.view',['count'=>$count,'status'=>$status,"data"=>$applications,'title'=>'Applied Applications']));
        return json_encode($data);
          
        
    }



    //user panel function ends

}


