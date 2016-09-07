<?php
class CourseController extends BaseController {
    protected $layout = 'layout';
    //*********methods for admin panel*********

    public function index(){
        $courses = Course::select('courses.*','license.name as license_name','license.authorised_by')
            ->join('license','courses.license_id','=','license.id')
            ->where('courses.user_type',Auth::user()->manage_official_type)
            ->get();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'courses','subsidebar'=>1]);
        $this->layout->main = View::make('admin.courses.list',['courses'=>$courses,'title'=>'Courses','flag'=>1]);
    }

    public function active(){
        $courses =  Course::Active()->where('courses.user_type',Auth::user()->manage_official_type)->get();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'courses','subsidebar'=>2]);
        $this->layout->main = View::make('admin.courses.list',['courses'=>$courses,'title'=>'Active Courses','flag'=>2]);
    }
    public function inactive(){
        $courses =  Course::Inactive()->where('courses.user_type',Auth::user()->manage_official_type)->get();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'courses','subsidebar'=>3]);
        $this->layout->main = View::make('admin.courses.list',['courses'=>$courses,'title'=>'Inactive Courses']);
    }

    public function add(){
        $licenses = [''=>'Select'] + License::where('user_type',Auth::user()->manage_official_type)->lists('name','id');

        $instructors = ['' => 'Select'] + User::where('privilege',3)->lists('name','id');

        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'courses','subsidebar'=>1]);
        $this->layout->main = View::make('admin.courses.add',['licenses' => $licenses, "instructors" => $instructors]);
    }

    public function insert(){
        $cre = [
            'name'=>Input::get('name'),
            'start_date'=>Input::get('start_date'),
            'end_date'=>Input::get('end_date'),
            'registration_start'=>Input::get('registration_start'),
            'registration_end'=>Input::get('registration_end'),
            'license_id'=>Input::get('license_id'),
            'fee'=>Input::get('fee'),
            
            ];
        $rules = [
            'name'=>'required',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
            'registration_start'=>'required|date',
            'registration_end'=>'required|date|after:registration_start',
            'license_id'=>'required',
            'fee'=>'required',
            ];
        $validator = Validator::make($cre,$rules);

        if($validator->passes()){
            $course = new Course;
            $course->name= Input::get('name');
            $course->start_date = date('y-m-d',strtotime(Input::get('start_date')));
            $course->end_date = date('y-m-d',strtotime(Input::get('end_date')));
            $course->registration_start = date('y-m-d',strtotime(Input::get('registration_start')));
            $course->registration_end = date('y-m-d',strtotime(Input::get('registration_end')));
            $course->license_id = Input::get('license_id');
            if(Input::has('prerequisite_id')){
                $course->prerequisite_id = implode(',',Input::get('prerequisite_id'));
            }
            $course->venue = Input::get('venue');
            $course->description = Input::get('description');
            $course->fees = Input::get('fee');
            $course->user_type = Auth::user()->manage_official_type;
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
            'registration_start'=>Input::get('registration_start'),
            'registration_end'=>Input::get('registration_end'),
            'license_id'=>Input::get('license_id'),
            'fee'=>Input::get('fee'),
            
            ];
        $rules = [
            'name'=>'required',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
            'registration_start'=>'required|date',
            'registration_end'=>'required|date|after:registration_start',
            'license_id'=>'required',
            'fee'=>'required',
            ];
        $validator = Validator::make($cre,$rules);

        if($validator->passes()){
            $course = Course::find($id);
            $course->name= Input::get('name');
            $course->start_date = date('y-m-d',strtotime(Input::get('start_date')));
            $course->end_date = date('y-m-d',strtotime(Input::get('end_date')));
            $course->registration_start = date('y-m-d',strtotime(Input::get('registration_start')));
            $course->registration_end = date('y-m-d',strtotime(Input::get('registration_end')));
            $course->venue = Input::get('venue');
            if(Input::has('prerequisite_id')){
                $course->prerequisite_id = implode(',',Input::get('prerequisite_id'));
            }
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
        $count = Course::where('id',$id)->count();
        if($count<1){
            $data['success'] = false;
            $data['message'] = "Can Not Delete Course";
        }
        else{
            Course::find($id)->delete();
            $data['success'] = true;
            $data['message'] = 'Item Deleted!';
        }
        
        return json_encode($data);
    }


    /**********courses for coach panel*******/

    public function activeCourse(){
        $courses =  Course::Active()->where('courses.user_type','LIKE','%'.Auth::user()->official_types.'%')->get();
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>5,'subsidebar'=>1]);
        $this->layout->main = View::make('coaches.courses.list',['courses'=>$courses,'title'=>'Active Courses']);
    }
    public function inactiveCourse(){
        $courses =  Course::Inactive()->where('courses.user_type','LIKE','%'.Auth::user()->official_types.'%')->get();
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>5,'subsidebar'=>2]);
        $this->layout->main = View::make('coaches.courses.list',['courses'=>$courses,'title'=>'Inactive Courses','status'=>'inactive']);
    }
}