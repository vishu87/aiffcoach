
<?php
class CoachController extends BaseController {
    protected $layout = 'layout';
    public function index(){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        if($coach->status!=0){
            $state =[""=>'Select'] + State::orderBy('name','asc')->lists('name','id');
            $CoachParameters = CoachParameter::where('coach_id',Auth::User()->coach_id)->first();
            $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile']);
            $this->layout->main = View::make('coaches.profile',['state'=>$state,'coach'=>$CoachParameters]);

        }
        else{
            $this->layout->sidebar = '';
            $this->layout->main = View::make('coaches.index');
        }
    }


    public function addNewEmployment(){
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make('coaches.addEmployment');
    }

    public function register(){
    	
     	$cre = [
     			'photo'=>Input::file('photo'),
     			'passport_proof'=>Input::file('passport_proof'),
     			'dob_proof'=>Input::file('dob_proof'),
     			'fname'=>Input::get('fname'),
     			'lname'=>Input::get('lname'),
     			'email'=>Input::get('email'),
     			'dob_date'=>Input::get('dob_date'),
     			'dob_month'=>Input::get('dob_month'),
     			'dob_year'=>Input::get('dob_year'),
     			'birth_place'=>Input::get('birth_place'),
     			'state_reg'=>Input::get('state_reg'),
     			'gender'=>Input::get('gender'),
     			'address1'=>Input::get('address1'),
     			'state'=>Input::get('state'),
     			'mobile'=>Input::get('mobile'),
     			'passport'=>Input::get('passport'),
     			'passport_date'=>Input::get('passport_date'),
     			'passport_month'=>Input::get('passport_month'),
     			'passport_year'=>Input::get('passport_year'),
     			];
     	$rules=[
     		    'photo'=>'required',
     			'passport_proof'=>'required',
     			'dob_proof'=>'required',
     			'fname'=>'required',
     			'lname'=>'required',
     			'email'=>'required|email|unique:users,username',
     			'dob_date'=>'required',
     			'dob_month'=>'required',
     			'dob_year'=>'required',
     			'birth_place'=>'required',
     			'state_reg'=>'required',
     			'gender'=>'required',
     			'address1'=>'required',
     			'state'=>'required',
     			'mobile'=>'required',
     			'passport'=>'required',
     			'passport_date'=>'required',
     			'passport_month'=>'required',
     			'passport_year'=>'required',
   			
     			];	
     	$validator = Validator::make($cre,$rules);
     	if($validator->passes()){
     		// return "ok";
     		$dob = Input::get('dob_date').'-'.Input::get('dob_month').'-'.Input::get('dob_year');
    		$dob=strtotime($dob);
     		$dob= date('Y-m-d',$dob);

     		$passport_expiry = Input::get('passport_date').'-'.Input::get('passport_month').'-'.Input::get('passport_year');
    		$passport_expiry=strtotime($passport_expiry);
     		$passport_expiry= date('Y-m-d',$passport_expiry);

            $destinationPath = 'coaches-doc/';//folder in root for all uploaded documents

     		$coach = new Coach;
            $coach->registration_id = '';
     		$coach->first_name = Input::get('fname');
     		$coach->middle_name = Input::get('mname');
     		$coach->last_name = Input::get('lname');
            $coach->dob = $dob;
            $coach->state_registration = Input::get('state_reg');
            $coach->state_reference = Input::get('state_reference');
            $coach->gender = Input::get('gender');
			
     		
     		/******upload coach birth proof*****/
     		if(Input::hasFile('photo')){
			
	            $extension = Input::file('photo')->getClientOriginalExtension();
	            $doc = str_replace(' ','-',Input::file('photo')->getClientOriginalName());
	            $count = 1;
	            $doc_ori = $doc;
	            while(File::exists($destinationPath.$doc)){
	                $doc = $count.'-'.$doc_ori;
	                $count++;
	            }
	            Input::file('photo')->move($destinationPath,$doc);
				$coach->photo = $destinationPath.$doc;
			}
            $coach->save();

            $coach_parameter = new CoachParameter;
            $coach_parameter->coach_id = $coach->id;

            /******upload coach photograph*****/
            if(Input::hasFile('dob_proof')){
            
                $extension = Input::file('dob_proof')->getClientOriginalExtension();
                $doc = str_replace(' ','-',Input::file('dob_proof')->getClientOriginalName());
                $count = 1;
                $doc_ori = $doc;
                while(File::exists($destinationPath.$doc)){
                    $doc = $count.'-'.$doc_ori;
                    $count++;
                }
                Input::file('dob_proof')->move($destinationPath,$doc);
                $coach_parameter->dob_proof = $destinationPath.$doc;
            }

     		/******upload coach passport copy*****/
     		if(Input::hasFile('passport_proof')){
			
	            $extension = Input::file('passport_proof')->getClientOriginalExtension();
	            $doc = str_replace(' ','-',Input::file('passport_proof')->getClientOriginalName());
	            $count = 1;
	            $doc_ori = $doc;
	            while(File::exists($destinationPath.$doc)){
	                $doc = $count.'-'.$doc_ori;
	                $count++;
	            }
	            Input::file('passport_proof')->move($destinationPath,$doc);
				$coach_parameter->passport_copy = $destinationPath.$doc;
			}
            /******upload ends*****/

     		
     		$coach_parameter->birth_place = Input::get('birth_place');
            
            $coach_parameter->address1 = Input::get('address1');
            $coach_parameter->address2 = Input::get('address2');
            $coach_parameter->address_state_id = Input::get('state');
            $coach_parameter->city = Input::get('city');
            $coach_parameter->pincode = Input::get('pincode');
            $coach_parameter->email = Input::get('email');
            $coach_parameter->mobile = Input::get('mobile');
            $coach_parameter->landline = Input::get('landline');
            $coach_parameter->passport_no = Input::get('passport');
            $coach_parameter->passport_expiry = $passport_expiry;
            $coach_parameter->save();


     		$password = str_random(8);
     		$user = new User;
     		$user->coach_id = $coach->id;
     		$user->username = Input::get('email');
     		$user->password = Hash::make($password);
            $user->privilege = 1;
     		$user->password_check = $password;
     		$user->save();

     		return Redirect::Back()->with('success','You Have Successfully Registered');
     	}
     	return Redirect::back()->withErrors($validator)->withInput();			
    }

