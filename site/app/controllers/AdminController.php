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
    	$coaches = User::select('coaches.id','coaches.first_name','coaches.status','coaches.middle_name','coaches.last_name','states.name as state_reference','coach_parameters.email','coach_parameters.mobile')->join('coaches','users.coach_id','=','coaches.id')->join('states','coaches.state_reference','=','states.id')->join('coach_parameters','users.coach_id','=','coach_parameters.coach_id')->where('coaches.status',2)->get();

    	$this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>1]);
    	$this->layout->main = View::make('admin.coaches',['coaches'=>$coaches,"title"=>'Approved Coach']);
    }
    public function pendingCoach(){
    	$coaches = User::select('coaches.id','coaches.first_name','coaches.status','coaches.middle_name','coaches.last_name','states.name as state_reference','coach_parameters.email','coach_parameters.mobile')->join('coaches','users.coach_id','=','coaches.id')->join('states','coaches.state_reference','=','states.id')->join('coach_parameters','users.coach_id','=','coach_parameters.coach_id')->where('coaches.status',1)->where('active',0)->get();

    	$this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>2]);
    	$this->layout->main = View::make('admin.coaches',['coaches'=>$coaches,"title"=>'Pending Coach']);
    }
    public function inactiveCoach(){
    	$coaches = User::select('coaches.id','coaches.first_name','coaches.status','coaches.middle_name','coaches.last_name','states.name as state_reference','coach_parameters.email','coach_parameters.mobile')->join('coaches','users.coach_id','=','coaches.id')->join('states','coaches.state_reference','=','states.id')->join('coach_parameters','users.coach_id','=','coach_parameters.coach_id')->where('active',1)->get();

    	$this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
    	$this->layout->main = View::make('admin.coaches',['coaches'=>$coaches,"title"=>'Inactive Coach']);
    }
    public function viewCoach($id){
        $coach = Coach::select('coaches.first_name','coaches.status','states.name as state_registation','coaches.middle_name','coaches.last_name','coaches.dob','coaches.gender','coaches.photo','coach_parameters.email','coach_parameters.address1','coach_parameters.address2','coach_parameters.city','coach_parameters.pincode','coach_parameters.mobile')->join('states','coaches.state_registration','=','states.id')->join('coach_parameters','coaches.id','=','coach_parameters.coach_id')->where('coaches.id',$id)->first();
        $employmentDetails = EmploymentDetails::where('coach_id',$id)->get();

        return View::make('admin.viewCoach',['coach'=>$coach,'employmentDetails'=>$employmentDetails]);
    }

   public function markCoachStatus($id){
        $coach = Coach::find($id);
        if($coach->status==1){
            Coach::where('id',$id)->update(['status'=>2]);
            $data['success']=true;
            $data['message']='Disapprove';

        }
        if($coach->status==2){
            Coach::where('id',$id)->update(['status'=>1]);
            $data['success']=true;
            $data['message']='Approve';

        }
        
        return json_encode($data);
   }

}


