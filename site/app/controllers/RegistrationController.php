<?php
class RegistrationController extends BaseController {
	protected $layout = 'layout_reg';

	public function registration_step1($id = 0){
        $state = State::states();
        if($id == 0) {
        	$data = [];
        } else {
            $check = DB::table('reg_data')->where('id',$id)->count();
            if($check<1){
                return Redirect::to('/registerStep1');
            }
        	$data_row = DB::table('reg_data')->where('id',$id)->first();
        	$data = $data_row->data1;
        	$data = unserialize($data);
        }
        $this->layout->main = View::make('registration.register_step1',['state'=>$state, "data" => $data,"id" => $id,'flag'=>1]);
    }

    public function post_registration_step1(){
    	$cre = [
    		"first_name"=>Input::get("first_name"),
    		"last_name"=>Input::get("last_name"),
    		"username"=>Input::get("email"),
    		"gender"=>Input::get("gender"),
    		"birth_place"=>Input::get("birth_place"),
            "dob"=>Input::get("dob")
    	];
    	$rules = [
    		"first_name"=>'required',
    		"last_name"=>'required',
    		"username"=>'required|email|unique:users',
    		"gender"=>'required',
    		"birth_place"=>'required',
            "dob"=>"required"
    	];
        if(Input::get('id') == 0){
            $rules = $rules + ["dob_proof"=>'required',"photo"=>'required'];
            $cre = $cre + ["dob_proof"=>Input::file('dob_proof'),"photo"=>Input::file('photo')] ;
        }
    	$validator = Validator::make($cre,$rules);
    	if($validator->passes()){
    		$data = array();
    		$destinationPath = 'coaches-doc/';

            if(Input::get('id') != 0){
               $data_old = DB::table('reg_data')->where('id',Input::get('id'))->first();
               $data_old = $data_old->data1;
               if($data_old != ''){
                $data_old = unserialize($data_old);
               }
            }

            if(Input::hasFile('photo')){
            
                $extension = Input::file('photo')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "photo_".strtotime("now").'_'.rand(1,100).'.'.$extension;
                    Input::file('photo')->move($destinationPath,$doc);
                    $data["photo"] = $destinationPath.$doc;    
                }
            } else {
                if(isset($data_old)){
                    if(isset($data_old["photo"])){
                        $data["photo"] = $data_old["photo"];
                    }
                }
            }

            if(Input::hasFile('dob_proof')){
            
                $extension = Input::file('dob_proof')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "dobproof_".strtotime("now").'_'.rand(1,100).'.'.$extension;
                    Input::file('dob_proof')->move($destinationPath,$doc);
                    $data["dob_proof"] = $destinationPath.$doc;
                }

            } else {
                if(isset($data_old)){
                    if(isset($data_old["dob_proof"])){
                        $data["dob_proof"] = $data_old["dob_proof"];
                    }
                }
            }

            $data["first_name"] = Input::get('first_name');
            $data["middle_name"] = Input::get('middle_name');
            $data["last_name"] = Input::get('last_name');
            $data["email"] = Input::get('email');
            $data["gender"] = Input::get('gender');
            $data["dob"] = date('Y-m-d',strtotime(Input::get('dob')));
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

    public function registration_step2($id){
        $check = DB::table('reg_data')->where('id',$id)->count();
        if($check<1){
            return Redirect::to('/registerStep1');
        }
        $state = State::states();
        $data_row = DB::table('reg_data')->where('id',$id)->first();
        if($data_row->data1==''){
            return Redirect::to('/registerStep1/'.$id);
        }
        $data = $data_row->data2;
        $data = unserialize($data);

    
        $this->layout->main = View::make('registration.register_step2',['state'=>$state,'data'=>$data,"id"=>$id,'flag'=>2]);
    }

