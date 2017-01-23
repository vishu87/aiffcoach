<?php

class CoursesParameterController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected $layout = 'layout';

    public function index(){
        $addedLicenses = CourseParameter::select('license_id')->groupBy('license_id')->get();
        $licenseArr = [];
        if(sizeof($addedLicenses) > 0){

            foreach ($addedLicenses as $license) {
                array_push($licenseArr,$license->license_id);
            }
        }

    	$licenses =[""=>"Select"] + License::where('user_type',Auth::user()->manage_official_type)->whereNotIn('id',$licenseArr)->lists('name','id');

        $parameters = Parameter::where('active',0)->get();
    	$coursesParameter = CourseParameter::select('courses_parameter.id','parameters.parameter','license.name as license_name','courses_parameter.license_id','courses_parameter.parameter_id')->leftJoin('parameters','courses_parameter.parameter_id','=','parameters.id')->leftJoin('license','courses_parameter.license_id','=','license.id')->where('courses_parameter.active',0)->orderBy('courses_parameter.license_id','asc')->get();
        $parameter = [];
        if(sizeof($coursesParameter)>0){
            foreach ($coursesParameter as $courseParameter) {
               if(!isset($parameter[$courseParameter->license_id]))$parameter[$courseParameter->license_id]=array();
               
               array_push($parameter[$courseParameter->license_id],$courseParameter->parameter);
               $parameter_string[$courseParameter->license_id] = implode(',',$parameter[$courseParameter->license_id]);
            }
        } else{
            $parameter_string = [];   
        }

    	$this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>3]);
    	$this->layout->main = View::make('resultAdmin.coursesParameter.list',['coursesParameter'=>$coursesParameter,'licenses'=>$licenses,'parameters'=>$parameters,"parameter_string"=>$parameter_string]);
    } 

    public function insert(){
        $cre = ['license_id'=>Input::get('license_id'),'parameter_id'=>Input::get('parameter_id')];
        $rules = ['license_id'=>'required','parameter_id'=>'required'];    
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $parameters_array = Input::get('parameter_id');
            foreach ($parameters_array as $param) {
                $parameter = new CourseParameter;
                $parameter->parameter_id = $param;
                $parameter->license_id = Input::get('license_id');
                $parameter->save();
            }
            
            return Redirect::back()->with('success','Parameter Added Successully .');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

    public function edit($id){
        $licenses = [""=>"Select"] + License::where('user_type',Auth::user()->manage_official_type)->lists('name','id');
        $parameters = Parameter::where('active',0)->get();
        $coursesParameter  = CourseParameter::select('courses_parameter.id','parameters.parameter','license.name as license_name','courses_parameter.license_id')->leftJoin('parameters','courses_parameter.parameter_id','=','parameters.id')->leftJoin('license','courses_parameter.license_id','=','license.id')->where('courses_parameter.active',0)->orderBy('courses_parameter.license_id','asc')->get();

        $parameter = CourseParameter::find($id);
        $parameterArray = CourseParameter::where('license_id',$parameter->license_id)->where('active',0)->get();
        $selectedParameters = array();
        foreach ($parameterArray as $value) {
            $selectedParameters[] = $value->parameter_id;
        }
        
        $licenseParameter = [];
        foreach ($coursesParameter as $courseParameter) {
           if(!isset($licenseParameter[$courseParameter->license_id]))$licenseParameter[$courseParameter->license_id]=array();
           
           array_push($licenseParameter[$courseParameter->license_id],$courseParameter->parameter);
           $parameter_string[$courseParameter->license_id] = implode(',',$licenseParameter[$courseParameter->license_id]);
            
        }
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('resultAdmin.coursesParameter.list',['parameter'=>$parameter,'coursesParameter'=>$coursesParameter,'licenses'=>$licenses,'parameters'=>$parameters,'selectedParameters'=>$selectedParameters,"parameter_string"=>$parameter_string]);
    }

    public function update($id){
        $cre = ['license_id'=>Input::get('license_id'),'parameter_id'=>Input::get('parameter_id')];
        $rules = ['license_id'=>'required','parameter_id'=>'required'];   
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $parameter = CourseParameter::find($id);
            CourseParameter::where('license_id',Input::get('license_id'))->delete();
            $parameters_array = Input::get('parameter_id');
            foreach ($parameters_array as $param) {
                $parameter = new CourseParameter;
                $parameter->parameter_id = $param;
                $parameter->license_id = Input::get('license_id');
                $parameter->save();
            }
            
            return Redirect::to('admin/coursesParameter')->with('success','Parameter Updated Successully .');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

   
    public function delete($id){
        $count = CourseParameter::where('id',$id)->count();
        if($count<1){
            $data['success'] = false;
            $data['message'] = "Can Not Delete Course";
        }
        CourseParameter::where('id',$id)->update(["active"=>1]);
        $data['success'] = true;
        $data['message'] ="Unit Deleted Successully";
        return json_encode($data);
    }

    public function exportExcel(){
        $licenseParameter = CourseParameter::select('courses_parameter.id','parameters.parameter','license.name as license_name')->leftJoin('parameters','courses_parameter.parameter_id','=','parameters.id')->leftJoin('license','courses_parameter.license_id','=','license.id')->where('courses_parameter.active',0)->get();
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/coach.php');
    }
}


