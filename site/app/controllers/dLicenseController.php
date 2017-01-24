<?php
class dLicenseController extends BaseController {
    protected $layout = 'layout';

    public function index(){
        $licenses = DCourse::get();
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make('resultAdmin.d-license.list',["licenses" => $licenses]);
    }

    public function add(){
        $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make('resultAdmin.d-license.add',[]);
    }

    public function addLicense(){
        
        $cre = [
            "course_name" => Input::get('course_name'),
            "start_date" => Input::get('start_date'),
            "end_date" => Input::get('end_date'),
            "venue" => Input::get('venue'),
            "description" => Input::get('description')
            ];
        $rules = [
            "course_name" => "required",
            "start_date" => "required | date",
            "end_date" => "required | date | after:start_date",
            "venue" => "required", 
            "description" => "required"
        ]; 
        $validator = Validator::make($cre , $rules);
        if($validator->passes()){
            $course = new DCourse;
            $course->course_name = Input::get('course_name');
            $course->venue = Input::get('venue');
            $course->description = Input::get('description');
            $course->start_date = date('Y-m-d',strtotime(Input::get('start_date')));
            $course->end_date = date('Y-m-d',strtotime(Input::get('end_date')));
            $course->save();

            for ($i=1; $i <=25 ; $i++) { 
                if(Input::has('applicant_name_'.$i)){

                    $license = new DLicense;
                    $license->d_course_id = $course->id;
                    $license->applicant_name = Input::get('applicant_name_'.$i);

                    if(Input::has('issue_date_'.$i))
                    $license->license_issue_date = date('Y-m-d',strtotime(Input::get('issue_date_'.$i)));
                    $license->license_number = Input::get('license_number_'.$i);
                    $license->remarks = Input::get('remarks_'.$i);
                    $license->save();
                }
            }
            return Redirect::back()->with('success','D license for listed applicants added successfully !');

        }else{
            return Redirect::back()->withErrors($validator)->withInput();
        }   
        
    }

}