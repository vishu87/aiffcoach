
<?php
class SuperAdminController extends BaseController {
    protected $layout = 'layout';

    public function dashboard(){
        $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>1]);
        $this->layout->main = View::make('superAdmin.dashboard',[]);
    }
    public function manage_logins(){
        $sql = User::whereIn('privilege',array(1,2,3))->orderBy('id','asc');

        $total = $sql->count();
        $max_per_page = 1000;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
          $page_id = Input::get('page');
        } else {
          $page_id = 1;
        }

        $input_string = 'superAdmin/manage_logins?';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
              $input_string .= ($count_string == 0)?'':'&';
              $input_string .= $key.'='.$value;
              $count_string++;
          }
        }
        $users = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $officialTypes = User::OfficialTypes();
        $UserTypes = User::UserTypes();
        $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make("superAdmin.users.manage_users",["users"=>$users,"officialTypes"=>$officialTypes,'UserTypes'=>$UserTypes,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string]);
    }

    // $sql = Coach::listing()->approved()->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%');

    //   if(Input::get("registration_id") != ''){
    //       $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
    //   }
    //   if(Input::get("official_name") != ''){
    //       $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
    //   }

    //   $total = $sql->count();
    //   $max_per_page = 100;
    //   $total_pages = ceil($total/$max_per_page);
    //   if(Input::has('page')){
    //       $page_id = Input::get('page');
    //   } else {
    //       $page_id = 1;
    //   }

    //   $input_string = 'admin/approvedCoach?';
    //   $count_string = 0;
    //   foreach (Input::all() as $key => $value) {
    //       if($key != 'page'){
    //           $input_string .= ($count_string == 0)?'':'&';
    //           $input_string .= $key.'='.$value;
    //           $count_string++;
    //       }
    //   }

    //   $coaches = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
    //   $status = Coach::Status();

    //   $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>1]);
    //   $this->layout->main = View::make('admin.coaches.list',['coaches'=>$coaches,"title"=>'Approved Officials', "status" => $status,'flag'=>1,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string]);


    public function addUser(){
        $UserTypes =[""=>"select"] + User::UserTypes();
        $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make("superAdmin.users.add",['UserTypes'=>$UserTypes]);
    }

    public function storeUser(){
        $cre = ["name"=>Input::get('name'),"email"=>Input::get('email'),"user_type"=>Input::get('user_type')];
        $rules = ["name"=>"required",'email'=>'required|email|unique:users,username','user_type'=>'required'];
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
        $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make("superAdmin.users.add",['user'=>$user,'UserTypes'=>$UserTypes]);
    }

    public function updateUser($user_id){
        $cre = ["name"=>Input::get('name'),"email"=>Input::get('email'),"user_type"=>Input::get('user_type')];
        $rules = ["name"=>"required",'email'=>'required|email|unique:users,username,'.$user_id,'user_type'=>'required'];
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