<?php
class UserController extends BaseController {
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

}