    public function post_registration_step2(){
        $cre= [
                "state_id"=>Input::get('state_id'),
                "address1"=>Input::get('address1'),
                "city"=>Input::get('city'),
                "pincode"=>Input::get('pincode'),
                "state"=>Input::get('state'),
                "mobile"=>Input::get('mobile'),
                ];
        $rules= [
                "state_id"=>'required',
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

    public function registration_step3($id){
        $check = DB::table('reg_data')->where('id',$id)->count();
        if($check<1){
            return Redirect::to('/registerStep1');
        }
        $official_types = [""=>"Select"] + User::OfficialTypeForRegistration();
        $emp_status = ["" => "Select"] + EmploymentDetails::emp_status();
        
        $this->layout->main = View::make('registration.register_step3',["id"=>$id,'flag'=>3, 'official_types' => $official_types , "emp_status" => $emp_status]);
    }

    public function post_registration_step3(){
        $id = Input::get('id');
        $cre = [
            "official_types"=>Input::get("official_types"),
            
            "end_date"=>Input::get("end_date"),
            
            
            'employment_status' => Input::get('employment_status'),
            'referral_contact' => Input::get('referral_contact'),
            'referral_name' => Input::get('referral_name'),
            'cv' => Input::file('cv'),
        ];
        $rules = [
            "official_types" => "required",
            
            "end_date" => "date|after:start_date",
            
            'employment_status' => 'required',
            'referral_contact' => 'required',
            'referral_name' => 'required',
            'cv' => 'required',
        ];

        if(Input::get("official_types") == 1){
            $cre = $cre + [
                    "start_date"=>Input::get("start_date"),
                    "license_number" => Input::get("license_number"),
                    "license" => Input::file("license"),
                ];

            $rules = $rules + [
                    "start_date" => "required |date",
                    "license_number" =>"required",
                    "license" =>"required",
                ];

        }

        if(Input::get('employment_status') != 3){
            $cre['present_emp'] = Input::get('present_emp');
            $cre['date_since_emp'] = Input::get('date_since_emp');
            $cre['present_emp_copy'] = Input::file('present_emp_copy');

            $rules['present_emp'] = 'required';
            $rules['date_since_emp'] = 'required |date';
            $rules['present_emp_copy'] = 'required';

        }
        if(Input::has('recc')){
            $cre['equivalent_license_id'] = Input::get('equivalent_license_id');
            $rules['equivalent_license_id'] = 'required';
        }
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $data = array();
            $destinationPath = 'coaches-doc/';
            if(Input::hasFile('passport_proof')){
                $extension = Input::file('passport_proof')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "PassportProof_".strtotime("now").'_'.rand(1,100).'.'.$extension;
                    
                    Input::file('passport_proof')->move($destinationPath,$doc);
                    $data["passport_proof"] = $destinationPath.$doc;
                }
            }

            if(Input::hasFile('doctor_degree')){
                $extension = Input::file('doctor_degree')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "Doctor_degree_".strtotime("now").'_'.rand(1,100).'.'.$extension;
                    
                    Input::file('doctor_degree')->move($destinationPath,$doc);
                    $data["doctor_degree"] = $destinationPath.$doc;
                }
            }
            
            $licensePath = 'coach-licenses/';

            if(Input::hasFile('license')){

                $extension = Input::file('license')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "license_".strtotime("now").'_'.rand(1,100).'.'.$extension;
                    
                    Input::file('license')->move($licensePath,$doc);
                    $data["license"] = $licensePath.$doc;
                }
            }

            $data["passport_expiry"] = Input::get('passport_expiry');
            $data["passport"] = Input::get('passport');
            $data["official_types"] = Input::get('official_types');

            $data["license_id"] = Input::get('license_id');
            $data["license_number"] = Input::get('license_number');
            $data["start_date"] = Input::get('start_date');
            $data["is_doctor"] = (Input::has('is_doctor'))?Input::get('is_doctor'):0;

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
            // return $data2;
            $data3 = $data_row->data3;
            $data3 = unserialize($data3);

            $coach = new Coach;
            $coach->first_name = ucwords(strtolower($data1['first_name']));
            $coach->middle_name = ucwords(strtolower($data1['middle_name']));
            $coach->last_name = ucwords(strtolower($data1['last_name']));

            $full_name = ucwords(strtolower($data1['first_name']));
            if(isset($data1['middle_name']) && $data1['middle_name']){
                $full_name .=' '.ucwords(strtolower($data1['middle_name']));
            }
            $full_name .= ' '.ucwords(strtolower($data1['last_name']));

            $coach->full_name = $full_name;
            $coach->dob = $data1['dob'];
            if(isset($data1['photo'])){

                $coach->photo = $data1['photo'];
            }
            $coach->state_id = $data2['state_id']; // state if domicile

            if($data2['state_id'] == 37){
                $coach->domicile_country = $data2['domicile_country'];
                $coach->domicile_state = $data2['domicile_state'];
            }

            $coach->gender = $data1['gender'];
            $coach->is_doctor = $data3['is_doctor'];
            $coach->doctor_degree = (isset($data3["doctor_degree"]))?$data3["doctor_degree"]:'';
            $coach->save();
            $coach->registration_id = strtoupper(date("YM")).$coach->id;
            $coach->save();

            $coach_parameter = new CoachParameter;
            $coach_parameter->coach_id = $coach->id;
            $coach_parameter->birth_place = $data1['birth_place'];
            $coach_parameter->dob_proof = $data1['dob_proof'];
            $coach_parameter->address1 = $data2['address1'];
            $coach_parameter->address2 = $data2['address2'];
            $coach_parameter->address_state_id = $data2['state'];
            if($data2['state'] == 37){
                $coach_parameter->address_country = $data2['address_country'];
                $coach_parameter->address_state = $data2['address_state'];
            }
            $coach_parameter->city = $data2['city'];
            $coach_parameter->pincode = $data2['pincode'];
            $coach_parameter->email = $data1['email'];
            $coach_parameter->mobile = $data2['mobile'];
            $coach_parameter->landline = $data2['landline'];
            $coach_parameter->save();

