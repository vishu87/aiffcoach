<?php
class RegistrationController extends BaseController {
	protected $layout = 'layout_reg';

	public function registration_step1($id = 0){
        $state = State::states();
        $this->layout->sidebar = '';
        if($id == 0) {
        	$data = [];
        } else {
        	$data_row = DB::table('reg_data')->where('id',$id)->first();
        	$data = $data_row->data1;
        	$data = unserialize($data);
        }
        $this->layout->main = View::make('register_step1',['state'=>$state, "data" => $data, "id" => $id]);
    }

    public function post_registration_step1(){
    	$cre = [
    		"first_name"=>Input::get("first_name"),
    		"last_name"=>Input::get("last_name"),
    		"username"=>Input::get("email"),
    		"gender"=>Input::get("gender"),
    		"dob"=>Input::get("dob"),
    		"dob_proof"=>Input::file("dob_proof"),
    		"birth_place"=>Input::get("birth_place"),
    		"photo"=>Input::file("photo")
    		];

    	$rules = [
    		"first_name"=>'required',
    		"last_name"=>'required',
    		"username"=>'required|email|unique:users',
    		"gender"=>'required',
    		"dob"=>'required|date',
    		"dob_proof"=>'required',
    		"birth_place"=>'required',
    		"photo"=>'required'
    		];
    	$validator = Validator::make($cre,$rules);
    	if($validator->passes()){
    		$data = array();
    		$destinationPath = 'coaches-doc/';

            if(Input::hasFile('photo')){
            
                $extension = Input::file('photo')->getClientOriginalExtension();
                $doc = "photo_".Auth::id().'_'.str_replace(' ','-',Input::file('photo')->getClientOriginalName());
                
                Input::file('photo')->move($destinationPath,$doc);
                $data["photo"] = $destinationPath.$doc;
            }
            if(Input::hasFile('dob_proof')){
            
                $extension = Input::file('dob_proof')->getClientOriginalExtension();
                $doc = "dobProof_".Auth::id().'_'.str_replace(' ','-',Input::file('dob_proof')->getClientOriginalName());
                
                Input::file('dob_proof')->move($destinationPath,$doc);
                $data["dob_proof"] = $destinationPath.$doc;
            }
            $data["first_name"] = Input::get('first_name');
            $data["middle_name"] = Input::get('middle_name');
            $data["last_name"] = Input::get('last_name');
            $data["email"] = Input::get('email');
            $data["gender"] = Input::get('gender');
            $data["dob"] = Input::get('dob');
            $data["birth_place"] = Input::get('birth_place');


    		$data = serialize($data);
    		if(Input::get('id') == 0){
    			$insert_id = DB::table('reg_data')->insertGetId(array('data1' => $data));
    			return Redirect::to('registerStep2/'.$insert_id);
    		} else{
    			DB::table('reg_data')->where('id',Input::get('id'))->update(array('data1' => $data));
    			return Redirect::to('registerStep2/'.Input::get('id'));
    		}
    		
    	}
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');

    }

    public function registration_step2($id = 0){

        $state = State::states();
        if($id == 0) {
            $data = [];
        } else {
            $data_row = DB::table('reg_data')->where('id',$id)->first();
            $data = $data_row->data2;
            $data = unserialize($data);
        }
        $this->layout->sidebar = '';
        $this->layout->main = View::make('register_step2',['state'=>$state,'data'=>$data,"id"=>$id]);
    }

