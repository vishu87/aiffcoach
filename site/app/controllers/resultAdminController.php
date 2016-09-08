
<?php
class resultAdminController extends BaseController {
    protected $layout = 'layout';

    public function dashboard(){
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>11]);
        $this->layout->main = View::make('resultAdmin.dashboard',[]);
    }
    public function index(){
        $instructorCourseId = CourseResultAdmin::select('course_id')->where('result_admin_id',Auth::user()->id)->get();
        $courseIdArray = [];
        foreach ($instructorCourseId as $key => $value) {
            $courseIdArray[$key] = $value->course_id;
        }
        $status = Application::status();
        $courses = ["" => "Select Course"] + Course::whereIn('id',$courseIdArray)->lists('name','id');

        if(Input::has('course')){
            $applications = Application::select('courses.name as course_name','courses.id as course_id','applications.id','applications.status','coaches.full_name','license.name as license_name','application_result.status as finalResult','application_result.remarks')
                ->join('coaches','applications.coach_id','=','coaches.id')
                ->leftJoin('courses','applications.course_id','=','courses.id')
                ->leftJoin('license','courses.license_id','=','license.id')
                ->leftJoin('application_result','applications.id','=','application_result.application_id')
                ->where('applications.status',3)
                ->where('applications.course_id',Input::get('course'))
                ->get();
            $resultStatus = Result::status();
        }else{
            $applications = Application::select('courses.name as course_name','courses.id as course_id','applications.id','applications.status','coaches.full_name','license.name as license_name','application_result.status as finalResult','application_result.remarks')
                ->join('coaches','applications.coach_id','=','coaches.id')
                ->join('courses','applications.course_id','=','courses.id')
                ->leftJoin('license','courses.license_id','=','license.id')
                ->leftJoin('application_result','applications.id','=','application_result.application_id')
                ->where('applications.status',3)
                ->whereIn('applications.course_id',$courseIdArray)
                ->get();
            $resultStatus = Result::status();
            // $applications = Application::applications()->where('applications.status',3)->get();
        }
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>1]);
        $this->layout->main = View::make('resultAdmin.applications.index',['status'=>$status,"applications"=>$applications,'title'=>'Applications Results','flag'=>1, "courses" => $courses,'resultStatus'=>$resultStatus]);
    }

    public function indexResult(){
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>3]);
        $this->layout->main = View::make('resultAdmin.result.list');
    }
    
    public function view($id){ // here $id is application id
        $checkApp = ApplicationResult::where('application_id',$id)->count();
        if ($checkApp>0) {
            $course = Application::select('license.id as license_id')->join('courses','applications.course_id','=','courses.id')->join('license','courses.license_id','=','license.id')->where('applications.id',$id)->first();
            $parameters = CourseParameter::select('parameters.parameter','parameters.max_marks','courses_parameter.parameter_id')
                ->join('parameters','courses_parameter.parameter_id','=','parameters.id')
                ->where('license_id',$course->license_id)
                ->where('courses_parameter.active',0)
                ->get();
            $resultStatus = Result::status();
            $results = Result::where('application_id',$id)->get();
            $applicationStatus = ApplicationResult::where('application_id',$id)->first();
            return View::make('resultAdmin.result.list',['parameters'=>$parameters,'application_id'=>$id,"results"=>$results,"applicationStatus"=>$applicationStatus,"resultStatus"=>$resultStatus]);
        }
        else{
            return "Result for this application is pending / Result Not found";
        }    
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
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>1]);
        $this->layout->main = View::make('resultAdmin.result.view',["application_id"=>$id,'parameters'=>$parameters,"results"=>$results,'application_id'=>$id,'status'=>$status,"finalResult"=>$finalResult]);
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
        $sql_data = array();
        $destinationPath = 'marksFiles/';
        if(Input::hasFile('upload_marks')){
            $extension = Input::file('upload_marks')->getClientOriginalExtension();
            $doc = "upload_marks_".str_replace(' ','-',Input::file('upload_marks')->getClientOriginalName());
            Input::file('upload_marks')->move($destinationPath,$doc);
            $upload_address = $destinationPath.$doc;
            $sql_data = $sql_data + ["upload_marks"=>$upload_address];
        }
        if (Input::has('status')) {
            $count = ApplicationResult::where('application_id',$id)->count();
            if ($count<1) {
                $sql_data = $sql_data + ["application_id"=>$id,"status"=>Input::get('status'),"remarks"=>Input::get('remarks')];
                $applicationResult = ApplicationResult::insert($sql_data);
            }
            else{
                $sql_data = $sql_data + ["application_id"=>$id,"status"=>Input::get('status'),"remarks"=>Input::get('remarks')];
                $applicationResult = ApplicationResult::where('application_id',$id)->update($sql_data);
            }
        }
        $app_data = Application::applicationsResult()
            ->where('applications.status',3)
            ->where('applications.id',$id)
            ->first();     
        $resultStatus = Result::status();    
        // $data['success'] = true;
        // $data['message']= html_entity_decode(View::make('resultAdmin.view',['data'=>$app_data,'count'=>Input::get('count'),'resultStatus'=>$resultStatus]));
        return Redirect::Back()->with('success','Marks Updated Successfully');
    }

    public function exportExcel(){

        $sql = Application::applicationsResult()->where('applications.status',3);
        if(Input::has('course')){
            $sql = $sql->where('applications.course_id',Input::get('course'));
        }
        $applicationsResult = $sql->get();
        if(sizeof($applicationsResult)>0){
            $resultStatus = Result::status();        
            include(app_path().'/libraries/Classes/PHPExcel.php');
            include(app_path().'/libraries/export/coach.php');
        } 
        else{
            return Redirect::back()->with('failure','No Application found to export');
        }  
        
    }

    public function uploadMarks(){
        $input = Input::all();
        $rules = array(
            'file' => 'image|max:3000',
        );
        $validation = Validator::make($input, $rules);
        if ($validation->fails())
        {
            return Response::make($validation->errors->first(), 400);
        }
        $file = Input::file('file');
        $extension = File::extension($file['name']);
        $directory = 'coaches-doc/'.sha1(time());
        $filename = sha1(time().time()).".{$extension}";
        $upload_success = Input::upload('file', $directory, $filename);
        return $upload_success;
    }
}