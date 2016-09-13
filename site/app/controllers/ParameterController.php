<?php

class ParameterController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected $layout = 'layout';

    public function index(){
    	
    	$coursesParameter = Parameter::where('parameters.user_type',Auth::user()->manage_official_type)->get();
    	$this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>2]);
    	$this->layout->main = View::make('resultAdmin.Parameter.list',['coursesParameter'=>$coursesParameter]);
    } 

    public function insert(){
        $cre = ['parameter'=>Input::get('parameter'),'max_marks'=>Input::get('max_marks')];
        $rules = ['parameter'=>'required','max_marks'=>'required'];    
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $check = Parameter::where('parameter',Input::get('parameter'))->where('active','!=',1)->count();
            if($check>0){
                return Redirect::back()->with('failure','A Parameter is Already Exits with this name');
            }

            $parameter = new Parameter;
            $parameter->parameter = Input::get('parameter');
            $parameter->max_marks = Input::get('max_marks');
            $parameter->user_type = Auth::user()->manage_official_type;
            $parameter->save();
            return Redirect::back()->with('success','Parameter Added Successully .');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

    public function edit($id){
        $query = Parameter::where('id',$id)->where('user_type',Auth::user()->manage_official_type);
        $count = $query->count();
        if($count > 0){

            $coursesParameter  = $query->get();
            $parameter = Parameter::find($id);
            $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>2]);
            $this->layout->main = View::make('resultAdmin.Parameter.list',['parameter'=>$parameter,'coursesParameter'=>$coursesParameter]);
        }
        else{
            return Redirect::to('/admin/Parameter')->with('failure','Invalid parameter or parameter not exist');
        }
    }

    public function update($id){
        $query = Parameter::where('id',$id)->where('user_type',Auth::user()->manage_official_type);
        $count = $query->count();
        if($count > 0){
            $cre = ['parameter'=>Input::get('parameter'),'max_marks'=>Input::get('max_marks')];
            $rules = ['parameter'=>'required','max_marks'=>'required'];    
            $validator = Validator::make($cre,$rules);
            if($validator->passes()){
                $check = Parameter::where('parameter',Input::get('parameter'))->where('id','!=',$id)->count();
                if($check>0){
                    return Redirect::back()->with('failure','A parameter is Already Exits with this name');
                } else {
                    $parameter = Parameter::find($id);
                    $parameter->parameter = Input::get('parameter');
                    $parameter->max_marks = Input::get('max_marks');
                    $parameter->user_type = Auth::user()->manage_official_type;
                    $parameter->save();
                    return Redirect::to('admin/Parameter')->with('success','Parameter Updated Successully .');
                }
            } else {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            
        } else {
            return Redirect::back()->with('failure','Invalid parameter or parameter not exist');
        }
    }

   
    public function delete($id){
        $query = Parameter::where('id',$id)->where('user_type',Auth::user()->manage_official_type);
        $count = $query->count();
        if($count >0){
            $deleteParameter = $query->delete();
            $data['success'] = true;
            $data['message'] ="Unit Deleted Successully";
        }
        else{
            $data['success'] = false;
            $data['message'] ="Invalid request";
        }
        return json_encode($data);
    }

    public function exportExcel(){
        $parameters = Parameter::where('parameters.active',0)->get();
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/coach.php');
    }
}