    public function post_registration_step2(){
        $cre= [
                "state_reg"=>Input::get('state_reg'),
                "state_reference"=>Input::get('state_reference'),
                "address1"=>Input::get('address1'),
                "city"=>Input::get('city'),
                "pincode"=>Input::get('pincode'),
                "state"=>Input::get('state'),
                "mobile"=>Input::get('mobile'),
                
                ];

        $rules= [
                "state_reg"=>'required',
                "state_reference"=>'required',
                "address1"=>'required',
                "city"=>'required',
                "pincode"=>'required',
                "state"=>'required',
                "mobile"=>'required',
                
                ];        
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $all_input = Input::all();
            $data = array();
            foreach ($all_input as $key => $value) {
                $data[$key] = $value;
            }
            $data = serialize($data);
            if(Input::get('id') == 0){
                $insert_id = DB::table('reg_data')->insertGetId(array('data2' => $data));
                return Redirect::to('registerStep3/'.$insert_id);
            }
            else{
                DB::table('reg_data')->where('id',Input::get('id'))->update(array('data2' => $data));
                return Redirect::to('registerStep3/'.Input::get('id'));
            }
        }  
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
    	    
    }

    public function registration_step3($id = 0){
        
        $this->layout->sidebar = '';
        $this->layout->main = View::make('register_step3',["id"=>$id]);
    }

    public function post_registration_step3(){
        $id = Input::get('id');
        $cre = ["passport_expiry"=>Input::get('passport_expiry'),'passport'=>Input::get('passport'),'passport_proof'=>Input::file('passport_proof')];
        $rules = ["passport_expiry"=>'required|date','passport'=>'required','passport_proof'=>'required'];

        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $data = array();
            $destinationPath = 'coaches-doc/';

            if(Input::hasFile('passport_proof')){
            
                $extension = Input::file('passport_proof')->getClientOriginalExtension();
                $doc = "PassportProof_".Auth::id().'_'.str_replace(' ','-',Input::file('passport_proof')->getClientOriginalName());
                
                Input::file('passport_proof')->move($destinationPath,$doc);
                $data["passport_proof"] = $destinationPath.$doc;
            }
            
            $data["passport_expiry"] = Input::get('passport_expiry');
            $data["passport"] = Input::get('passport');

            $data = serialize($data);
            if(Input::get('id') == 0){
                $insert_id = DB::table('reg_data')->insertGetId(array('data3' => $data));
                
            }
            else{
                DB::table('reg_data')->where('id',Input::get('id'))->update(array('data3' => $data));
                
            }

            $data_row = DB::table('reg_data')->where('id',$id)->first();
            $data1 = $data_row->data1;
            $data1 = unserialize($data1);

            $data2 = $data_row->data2;
            $data2 = unserialize($data2); 

            $data3 = $data_row->data3;
            $data3 = unserialize($data3);

            $coach = new Coach;
            $coach->registration_id = '';
            $coach->first_name = $data1['first_name'];
            $coach->middle_name = $data1['middle_name'];
            $coach->last_name = $data1['last_name'];
            $coach->dob = $data1['dob'];
            $coach->state_registration = $data2['state_reg'];
            $coach->photo = $data1['photo'];
            $coach->state_reference = $data2['state_reference'];
            $coach->gender = $data1['gender'];
            $coach->save();

            $coach_parameter = new CoachParameter;
            $coach_parameter->coach_id = $coach->id;
            $coach_parameter->birth_place = $data1['birth_place'];
            $coach_parameter->dob_proof = $data1['dob_proof'];
            $coach_parameter->address1 = $data2['address1'];
            $coach_parameter->address2 = $data2['address2'];
            $coach_parameter->address_state_id = $data2['state'];
            $coach_parameter->city = $data2['city'];
            $coach_parameter->pincode = $data2['pincode'];
            $coach_parameter->email = $data1['email'];
            $coach_parameter->mobile = $data2['mobile'];
            $coach_parameter->landline = $data2['landline'];
            $coach_parameter->passport_no = $data3['passport'];
            $coach_parameter->passport_expiry = $data3['passport_expiry'];
            $coach_parameter->passport_copy = $data3["passport_proof"];
            $coach_parameter->save();


            $password = str_random(8);

            $hash =Hash::make(str_random(6).$data1['email']);
            $user = new User;
            $user->coach_id = $coach->id;
            $user->username = $data1['email'];
            $user->password = Hash::make($password);
            $user->privilege = 1;
            $user->hash = $hash;
            $user->active = 1;
            $user->password_check = $password;
            $user->save();          
            
            

            require app_path().'/classes/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->isMail();
            // $mail->setFrom('info@the-aiff.com', 'All India Football Federation');
            $mail->addAddress($data1['email']);
            $mail->isHTML(true);
            $mail->Subject = "AIFF - CMS";
            $mail->Body = View::make('mail',["type" => 1,'hash'=>$hash,'name'=>$user->username,"username"=>$user->username, "password"=>$password]);
            $mail->send();

            $delete_temp_row = DB::table('reg_data')->where('id',$id)->delete();
            return Redirect::to('/')->with('success','Registration Completed Successfully An Email is Sent to Your Registered Mail Id With Login Details!');
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
    }
    

    	
}