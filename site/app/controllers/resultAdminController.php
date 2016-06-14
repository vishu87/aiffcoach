
<?php
class resultAdminController extends BaseController {
    protected $layout = 'layout';

    public function index(){
        $status = Application::status();
        $courses = ["" => "Select Course"] + Course::lists('name','id');
        if(Input::has('course')){
            $applications = Application::applications()
                ->where('applications.status',3)
                ->where('applications.course_id',Input::get('course'))
                ->get();
        } else {
            $applications = [];
            // $applications = Application::applications()->where('applications.status',3)->get();
        }
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>1]);
        $this->layout->main = View::make('resultAdmin.index',['status'=>$status,"applications"=>$applications,'title'=>'Applications Results','flag'=>1, "courses" => $courses]);
    }

    public function indexResult(){
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('resultAdmin.result.list');
    }
    
    public function edit($id){ // here $id is application id
        $course = Application::select('license.id as license_id')->join('courses','applications.course_id','=','courses.id')->join('license','courses.license_id','=','license.id')->where('applications.id',$id)->first();

        $parameters = CourseParameter::select('parameters.parameter','parameters.max_marks','courses_parameter.parameter_id')
            ->join('parameters','courses_parameter.parameter_id','=','parameters.id')
            ->where('license_id',$course->license_id)
            ->where('courses_parameter.active',0)
            ->get();
        $results = Result::where('application_id',$id)->get();   
        return View::make('resultAdmin.result.list',['parameters'=>$parameters,'application_id'=>$id,"results"=>$results]);

    }


    public function editParameterMarks($id){
        $course = Application::select('license.id as license_id')->join('courses','applications.course_id','=','courses.id')->join('license','courses.license_id','=','license.id')->where('applications.id',$id)->first();
        $parameters = CourseParameter::select('parameters.parameter','parameters.max_marks','courses_parameter.parameter_id')
            ->join('parameters','courses_parameter.parameter_id','=','parameters.id')
            ->where('license_id',$course->license_id)
            ->where('courses_parameter.active',0)
            ->get();
        $results = Result::where('application_id',$id)->lists('marks','parameter_id');
        // return $results;
        return View::make('resultAdmin.result.view',["application_id"=>$id,'parameters'=>$parameters,"results"=>$results,'application_id'=>$id]);
    }

    public function update($id){ // here $id is application id
        Result::where('application_id',$id)->delete();
        // return Input::all();
        foreach (Input::get('parameters') as $param) {
            if(Input::has('marks_'.$param)){
                $result = new Result;
                $result->application_id = $id;
                $result->parameter_id = $param;
                $result->marks = Input::get('marks_'.$param);
                $result->save(); 
            }
        }
        $data['success'] = true;
        $data['message']= 'result updated !';
        return json_encode($data);
    }
}