<?php
class UserController extends BaseController {
    protected $layout = 'layout';
    
    public function activeAccount($hash){
        
        $user = User::where('hash',$hash)->update(['active'=>0]);
        if($user){

        return Redirect::to('/')->with('success','Your Account is Verified Please Login!!');
        }
        else{

        return Redirect::to('/')->with('failure','Error While Verifying User Account/ Invalid Verify Link');
        }

    }
    public function postLogin()
    {
        $credentials = [
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'captcha'  => Input::get('captcha')
        ];
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->passes()) {
            $check = SimpleCaptcha::check(Input::get('captcha'));
            if($check){
                if (Auth::attempt(['username' => Input::get('username'), 'password' => Input::get('password'), 'active' => 0] )){
                    if(Auth::user()->privilege == 1){
                        $coach = Coach::where('id',Auth::user()->coach_id)->where('status',3)->first();
                        if($coach){
                            Auth::logout();
                            return Redirect::back()->withInput()->with('failure', 'Your profile has been rejected please contact aiff administration');
                        }
                    }
                    Session::put('privilege', Auth::user()->privilege);
                    if(Auth::user()->privilege == 1 ) return Redirect::to('coach/dashboard');
                    if(Auth::user()->privilege == 2 ) return Redirect::to('admin');
                    if(Auth::user()->privilege == 3 ) return Redirect::to('resultAdmin/dashboard');
                    if(Auth::user()->privilege == 4 ) return Redirect::to('superAdmin/dashboard');
                }
                else return Redirect::back()->withInput()->with('failure', 'username or password is invalid!');
            } else {
                return Redirect::back()->withInput()->with('failure', 'invalid captcha code');
            }
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
        if(Auth::User()->privilege==3){
            $this->layout->sidebar = View::make('resultAdmin.sidebar',['sidebar'=>4,'subsidebar'=>'']);
        }
        if(Auth::User()->privilege==4){
            $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>3,'subsidebar'=>'']);
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
                $mail->setFrom('info@the-aiff.com', 'All India Football Federation');
                $mail->addAddress(Input::get("username"));
                $mail->isHTML(true);
                $mail->Subject = "AIFF - Password Reset";
                $mail->Body = View::make('mail',["type" => 2, "name" => $user->name, "username"=>$user->username, "password"=>$password]);
                $mail->send();

                return Redirect::Back()->with('success', 'Your Password has been reset. Please check your email');
            } else {
                return Redirect::Back()->with('failure', 'No user found with this email');
            }
        } else {
            return Redirect::Back()->withErrors($validator)->withInput();
        }
    }

    public function capitalization(){
        $coaches = Coach::get();

        foreach ($coaches as $coach) {
            $first_name = ucwords(strtolower($coach->first_name));
            $middle_name = ucwords(strtolower($coach->middle_name));
            $last_name = ucwords(strtolower($coach->last_name));
            $full_name = ucwords(strtolower($coach->full_name));

            $updateCoach = Coach::find($coach->id);
            $updateCoach->first_name = $first_name;
            $updateCoach->middle_name = $middle_name;
            $updateCoach->last_name = $last_name;
            $updateCoach->full_name = $full_name;
            $updateCoach->save();
        }
        $updated_data = Coach::select('first_name','middle_name','last_name','full_name')->get();
        return $updated_data;
    }

    public function uploadData(){
        $destination = 'coaches-doc/';
        $file = Input::file('file');
        $filename = Input::file('file')->getClientOriginalName();
        $extension = Input::file('file')->getClientOriginalExtension();
        $name = strtotime("now").'.'.strtolower($extension);
        $file = $file->move($destination, $name);
        $cData = array();
        if(File::exists($destination.$name) && $extension == 'csv'){

            $row = 3;
            $fields = [];
            if (($handle = fopen($destination.$name, "r")) !== FALSE) {

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if($row > 4){
                        $check_user = User::where('username',$data[2])->first();

                        $cData[$row] = $data;
                        if(!$check_user){
                            $coach = new Coach;
                            $coach->full_name = $data[1];
                            $coach->save();
                            $coach->registration_id = strtoupper(date("YM")).$coach->id;
                            $coach->save();

                            $user = new User;
                            $user->name = $data[1];
                            $user->username = $data[2];
                            $user->coach_id = $coach->id;
                            $user->mobile = $data[3];
                            $user->official_types = 3;
                            $user->privilege = 1;
                            $user->save(); 
                            $cData[$row]['message'] = 'Success';
                        }else{
                            $cData[$row]['message'] = 'Duplicate Entry';
                        }
                    }

                    
                    $row++;
                }
                fclose($handle);
                $message = 'Records are uploaded successfully';
            }else{
                $message = 'file not found';
            }

            return View::make('admin.upload_data')->with(compact('cData','message'));
        }else{
            $message = 'Please upload a valid file';
            return View::make('admin.upload_data')->with(compact('message'));
        }
    }
}