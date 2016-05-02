<?php
class LicenseController extends BaseController {
    protected $layout = 'layout';

    public function index(){
        $licenses =  License::get();

        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'license','subsidebar'=>1]);
        $this->layout->main = View::make('admin.license.list',['licenses'=>$licenses]);
    }

    public function add(){
        $authority = License::Authority();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'license','subsidebar'=>1]);
        $this->layout->main = View::make('admin.license.add',['authority'=>$authority]);
    }

    public function insert(){
        $cre = ['name'=>Input::get('name'),'description'=>Input::get('description'),'authorised_by'=>Input::get('authorised_by')];
        $rules = ['name'=>'required','description'=>'required','authorised_by'=>'required'];

        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $license = new License;
            $license->name= Input::get('name');
            $license->description = Input::get('description');
            $license->authorised_by = Input::get('authorised_by');
            $license->save();
            return Redirect::back()->with('success','New License  Added!!');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

    public function edit($id){
        $license = License::find($id);
        $authority = License::Authority();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'license','subsidebar'=>1]);
        $this->layout->main = View::make('admin.license.add',['authority'=>$authority,'license'=>$license]);
    }

    public function update($id){
        $cre = ['name'=>Input::get('name'),'description'=>Input::get('description'),'authorised_by'=>Input::get('authorised_by')];
        $rules = ['name'=>'required','description'=>'required','authorised_by'=>'required'];

        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $license = License::find($id);
            $license->name= Input::get('name');
            $license->description = Input::get('description');
            $license->authorised_by = Input::get('authorised_by');
            $license->save();
            return Redirect::back()->with('success','License Updated Successfully!!');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

    public function delete($id){
        License::find($id)->delete();
        $data['success'] = true;
        $data['message'] = 'Item Deleted!';
        return json_encode($data);
    }
}