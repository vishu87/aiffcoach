<?php
class UserController extends BaseController {
    protected $layout = 'layout';


    public function postLogin()
    {
        $credentials = [
            'username' => Input::get('username'),
            'password' => Input::get('password')
        ];
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->passes()) {
            if (Auth::attempt(['username' => Input::get('username'), 'password' => Input::get('password'), 'active' => 0] )){
                Session::put('privilege', Auth::user()->privilege);
                if(Auth::user()->privilege == 1 ) return Redirect::to('coach');
                if(Auth::user()->privilege == 2 ) return Redirect::to('admin');
            }
            else return Redirect::back()->withInput()->with('failure', 'username or password is invalid!');
        } else {
            return Redirect::back()->withErrors($validator)->withInput();
        }
    }


    public function changePassword(){
        if(Auth::User()->privilege==1){
            $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>6,'subsidebar'=>'']);
        }
        if(Auth::User()->privilege==2){
            $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>6,'subsidebar'=>'']);
        }
        
        $this->layout->main = View::make('profile',[]);
    }
    public function updatePassword(){
    
        $cre = ["oldpwd"=>Input::get('oldpwd'),"newpwd"=>Input::get('newpwd'),"conpwd"=>Input::get('conpwd')];
        $rules = ["oldpwd"=>'required',"newpwd"=>'required|min:5',"conpwd"=>'required'];
        $oldpwd = Hash::make(Input::get('oldpwd'));
        $validator = Validator::make($cre,$rules);
        if ($validator->passes()) { 
            if (Hash::check(Input::get('oldpwd'), Auth::user()->password )) {
                if(Input::get('newpwd') === Input::get('conpwd')){
                    $password = Hash::make(Input::get('newpwd'));
                    $user = User::find(Auth::id());
                    $user->password = $password;
                    $user->password_check = Input::get('newpwd');
                    $user->save();
                    return Redirect::back()->withInput()->with('success', 'Password changed successfully ');
                } else return Redirect::back()->withInput()->with('failure', 'New passwords does not match.');
            } else {
                return Redirect::back()->withInput()->with('failure', 'Old password does not match.');
            }
        } else {
            return Redirect::back()->withErrors($validator)->withInput();
        }
            return Redirect::back()->with('failure','Unauthorised Access or Invalid Password')->withErrors($validator)->withInput();
    }

}