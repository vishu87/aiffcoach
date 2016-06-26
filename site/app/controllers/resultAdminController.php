
<?php
class resultAdminController extends BaseController {
    protected $layout = 'layout';

    public function index(){
        $status = Application::status();
        $courses = ["" => "Select Course"] + Course::lists('name','id');
        if(Input::has('course')){
            $applications = Application::select('courses.name as course_name','courses.id as course_id','applications.id','applications.status','coaches.first_name','coaches.last_name','coaches.middle_name','license.name as license_name','application_result.status as finalResult','application_result.remarks')
                ->join('coaches','applications.coach_id','=','coaches.id')
                ->join('courses','applications.course_id','=','courses.id')
                ->leftJoin('license','courses.license_id','=','license.id')
                ->leftJoin('application_result','applications.id','=','application_result.application_id')
                ->where('applications.status',3)
                ->where('applications.course_id',Input::get('course'))
                ->get();
            $resultStatus = Result::status();
        } else {
            $applications = [];
            $resultStatus = Result::status();
            // $applications = Application::applications()->where('applications.status',3)->get();
        }
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>1]);
        $this->layout->main = View::make('resultAdmin.index',['status'=>$status,"applications"=>$applications,'title'=>'Applications Results','flag'=>1, "courses" => $courses,'resultStatus'=>$resultStatus]);
    }

    public function indexResult(){
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('resultAdmin.result.list');
    }
    
    public function view($id){ // here $id is application id
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
        $status = Result::status();
        $finalResult = ApplicationResult::where('application_id',$id)->first();
        return View::make('resultAdmin.result.view',["application_id"=>$id,'parameters'=>$parameters,"results"=>$results,'application_id'=>$id,'status'=>$status,"finalResult"=>$finalResult]);
    }

    public function update($id){ // here $id is application id
        Result::where('application_id',$id)->delete();
        foreach (Input::get('parameters') as $param) {
            if(Input::has('marks_'.$param)){
                $result = new Result;
                $result->application_id = $id;
                $result->parameter_id = $param;
                $result->marks = Input::get('marks_'.$param);
                $result->save(); 
            }
        }

        if (Input::has('status')) {
            $count = ApplicationResult::where('application_id',$id)->count();
            if ($count<1) {
                $applicationResult = ApplicationResult::insert(["application_id"=>$id,"status"=>Input::get('status'),"remarks"=>Input::get('remarks')]);
            }
            else{
                $applicationResult = ApplicationResult::where('application_id',$id)->update(["application_id"=>$id,"status"=>Input::get('status'),"remarks"=>Input::get('remarks')]);
            }
        }

        $app_data = Application::applicationsResult()
            ->where('applications.status',3)
            ->where('applications.id',$id)
            ->first();     
        $resultStatus = Result::status();    
        $data['success'] = true;
        $data['message']= html_entity_decode(View::make('resultAdmin.view',['data'=>$app_data,'count'=>Input::get('count'),'resultStatus'=>$resultStatus]));
        return json_encode($data);
    }

    public function exportExcel($course_id){
        $applicationsResult = Application::applicationsResult()
            ->where('applications.status',3)
            ->where('applications.course_id',$course_id)
            ->get();      
        $resultStatus = Result::status();        
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/coach.php');
    }
}