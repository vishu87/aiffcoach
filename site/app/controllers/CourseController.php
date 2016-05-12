<?php
class CourseController extends BaseController {
    protected $layout = 'layout';
    //*********methods for admin panel*********
    public function index(){
        $courses =  Course::select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')
            ->get();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'courses','subsidebar'=>1]);
        $this->layout->main = View::make('admin.courses.list',['courses'=>$courses,'title'=>'Courses']);
    }

    public function active(){
        $courses =  Course::Active();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'courses','subsidebar'=>2]);
        $this->layout->main = View::make('admin.courses.list',['courses'=>$courses,'title'=>'Active Courses']);
    }
    public function inactive(){
        $courses =  Course::Inactive();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'courses','subsidebar'=>3]);
        $this->layout->main = View::make('admin.courses.list',['courses'=>$courses,'title'=>'Inactive Courses']);
    }

    public function add(){
        $licenses = [''=>'Select']+License::lists('name','id');
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'courses','subsidebar'=>1]);
        $this->layout->main = View::make('admin.courses.add',['licenses'=>$licenses]);
    }

    public function insert(){
        $cre = [
            'name'=>Input::get('name'),
            'start_date'=>Input::get('start_date'),
            'end_date'=>Input::get('end_date'),
            'license_id'=>Input::get('license_id'),
            'fee'=>Input::get('fee'),
            ];
        $rules = [
            'name'=>'required',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
            'license_id'=>'required',
            'fee'=>'required'
            ];
        $validator = Validator::make($cre,$rules);

        if($validator->passes()){
            $course = new Course;
            $course->name= Input::get('name');
            $course->start_date = date('y-m-d',strtotime(Input::get('start_date')));
            $course->end_date = date('y-m-d',strtotime(Input::get('end_date')));
            $course->license_id = Input::get('license_id');
            $course->venue = Input::get('venue');
            $course->description = Input::get('description');
            $course->fees = Input::get('fee');

            $destinationPath = 'coaches-doc/';

            if(Input::hasFile('documents')){
                $extension = Input::file('documents')->getClientOriginalExtension();
                $doc = "Document_".Auth::id().'_'.str_replace(' ','-',Input::file('documents')->getClientOriginalName());
                
                Input::file('documents')->move($destinationPath,$doc);
                $course->documents = $destinationPath.$doc;
            }
            $course->save();
            return Redirect::Back()->with('success','New Course  Added!!');
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
    }

    public function edit($id){
        $course = Course::find($id);
        $licenses = [''=>'Select']+License::lists('name','id');
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'courses','subsidebar'=>1]);
        $this->layout->main = View::make('admin.courses.add',['licenses'=>$licenses,'course'=>$course]);
    }

    public function update($id){
        $cre = [
            'name'=>Input::get('name'),
            'start_date'=>Input::get('start_date'),
            'end_date'=>Input::get('end_date'),
            'license_id'=>Input::get('license_id'),
            'fee'=>Input::get('fee'),
            ];
        $rules = [
            'name'=>'required',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
            'license_id'=>'required',
            'fee'=>'required'
            ];
        $validator = Validator::make($cre,$rules);

        if($validator->passes()){
            $course = Course::find($id);
            $course->name= Input::get('name');
            $course->start_date = date('y-m-d',strtotime(Input::get('start_date')));
            $course->end_date = date('y-m-d',strtotime(Input::get('end_date')));
            $course->venue = Input::get('venue');
            $course->description = Input::get('description');
            $course->license_id = Input::get('license_id');
            $course->fees = Input::get('fee');

            $destinationPath = 'coaches-doc/';

            if(Input::hasFile('documents')){
                $extension = Input::file('documents')->getClientOriginalExtension();
                $doc = "Document_".Auth::id().'_'.str_replace(' ','-',Input::file('documents')->getClientOriginalName());
                
                Input::file('documents')->move($destinationPath,$doc);
                $course->documents = $destinationPath.$doc;
            }
            $course->save();
            return Redirect::Back()->with('success','Course Details Updated!!');
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
    }

    public function delete($id){
        Course::find($id)->delete();
        $data['success'] = true;
        $data['message'] = 'Item Deleted!';
        return json_encode($data);
    }


    /**********courses for coach panel*******/

    public function activeCourse(){
        $courses =  Course::Active();
        $check = [];
        foreach ($courses as $value) {
            $count = Application::where('coach_id',Auth::User()->coach_id)->where('course_id',$value->id)->count();

            if($count>=1){
                $check[] = $value->id;
            }
        }
        // return $check;
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>5,'subsidebar'=>1]);
        $this->layout->main = View::make('coaches.courses.list',['courses'=>$courses,'title'=>'Active Courses','check'=>$check]);
    }
    public function inactiveCourse(){
        $courses =  Course::Inactive();
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>5,'subsidebar'=>2]);
        $this->layout->main = View::make('coaches.courses.list',['courses'=>$courses,'title'=>'Inactive Courses','status'=>'inactive']);
    }
}