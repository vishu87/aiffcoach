<?php

class CoursesParameterController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected $layout = 'layout';

    public function index(){
    	$licenses = License::licenseList();
        $parameters = Parameter::where('active',0)->lists('parameter','id');
    	$coursesParameter = CourseParameter::select('courses_parameter.id','parameters.parameter','license.name as license_name')->join('parameters','courses_parameter.parameter_id','=','parameters.id')->join('license','courses_parameter.license_id','=','license.id')->where('courses_parameter.active',0)->get();
    	$this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>3]);
    	$this->layout->main = View::make('resultAdmin.coursesParameter.list',['coursesParameter'=>$coursesParameter,'licenses'=>$licenses,'parameters'=>$parameters]);
    } 

    public function insert(){
        $cre = ['license_id'=>Input::get('license_id'),'parameter_id'=>Input::get('parameter_id')];
        $rules = ['license_id'=>'required','parameter_id'=>'required'];    
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $parameters_array = Input::get('parameter_id');
            for ($i=0; $i <sizeof($parameters_array) ; $i++) { 
                if($parameters_array[$i]!=0 || $parameters_array[$i]!=''){
                    $parameter = new CourseParameter;
                    $parameter->parameter_id = $parameters_array[$i];
                    $parameter->license_id = Input::get('license_id');
                    $parameter->save();
                }
            }
            
            return Redirect::back()->with('success','Parameter Added Successully .');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

    public function edit($id){
        $licenses = License::licenseList();
        $parameters = Parameter::where('active',0)->lists('parameter','id');
        $coursesParameter  = CourseParameter::select('courses_parameter.id','parameters.parameter','license.name as license_name')->join('parameters','courses_parameter.parameter_id','=','parameters.id')->join('license','courses_parameter.license_id','=','license.id')->where('courses_parameter.active',0)->get();

        $parameter = CourseParameter::find($id);
        $parameterArray = CourseParameter::where('license_id',$parameter->license_id)->get();
        $selectedParameters = array();
        foreach ($parameterArray as $value) {
            $selectedParameters[] = $value->parameter_id;
        }
        
        
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('resultAdmin.coursesParameter.list',['parameter'=>$parameter,'coursesParameter'=>$coursesParameter,'licenses'=>$licenses,'parameters'=>$parameters,'selectedParameters'=>$selectedParameters]);
    }

    
    
    public function update($id){
        $cre = ['license_id'=>Input::get('license_id'),'parameter_id'=>Input::get('parameter_id')];
        $rules = ['license_id'=>'required','parameter_id'=>'required'];   
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $parameter = CourseParameter::find($id);
            CourseParameter::where('license_id',$parameter->license_id)->delete();
            $parameters_array = Input::get('parameter_id');
            for ($i=0; $i <sizeof($parameters_array) ; $i++) { 
                if($parameters_array[$i]!=0 || $parameters_array[$i]!=''){
                    $parameter = new CourseParameter;
                    $parameter->parameter_id = $parameters_array[$i];
                    $parameter->license_id = Input::get('license_id');
                    $parameter->save();
                }
            }
            return Redirect::to('resultAdmin/coursesParameter')->with('success','Parameter Updated Successully .');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

   
    public function delete($id){
        CourseParameter::where('id',$id)->update(["active"=>1]);
        $data['success'] = true;
        $data['message'] ="Unit Deleted Successully";
        return json_encode($data);
    }

    public function exportExcel(){
        $licenseParameter = CourseParameter::select('courses_parameter.id','parameters.parameter','license.name as license_name')->join('parameters','courses_parameter.parameter_id','=','parameters.id')->join('license','courses_parameter.license_id','=','license.id')->where('courses_parameter.active',0)->get();
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/coach.php');
    }
}