    public function postEmployment(){
     
        $cre=["present_emp"=>Input::get('present_emp'),
            "date_since_emp"=>Input::get("date_since_emp"),
            "aiff_certificate"=>Input::get("aiff_certificate"),
            "aiff_certificate_copy"=>Input::file("aiff_certificate_copy"),
            "last_afc_date"=>Input::get("last_afc_date"),
            "aiff_latest_copy"=>Input::file("aiff_latest_copy"),
           
           ];
        $rules =[ "present_emp"=>'required',
                 "date_since_emp"=>'required',
                 "aiff_certificate"=>'required',
                 "aiff_certificate_copy"=>'required',
                 "last_afc_date"=>'required',
                 "aiff_latest_copy"=>'required',
                 
           ];      
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){

            $destinationPath = "coaches-doc/";

            $employment_details = new EmploymentDetails;
            $employment_details->coach_id = Auth::User()->coach_id;
            $employment_details->employment = Input::get('present_emp');
            $employment_details->start_date = Input::get('date_since_emp');
            if(Input::hasFile('present_emp_copy')){
                $extension = Input::file('present_emp_copy')->getClientOriginalExtension();
                $doc = str_replace(' ','-',Input::file('present_emp_copy')->getClientOriginalName());
                $count = 1;
                $doc_ori = $doc;
                while(File::exists($destinationPath.$doc)){
                    $doc = $count.'-'.$doc_ori;
                    $count++;
                }
                Input::file('present_emp_copy')->move($destinationPath,$doc);
                $employment_details->contract = $destinationPath.$doc;
            }
            $employment_details->save();

            $emp_name = Input::get('emp_name');
            $start_date = Input::get('start_date');
            $end_date = Input::get('end_date');
            $count1 = 0;
            foreach ($emp_name as $value) {
                if($emp_name[$count1]!='' && $start_date[$count1] !='' && $end_date[$count1]!=''){
                    $employment_details = new EmploymentDetails;
                    $employment_details->coach_id = Auth::User()->coach_id;
                    $employment_details->employment=$emp_name[$count1];
                    $employment_details->start_date = $start_date[$count1];
                    $employment_details->end_date = $end_date[$count1];
                        
                    $employment_details->save();
                }
                $count1++;
            }

            $registeration_details = new RegistrationDetails;
            $registeration_details->coach_id = Auth::User()->coach_id;
            $registeration_details->certificate_no = Input::get('aiff_certificate');
            $registeration_details->certificate_date = Input::get('last_afc_date');

            if(Input::hasFile('aiff_certificate_copy')){

                $extension = Input::file('aiff_certificate_copy')->getClientOriginalExtension();
                $doc = str_replace(' ','-',Input::file('aiff_certificate_copy')->getClientOriginalName());
                $count = 1;
                $doc_ori = $doc;
                while(File::exists($destinationPath.$doc)){
                     $doc = $count.'-'.$doc_ori;
                     $count++;
                }
                Input::file('aiff_certificate_copy')->move($destinationPath,$doc);
                $registeration_details->certificate_copy = $destinationPath.$doc;
            }
            if(Input::hasFile('aiff_latest_copy')){

                $extension = Input::file('aiff_latest_copy')->getClientOriginalExtension();
                $doc = str_replace(' ','-',Input::file('aiff_latest_copy')->getClientOriginalName());
                $count = 1;
                $doc_ori = $doc;
                while(File::exists($destinationPath.$doc)){
                     $doc = $count.'-'.$doc_ori;
                     $count++;
                }
                Input::file('aiff_latest_copy')->move($destinationPath,$doc);
                $registeration_details->latest_certificate_copy = $destinationPath.$doc;
            }
            $registeration_details->save();

            Coach::where('id',Auth::User()->coach_id)->update(["status"=>1]);

            return Redirect::back()->with('success','All Details Uploaded Successfully');
        } 
        return "welcom";
        return Redirect::back()->withErrors($validator)->withInput();     
    }

    public function updatePassport(){
        $destinationPath = 'coaches-doc/';
        
        $updatePassport = CoachParameter::find(Auth::User()->coach_id);
        $updatePassport->passport_no= Input::get('passport_no');
        $updatePassport->passport_expiry = Input::get('passport_expiry');

        if(Input::hasFile('passport_proof')){
            
            $extension = Input::file('passport_proof')->getClientOriginalExtension();
            $name = "Passport_".Auth::id().'_'.strtotime("now").'.'.$extension;
            Input::file('passport_proof')->move($destinationPath,$name);
            $updatePassport->passport_copy=$destinationPath.$name;
        }
        $updatePassport->save();
        return Redirect::Back()->with('success','Passport Details Updated Successfully');
        
    }
    public function updateContact(){
        
        $updateContact = CoachParameter::where('coach_id',Auth::User()->coach_id)->update(["address1"=>Input::get('address1'),"address2"=>Input::get('address2'),"city"=>Input::get('city'),"pincode"=>Input::get('pincode'),"address_state_id"=>Input::get('state'),"mobile"=>Input::get('mobile'),"landline"=>Input::get('landline'),"alternate_email"=>Input::get('aemail')]);
        return Redirect::Back()->with('success','Contact Details Updated Successfully');
        
    }

    public function employmentDetails(){
        $employment = EmploymentDetails::where('coach_id',Auth::User()->coach_id)->get();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'2']);
        $this->layout->main = View::make('coaches.employment',['employment'=>$employment]);

    }
    public function addEmployment(){
        $cre = [
            'present_emp'=>Input::get('present_emp'),
            'start_date'=>Input::get('date_since_emp'),
            
            ];
        $rules = [
            'present_emp'=>'required',
            'start_date'=>'required',
            
            ];    
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){

            $destinationPath = 'coaches-doc/';
            $employment = new EmploymentDetails;
            $employment->coach_id = Auth::User()->coach_id;
            $employment->employment = Input::get('present_emp');
            $employment->start_date = Input::get('date_since_emp');
            $employment->end_date = Input::get('end_date');
            if(Input::hasFile('present_emp_copy')){
                $extension = Input::file('present_emp_copy')->getClientOriginalExtension();
                $doc = str_replace(' ','-',Input::file('present_emp_copy')->getClientOriginalName());
                $count = 1;

                $doc_ori = $doc;
                while(File::exists($destinationPath.$doc)){
                    $doc = $count.'-'.$doc_ori;
                    $count++;
                }
                Input::file('present_emp_copy')->move($destinationPath,$doc);
                $employment->contract = $destinationPath.$doc;
            }

            $employment->save();
            return Redirect::to('coach/employmentDetails')->with('success','Employment Details Added Successfully');    
        }
        return Redirect::back()->withErrors($validator)->withInput();    
        
    }
    public function editEmployment($id){
        $employment = EmploymentDetails::find($id);
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>"2"]);
        $this->layout->main =  View::make('coaches.addEmployment',['employment'=>$employment]);
    }
    public function updateEmployment($id){
        $cre = [
            'present_emp'=>Input::get('present_emp'),
            'start_date'=>Input::get('date_since_emp'),
            
            ];
        $rules = [
            'present_emp'=>'required',
            'start_date'=>'required',
            
            ];    
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){

            $destinationPath = 'coaches-doc/';
            $updateEmployment = EmploymentDetails::find($id);
            $updateEmployment->employment = Input::get('present_emp');
            $updateEmployment->start_date = Input::get('date_since_emp');
            $updateEmployment->end_date = Input::get('end_date');
            if(Input::hasFile('present_emp_copy')){
                $extension = Input::file('present_emp_copy')->getClientOriginalExtension();
                $doc = str_replace(' ','-',Input::file('present_emp_copy')->getClientOriginalName());
                $count = 1;
                $doc_ori = $doc;
                while(File::exists($destinationPath.$doc)){
                    $doc = $count.'-'.$doc_ori;
                    $count++;
                }
                Input::file('present_emp_copy')->move($destinationPath,$doc);
                $updateEmployment->contract = $destinationPath.$doc;
            }
            $updateEmployment->save();            
           
            return Redirect::back()->with('success','Details Updated Successfully');    
        }
        return Redirect::back()->withErrors($validator)->withInput();    
        
    }

    public function deleteEmployment($id){
        EmploymentDetails::find($id)->delete();
        $data['success'] = 'true';
        return json_encode($data);
    }
}