            $password = str_random(8);
            $hash = Hash::make(str_random(6));

            $user = new User;
            $user->coach_id = $coach->id;
            $user->name = $coach->full_name;
            $user->username = $data1['email'];
            $user->password = Hash::make($password);
            $user->privilege = 1;
            $user->hash = $hash;
            $user->active = 0; // make him active
            $user->password_check = $password;
            $user->official_types = $data3["official_types"];
            $user->save();

            //Coaches license details

            $coach_license = new CoachLicense;
            $coach_license->coach_id = $coach->id;
            $coach_license->license_id = ($data3["license_id"] != "")?$data3["license_id"]:"0";
            $coach_license->document = (isset($data3["license"]))?$data3["license"]:'';
            $coach_license->number = $data3["license_number"];
            $coach_license->start_date = date('Y-m-d',strtotime($data3["start_date"]));
            $coach_license->end_date = (Input::get('end_date') != '') ? date('Y-m-d',strtotime(Input::get('end_date'))) : null;
            if(Input::has("recc")){
                $coach_license->recc = Input::get('recc');
                $coach_license->equivalent_license_id = Input::get('equivalent_license_id');

                if(Input::hasFile('recc_document')){
                    $extension = Input::file('recc_document')->getClientOriginalExtension();
                    if(in_array($extension, User::fileExtensions())){
                        $doc = "license_recc_".Auth::id().'_'.strtotime("now").'.'.$extension;
                        Input::file('recc_document')->move($licensePath,$doc);
                        $coach_license->recc_document = $licensePath.$doc;
                    }
                }
                
            }
            $coach_license->save();

            //passport Details
            if(isset($data3["passport_proof"])){
                if($data3['passport_proof'] != '' && $data3['passport'] != '' && $data3['passport_expiry'] != ''){
                    $document = new CoachDocument;
                    $document->coach_id = $coach->id;
                    $document->document_id = 1; // for passport
                    $document->name = '';
                    $document->status = 0;
                    $document->file = (isset($data3["passport_proof"]))?$data3["passport_proof"]:'';
                    $document->number = (isset($data3['passport']))?$data3['passport']:'';
                    $document->expiry_date = date('Y-m-d',strtotime($data3["passport_expiry"]));
                    $document->save();
                }
            }

            //birth proof documents
            if($data1['dob_proof']){
                $document = new CoachDocument;
                $document->coach_id = $coach->id;
                $document->document_id = 2; // for date of birth
                $document->name = '';
                $document->status = 0;
                $document->file = (isset($data1["dob_proof"]))?$data1["dob_proof"]:'';
                $document->save();
            }
            // $coach_parameter->passport_no = $data3['passport'];
            // $coach_parameter->passport_expiry = $data3['passport_expiry'];
            // $coach_parameter->passport_copy = $data3["passport_proof"];


            /* *****  Coach employment details starts here  ****** */
            $employment = new EmploymentDetails;
            $employment->coach_id = $coach->id;
            $employment->employment = Input::get('present_emp');
            $employment->emp_status = Input::get('employment_status');
            $employment->referral_name = Input::get('referral_name');
            $employment->referral_contact = Input::get('referral_contact');
            $employment->start_date = date('Y-m-d',strtotime(Input::get('date_since_emp')));
            $employment->end_date = (Input::get('end_date') != '') ? date('Y-m-d',strtotime(Input::get('end_date'))) : null;

            if(Input::hasFile('present_emp_copy')){
                $extension = Input::file('present_emp_copy')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "presentemp_".$coach->id.'_'.strtotime("now").'.'.$extension;
                    
                    Input::file('present_emp_copy')->move($destinationPath,$doc);
                    $employment->contract = $destinationPath.$doc;
                }
            }

            if(Input::hasFile('cv')){
                $extension = Input::file('cv')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "cv_".$coach->id.'_'.strtotime("now").'.'.$extension;
                    Input::file('cv')->move($destinationPath,$doc);
                    $employment->cv = $destinationPath.$doc;
                }
            }

            $employment->save();

            /* coach employment details ends here */

            $username = $user->username;
            require app_path().'/classes/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->isMail();
            $mail->setFrom('info@the-aiff.com', 'All India Football Federation');
            $mail->addAddress($username);
            $mail->isHTML(true);
            $mail->Subject = "Login Details - AIFF Official Registration System";
            $mail->Body = View::make('mail',["type" => 1,'name'=>$coach->full_name, "username"=>$user->username, "password"=>$password]);
            $mail->send();

            $delete_temp_row = DB::table('reg_data')->where('id',$id)->delete();
            
            return Redirect::to('/')->with('success','You have successfully registered. An email has been sent to your registered e-mail with login details!');
            
        } else {
            return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
        }
    }
    

    	
}