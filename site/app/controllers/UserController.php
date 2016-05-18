<?php
class UserController extends BaseController {
    protected $layout = 'layout';



    public function activeAccount($hash){
        
        $user = User::where('hash',$hash)->update(['active'=>0]);
        return Redirect::to('/')->with('success','Your Account is Verified Please Login!!');
        

    }
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
            return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
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

    public function postReset(){
        $credentials = [
            'username' => Input::get('username')
        ];
        $rules = [
            'username' => 'required|email'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->passes()) {
            
            $check = User::where('username',Input::get('username'))->count();
            if($check > 0){
                $user = User::where('username',Input::get('username'))->first();
                $password = str_random(8);
                $user->password = Hash::make($password);
                $user->password_check = $password;
                $user->save();
                
                require app_path().'/classes/PHPMailerAutoload.php';
                $mail = new PHPMailer;
                $mail->isMail();
                // $mail->setFrom('info@the-aiff.com', 'All India Football Federation');
                $mail->addAddress(Input::get("username"));
                $mail->isHTML(true);
                $mail->Subject = "AIFF - CMS Password Reset";
                $mail->Body = View::make('mail',["type" => 2, "name" => $user->username, "username"=>$user->username, "password"=>$password]);
                $mail->send();

                return Redirect::Back()->with('success', 'Your Password has been reset. Please check your email');
            } else {
                return Redirect::Back()->with('failure', 'No user found with this email');
            }
        } else {
            return Redirect::Back()->withErrors($validator)->withInput();
        }
    }

}