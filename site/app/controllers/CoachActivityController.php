<?php

class CoachActivityController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected $layout = 'layout';

    public function index(){
        $activities = CoachActivity::where('coach_id',Auth::User()->coach_id)->get();
        $activityStatus = Approval::status();
        $coach_roles = CoachActivity::coach_roles();
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('coaches.activity.list',['activities'=>$activities, "activityStatus"=>$activityStatus , "coach_roles" => $coach_roles]);
    }
    
    public function add(){
        $coach_roles = ["" => "Select"] + CoachActivity::coach_roles();
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('coaches.activity.add' ,["coach_roles" => $coach_roles]);
    }
    
    public function insert(){
        $cre = [
            'event'=>Input::get('event'),
            'start_date'=>Input::get('from_date'),
            'place'=>Input::get('place'),
            'position_role'=>Input::get('position_role')
            ];
        $rules = [
            'event'=>'required',
            'start_date'=>'required|date',
            'place'=>'required',
            'position_role'=>'required'
            ];  
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $activity = new CoachActivity;
            $activity->event = Input::get('event');
            $activity->from_date = date('Y-m-d',strtotime(Input::get('from_date')));
            $activity->to_date = date('Y-m-d',strtotime(Input::get('to_date')));
            $activity->place = Input::get('place');
            $activity->position_role = Input::get('position_role');
            if(Input::get('position_role') == 6){
                $activity->role_name = Input::get('role_name');
            }
            $activity->participants = Input::get('participants');
            $activity->coach_id = Auth::User()->coach_id;
            $activity->save();
            return Redirect::back()->with('success','New Activity Added Successfully');
        }
        
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');

    }
    public function edit($id){
        $activity = CoachActivity::where('coach_id',Auth::User()->coach_id)->find($id);
        $coach_roles = ["" => "Select"] + CoachActivity::coach_roles();

        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('coaches.activity.add',['activity'=>$activity , "coach_roles" => $coach_roles]);
        
    }
    public function update($id){
        $cre = [
            'event'=>Input::get('event'),
            'start_date'=>Input::get('from_date'),
            'place'=>Input::get('place'),
            'position_role'=>Input::get('position_role'),
            ];
        $rules = [
            'event'=>'required',
            'start_date'=>'required|date',
            'place'=>'required',
            'position_role'=>'required',
            ];   
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $activity = CoachActivity::find($id);
            $activity->event = Input::get('event');
            $activity->from_date = date('Y-m-d',strtotime(Input::get('from_date')));
            $activity->to_date = date('Y-m-d',strtotime(Input::get('to_date')));
            $activity->place = Input::get('place');
            $activity->position_role = Input::get('position_role');
            if(Input::get('position_role') == 6){
                $activity->role_name = Input::get('role_name');
            }else{
                $activity->role_name = '';
            }
            $activity->participants = Input::get('participants');
            $activity->coach_id = Auth::User()->coach_id;
            $activity->save();
            return Redirect::back()->with('success',' Activity Updated Successfully');
        }
        
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');

    }
    public function delete($id){
        $count = CoachActivity::where('id',$id)->count();
        if($count<1){
            $data['success'] = false;
            $data['message'] = 'This Item does not exist';
        }
        else{
        CoachActivity::find($id)->delete();
        $data["success"] = true;
        $data["message"] = "";
        }   
        return json_encode($data);
    }
}