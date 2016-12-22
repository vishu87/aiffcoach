<?php
class LicenseController extends BaseController {
    protected $layout = 'layout';

    public function index(){
        $licenses =  License::where('user_type',Auth::user()->manage_official_type)->get();

        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'license','subsidebar'=>1]);
        $this->layout->main = View::make('admin.license.list',['licenses'=>$licenses]);
    }

    public function add(){
        $authority = License::Authority();
        $licenses = License::licenseList();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'license','subsidebar'=>1]);
        $this->layout->main = View::make('admin.license.add',['authority'=>$authority , "licenses" => $licenses]);
    }

    public function insert(){
        $cre = ['name'=>Input::get('name'),'description'=>Input::get('description'),'authorised_by'=>Input::get('authorised_by')];
        $rules = ['name'=>'required','description'=>'required','authorised_by'=>'required'];

        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $license = new License;
            $license->name= Input::get('name');
            $license->description = Input::get('description');
            if(Input::has('prerequisite_id')){
                $license->prerequisite_id = implode(',',Input::get('prerequisite_id'));
            }
            $license->authorised_by = Input::get('authorised_by');
            $license->user_type = Auth::user()->manage_official_type;
            $license->save();
            return Redirect::back()->with('success','New License  Added!!');
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
    }

    public function edit($id){
        $license = License::find($id);
        $selectedPrerequisites = explode(',',$license->prerequisite_id);
        $authority = License::Authority();
        $licenses = License::licenseList();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'license','subsidebar'=>1]);
        $this->layout->main = View::make('admin.license.add',['authority'=>$authority,'license'=>$license , "licenses" => $licenses ,"selectedPrerequisites" => $selectedPrerequisites]);
    }

    public function update($id){
        $cre = ['name'=>Input::get('name'),'description'=>Input::get('description'),'authorised_by'=>Input::get('authorised_by')];
        $rules = ['name'=>'required','description'=>'required','authorised_by'=>'required'];

        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $license = License::find($id);
            $license->name= Input::get('name');
            $license->description = Input::get('description');
            if(Input::has('prerequisite_id')){
                $license->prerequisite_id = implode(',',Input::get('prerequisite_id'));
            }
            $license->authorised_by = Input::get('authorised_by');
            $license->save();
            return Redirect::back()->with('success','License Updated Successfully!!');
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
    }

    public function delete($id){
        License::find($id)->delete();
        $data['success'] = true;
        $data['message'] = 'Item Deleted!';
        return json_encode($data);
    }
}