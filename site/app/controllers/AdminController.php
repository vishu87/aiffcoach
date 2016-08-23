<?php

class AdminController extends BaseController {
    protected $layout = 'layout';
    public function index(){
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'dashboard','subsidebar'=>1]);
        $this->layout->main = View::make('admin.index',[]);
    }
    public function approvedCoach(){
    	$sql = Coach::listing()->approved();
        $total = $sql->count();
        $max_per_page = 25;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
            $page_id = Input::get('page');
        } else {
            $page_id = 1;
        }
        $coaches = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $status = Coach::Status();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>1]);
    	$this->layout->main = View::make('admin.coaches.list',['coaches'=>$coaches,"title"=>'Approved Coaches', "status" => $status,'flag'=>1,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'url_link'=>'admin/approvedCoach?page=']);
    }
    public function pendingCoach(){
    	$sql = Coach::listing()->pending();
        $total = $sql->count();
        $max_per_page = 5;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
            $page_id = Input::get('page');
        } else {
            $page_id = 1;
        }
        $coaches = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $status = Coach::Status();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>2]);
        $this->layout->main = View::make('admin.coaches.list',['coaches'=>$coaches,"title"=>'Pending for Approval', "status" => $status,'flag'=>2,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'url_link'=>'admin/pendingCoach?page=']);
    }
    public function inactiveCoach(){
    	$coaches = Coach::listing()->disapproved()->get();
        $status = Coach::Status();
    	$this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
    	$this->layout->main = View::make('admin.coaches.list',['coaches'=>$coaches,"title"=>'Inactive Coaches', "status" => $status]);
    }
    public function allCoach(){
        $sql = Coach::listing();
        $total = $sql->count();
        $max_per_page = 25;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
            $page_id = Input::get('page');
        } else {
            $page_id = 1;
        }
        $coaches = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $status = Coach::Status();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
        $this->layout->main = View::make('admin.coaches.list',['coaches'=>$coaches,"title"=>'All Coaches', "status" => $status,'flag'=>3,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'url_link'=>'admin/all?page=']);
    }
    public function viewCoach($id){
        $coach = Coach::select('coaches.first_name','coaches.status','states.name as state_registation','coaches.middle_name','coaches.last_name','coaches.dob','coaches.gender','coaches.photo','coach_parameters.email','coach_parameters.address1','coach_parameters.address2','coach_parameters.city','coach_parameters.pincode','coach_parameters.mobile')->join('states','coaches.state_registration','=','states.id')->join('coach_parameters','coaches.id','=','coach_parameters.coach_id')->where('coaches.id',$id)->first();
        $employmentDetails = EmploymentDetails::where('coach_id',$id)->get();
        return View::make('admin.coaches.view',['coach'=>$coach,'employmentDetails'=>$employmentDetails]);
    }
    public function viewCoachDetails($id){
        $coach = Coach::select('coaches.first_name','coaches.status','states.name as state_registation','coaches.middle_name','coaches.last_name','coaches.dob','coaches.gender','coaches.photo','coach_parameters.email','coach_parameters.address1','coach_parameters.address2','coach_parameters.city','coach_parameters.pincode','coach_parameters.mobile')->join('states','coaches.state_registration','=','states.id')->join('coach_parameters','coaches.id','=','coach_parameters.coach_id')->where('coaches.id',$id)->first();
        $employmentDetails = EmploymentDetails::where('coach_id',$id)->get();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
        $this->layout->main = View::make('admin.coaches.view',['coach'=>$coach,'employmentDetails'=>$employmentDetails]);
    }
    public function markCoachStatus($flag,$id,$remarks,$count){
        $approval = new Approval;
        $approval->entity_type = 1;
        $approval->entity_id = $id;
        if($flag==1){
            Coach::where('id',$id)->update(['status'=>2]);
            $coaches = Coach::listing()->approved()->where('coaches.id',$id)->first();
            $data['success']=true;
            $approval->status = 2;
        }
        if($flag==2){
            Coach::where('id',$id)->update(['status'=>3]);
            $coaches = Coach::listing()->disapproved()->where('coaches.id',$id)->first();
            $data['success']=true;
            $approval->status = 3;
        }
        if($flag==3){
            Coach::where('id',$id)->update(['status'=>2]);
            $coaches = Coach::listing()->approved()->where('coaches.id',$id)->first();
            User::where('coach_id',$id)->update(['active'=>0]);
            $data['success']=true;
            $approval->status = 2;
        }
        if($flag==4){
            User::where('coach_id',$id)->update(['active'=>1]);
            $coaches = Coach::listing()->pending()->where('coaches.id',$id)->first();
            Coach::where('id',$id)->update(['status'=>0]);
            $data['success']=true;
            $approval->status = 0;
        }
        $status = Coach::Status(); 
        $data['message'] =html_entity_decode(View::make('admin.coaches.view',['count'=>$count,'data'=>$coaches,"title"=>'Coaches', "status" => $status]));
        $approval->user_id = Auth::User()->id;
        $approval->remarks = $remarks;
        $approval->save();
        return json_encode($data);
   }

}


