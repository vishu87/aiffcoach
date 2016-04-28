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
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('coaches.activity.list',['activities'=>$activities]);
    }
    
    public function add(){
         $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('coaches.activity.add');
    }
    
    public function insert(){
        $cre = [
            'event'=>Input::get('event'),
            'to_date'=>Input::get('to_date'),
            'from_date'=>Input::get('from_date'),
            'place'=>Input::get('place'),
            'participants'=>Input::get('participants'),
            'position_role'=>Input::get('position_role')
            ];
        $rules = [
            'event'=>'required',
            'to_date'=>'required',
            'from_date'=>'required',
            'place'=>'required',
            'participants'=>'required',
            'position_role'=>'required'
            ];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $activity = new CoachActivity;
            $activity->event = Input::get('event');
            $activity->from_date = Input::get('from_date');
            $activity->to_date = Input::get('to_date');
            $activity->place = Input::get('place');
            $activity->position_role = Input::get('position_role');
            $activity->participants = Input::get('participants');
            $activity->coach_id = Auth::User()->coach_id;
            $activity->save();
            return Redirect::back()->with('success','New Activity Added Successfully');
        }
        
        return Redirect::back()->withErrors($validator)->withInput();

    }
    public function edit($id){
        $activity = CoachActivity::find($id);

        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('coaches.activity.add',['activity'=>$activity]);
        
    }
    public function update($id){
        $cre = [
            'event'=>Input::get('event'),
            'from_date'=>Input::get('from_date'),
            'to_date'=>Input::get('to_date'),
            'place'=>Input::get('place'),
            'participants'=>Input::get('participants'),
            'position_role'=>Input::get('position_role')
            ];
        $rules = [
            'event'=>'required',
            'from_date'=>'required|date',
            'to_date'=>'required|date|after:from_date',
            'place'=>'required',
            'participants'=>'required',
            'position_role'=>'required'
            ];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $activity = CoachActivity::find($id);
            $activity->event = Input::get('event');
            $activity->from_date = Input::get('from_date');
            $activity->to_date = Input::get('to_date');
            $activity->place = Input::get('place');
            $activity->position_role = Input::get('position_role');
            $activity->participants = Input::get('participants');
            $activity->coach_id = Auth::User()->coach_id;
            $activity->save();
            return Redirect::back()->with('success',' Activity Updated Successfully');
        }
        
        return Redirect::back()->withErrors($validator)->withInput();

    }
    public function delete($id){
        CoachActivity::find($id)->delete();
        $data["success"] = true;
        $data["message"] = "";
        return json_encode($data);
    }

   

}


