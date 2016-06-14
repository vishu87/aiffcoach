<?php

class ParameterController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected $layout = 'layout';

    public function index(){
    	
    	$coursesParameter = Parameter::where('parameters.active',0)->get();
    	$this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>2]);
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
            $parameter->save();
            return Redirect::back()->with('success','Parameter Added Successully .');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

    public function edit($id){
        $coursesParameter  = Parameter::where('active',0)->get();
        $parameter = Parameter::find($id);
        // return $coursesParameter;
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make('resultAdmin.Parameter.list',['parameter'=>$parameter,'coursesParameter'=>$coursesParameter]);
    }

    
    
    public function update($id){
        $cre = ['parameter'=>Input::get('parameter'),'max_marks'=>Input::get('max_marks')];
        $rules = ['parameter'=>'required','max_marks'=>'required'];    
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $check = Parameter::where('parameter',Input::get('parameter'))->where('id','!=',$id)->where('active','!=',1)->count();
            if($check>0){
                return Redirect::back()->with('failure','A Unit is Already Exits with this name');
            }
            $parameter = Parameter::find($id);
            $parameter->parameter = Input::get('parameter');
            $parameter->max_marks = Input::get('max_marks');
            $parameter->save();
            return Redirect::to('resultAdmin/Parameter')->with('success','Parameter Updated Successully .');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

   
    public function delete($id){
        Parameter::where('id',$id)->update(["active"=>1]);
        $data['success'] = true;
        $data['message'] ="Unit Deleted Successully";
        return json_encode($data);
    }
}


