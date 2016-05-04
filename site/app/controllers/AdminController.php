<?php

class AdminController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected $layout = 'layout';

    public function index(){
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'','subsidebar'=>1]);
        $this->layout->main = View::make('admin.index',[]);
    }
    
    public function approvedCoach(){
    	$coaches = Coach::listing()->approved()->get();
        $status = Coach::Status();
    	$this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>1]);
    	$this->layout->main = View::make('admin.coaches',['coaches'=>$coaches,"title"=>'Approved Coaches', "status" => $status]);
    }
    public function pendingCoach(){
    	$coaches = Coach::listing()->pending()->get();
        $status = Coach::Status();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>2]);
        $this->layout->main = View::make('admin.coaches',['coaches'=>$coaches,"title"=>'Pending for Approval', "status" => $status]);
    }
    public function inactiveCoach(){
    	$coaches = Coach::listing()->disapproved()->get();
        $status = Coach::Status();
    	$this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
    	$this->layout->main = View::make('admin.coaches',['coaches'=>$coaches,"title"=>'Inactive Coaches', "status" => $status]);
    }
    
    public function viewCoach($id){
        $coach = Coach::select('coaches.first_name','coaches.status','states.name as state_registation','coaches.middle_name','coaches.last_name','coaches.dob','coaches.gender','coaches.photo','coach_parameters.email','coach_parameters.address1','coach_parameters.address2','coach_parameters.city','coach_parameters.pincode','coach_parameters.mobile')->join('states','coaches.state_registration','=','states.id')->join('coach_parameters','coaches.id','=','coach_parameters.coach_id')->where('coaches.id',$id)->first();
        $employmentDetails = EmploymentDetails::where('coach_id',$id)->get();

        return View::make('admin.viewCoach',['coach'=>$coach,'employmentDetails'=>$employmentDetails]);
    }

    public function markCoachStatus($flag,$id){

        if($flag==1){
            Coach::where('id',$id)->update(['status'=>2]);
            $data['success']=true;
            $data['message']='Disapprove';

        }

        if($flag==2){
            Coach::where('id',$id)->update(['status'=>1]);
            $data['success']=true;
            $data['message']='Approve';

        }

        if($flag==3){
            Coach::where('id',$id)->update(['status'=>2]);
            User::where('coach_id',$id)->update(['active'=>0]);
            $data['success']=true;
            $data['message']='Approve';
        }
        if($flag==4){
            User::where('coach_id',$id)->update(['active'=>1]);
            Coach::where('id',$id)->update(['status'=>0]);
            $data['success']=true;
            $data['message']='Approve';
        }
        
        return json_encode($data);
   }

}


