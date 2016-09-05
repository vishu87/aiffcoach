
<?php
class SuperAdminController extends BaseController {
    protected $layout = 'layout';

    public function dashboard(){
        $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>1]);
        $this->layout->main = View::make('superAdmin.dashboard',[]);
    }
    public function manage_logins(){
        $users = User::whereIn('privilege',array(2,3))->orderBy('id','asc')->get();
        $UserTypes = User::UserTypes();
        $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make("superAdmin.users.manage_users",["users"=>$users,'UserTypes'=>$UserTypes]);
    }

    public function addUser(){
        $UserTypes =[""=>"select"] + User::UserTypes();
        if (($key = array_search('Coach', $UserTypes)) !== false) {
            unset($UserTypes[$key]);
        }
        $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make("superAdmin.users.add",['UserTypes'=>$UserTypes]);
    }

    public function storeUser(){
        $cre = ["name"=>Input::get('name'),"email"=>Input::get('email'),"user_type"=>Input::get('user_type')];
        $rules = ["name"=>"required",'email'=>'required|unique:users,username','user_type'=>'required'];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $password = str_random(8);
            $user = new User;
            $user->name = Input::get('name');
            $user->username = Input::get('email');
            $user->password = Hash::make($password);
            $user->password_check = $password;
            $user->mobile = Input::get('mobile');
            $user->privilege = Input::get('user_type');
            $user->save();

            return Redirect::back()->with('success','New user added successfully');
        }
        else{
            return Redirect::back()->withErrors($validator)->withInput()->with('failure','All fields are not field');
        }
        
    }

    public function editUser($user_id){
        $user = User::find($user_id);
        $UserTypes =[""=>"select"] + User::UserTypes();
        if (($key = array_search('Coach', $UserTypes)) !== false) {
            unset($UserTypes[$key]);
        }
        $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make("superAdmin.users.add",['user'=>$user,'UserTypes'=>$UserTypes]);
    }

    public function updateUser($user_id){
        $cre = ["name"=>Input::get('name'),"email"=>Input::get('email'),"user_type"=>Input::get('user_type')];
        $rules = ["name"=>"required",'email'=>'required|unique:users,username,'.$user_id,'user_type'=>'required'];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $user = User::find($user_id);
            $user->name = Input::get('name');
            $user->username = Input::get('email');
            $user->mobile = Input::get('mobile');
            $user->privilege = Input::get('user_type');
            $user->save();

            return Redirect::back()->with('success','User updated successfully');
        }
        else{
            return Redirect::back()->withErrors($validator)->withInput()->with('failure','All fields are not field');
        }
        
    }

    public function deleteUser($user_id=0){
        User::find($user_id)->delete();
        $data["success"] = true;
        $data["message"] =  '';
        return json_encode($data);
    }
    
}