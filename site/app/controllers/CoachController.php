    
<?php
class CoachController extends BaseController {
    protected $layout = 'layout';
    public function dashboard(){
        $courses =  Course::Active()->get();
        $check = [];
        foreach ($courses as $course) {
            $count = Application::where('coach_id',Auth::User()->coach_id)->where('course_id',$course->id)->count();
            if($count>=1){
                $check[] = $course->id;
            }
        }
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>'dashboard']);
        $this->layout->main = View::make('coaches.dashboard',['courses'=>$courses,'title'=>'Active Courses','check'=>$check]);
    }
    public function contactInformation(){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        $state =[""=>'Select'] + State::orderBy('name','asc')->lists('name','id');
        $CoachParameters = CoachParameter::where('coach_id',Auth::User()->coach_id)->first();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>2]);
        $this->layout->main = View::make('coaches.profile',['state'=>$state,'coach'=>$CoachParameters,"profileType"=>2,'title'=>'Contact Information']);
    }
    // public function passportDetails(){
    //     $id = Auth::User()->coach_id;
    //     $coach = Coach::find($id);
    //     if($coach->status!=0){   
    //         $CoachParameters = CoachParameter::where('coach_id',Auth::User()->coach_id)->first();
    //         $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>3]);
    //         $this->layout->main = View::make('coaches.profile',['coach'=>$CoachParameters,"profileType"=>3,'title'=>'Passport Details']);
    //     }
    //     else{
    //         $this->layout->sidebar = '';
    //         $this->layout->main = View::make('coaches.index');
    //     }
    // }
    public function personalInformation(){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        $CoachParameter = CoachParameter::where('coach_id',Auth::User()->coach_id)->first();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>1]);
        $this->layout->main = View::make('coaches.profile',['coach'=>$coach,'CoachParameter'=>$CoachParameter,"profileType"=>1,'title'=>'Personal Details']);
    }
    public function updatePersonalInformation(){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        $cre = ["dob"=>Input::get('dob'),"gender"=>Input::get("gender")];
        $rules = ["dob"=>'required',"gender"=>'required'];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $coach = Coach::find($id);
            $coach->dob = date('Y-m-d',strtotime(Input::get('dob')));
            $coach->gender = Input::get('gender');
            $destinationPath = 'coaches-doc/';//folder in root for all uploaded documents
            if(Input::hasFile('photo')){
                $extension = Input::file('photo')->getClientOriginalExtension();
                $doc = "photo_".Auth::id().'_'.str_replace(' ','-',Input::file('photo')->getClientOriginalName());
                Input::file('photo')->move($destinationPath,$doc);
                $coach->photo = $destinationPath.$doc;
            }
            $coach->save();
            return Redirect::back()->with('success','Details Updated Successfully');
        }
        else{
            $this->layout->sidebar = '';
            $this->layout->main = View::make('coaches.index');
        }
    }
    public function measurements(){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        $measurements = Measurement::where('coach_id',Auth::User()->coach_id)->count();
        if($measurements<1){
            $measurement = array();
        }
        else{
            $measurement = Measurement::where('coach_id',Auth::User()->coach_id)->first();
        }
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>1]);
        $this->layout->main = View::make('coaches.profile',['coach'=>$coach,'measurement'=>$measurement,"profileType"=>4,'title'=>'Measurements']);
    }

    public function updateMeasurements(){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        $check = Measurement::where('coach_id',$id)->count();
        if($check<1){
            $measurement = new Measurement;
            $measurement->coach_id = $id;
        }
        else{
            $measurement_id = Measurement::select('id')->where('coach_id',$id)->first();
            $measurement = Measurement::find($measurement_id->id);
        }
        $measurement->height=Input::get('height');
        $measurement->weight=Input::get('weight');
        $measurement->shoes=Input::get('shoes');
        $measurement->boots=Input::get('boots');
        $measurement->sliper=Input::get('sliper');
        $measurement->tracksuit=Input::get('tracksuit');
        $measurement->jersey=Input::get('jersey');
        $measurement->shorts=Input::get('shorts');
        $measurement->shirts=Input::get('shirts');
        $measurement->save();
        return Redirect::back()->with('success','Measurement Parameters Updated Successfully');
    }
    public function documents(){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        $ApprovalStatus = Approval::status();
        $documents = CoachDocument::where('coach_id',$id)->get();
        $document_types = [''=>"select"]+CoachDocument::DocTypes();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>1]);
        $this->layout->main = View::make('coaches.profile',['documents'=>$documents,'document_types'=>$document_types,"profileType"=>5,'title'=>'Add Documents' , "ApprovalStatus"=>$ApprovalStatus]);
    }

    public function addDocument(){
        $id = Auth::User()->coach_id;
        $cre = [
            "document"=>Input::get('document'),
            "file"=>Input::file('file'),
        ];
        $rules = [
            "document"=>'required',
            "file"=>'required',
        ];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $document = new CoachDocument;
            $document->coach_id = $id;
            $document->document_id = Input::get('document');
            $document->remarks = Input::get('remarks');
            $document->expiry_date = date('Y-m-d',strtotime(Input::get('expiry')));
            if(Input::has('doc_name')){
                $document->name = Input::get('doc_name');
            }
            $destinationPath= 'coaches-doc/';
            if(Input::hasFile('file')){
                $extension = Input::file('file')->getClientOriginalExtension();
                $doc = "file_".Auth::id().'_'.str_replace(' ','-',Input::file('file')->getClientOriginalName());
                Input::file('file')->move($destinationPath,$doc);
                $document->file = $destinationPath.$doc;
            }
            $document->save();
            return Redirect::back()->with('success','New Documents Added Successfully');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }  
    public function deleteDocument($id){
        $count = CoachDocument::where('id',$id)->count();
        if($count<1){
            $data['success'] = false;
            $data['message'] = "Can't delete this document or document does not exist !";
        }
        else{
            $delete = CoachDocument::find($id)->delete();
            $data['success'] = true;
        }
        return json_encode($data);
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
	            $doc = "photo_".Auth::id().'_'.str_replace(' ','-',Input::file('photo')->getClientOriginalName());
	            Input::file('photo')->move($destinationPath,$doc);
				$coach->photo = $destinationPath.$doc;
			}
            $coach->save();
            $coach_parameter = new CoachParameter;
            $coach_parameter->coach_id = $coach->id;
            /******upload coach photograph*****/
            if(Input::hasFile('dob_proof')){
                $extension = Input::file('dob_proof')->getClientOriginalExtension();
                $doc = "dobProof_".Auth::id().'_'.str_replace(' ','-',Input::file('dob_proof')->getClientOriginalName());
                Input::file('dob_proof')->move($destinationPath,$doc);
                $coach_parameter->dob_proof = $destinationPath.$doc;
            }
     		/******upload coach passport copy*****/
     		if(Input::hasFile('passport_proof')){
	            $extension = Input::file('passport_proof')->getClientOriginalExtension();
	            $doc = "PassportProof_".Auth::id().'_'.str_replace(' ','-',Input::file('passport_proof')->getClientOriginalName());
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
     	return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');			
    }
    public function postEmployment(){
        $cre=["present_emp"=>Input::get('present_emp'),
            "date_since_emp"=>Input::get("date_since_emp"),
            "aiff_certificate"=>Input::get("aiff_certificate"),
            "aiff_certificate_copy"=>Input::file("aiff_certificate_copy"),
            "last_afc_date"=>Input::get("last_afc_date"),
            "aiff_latest_copy"=>Input::file("aiff_latest_copy"),
           ];
        $rules =[
            "present_emp"=>'required',
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
                $doc = "PassportProof_".Auth::id().'_'.str_replace(' ','-',Input::file('present_emp_copy')->getClientOriginalName());
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
                $doc = "aiffcertificate_".Auth::id().'_'.str_replace(' ','-',Input::file('aiff_certificate_copy')->getClientOriginalName());
                Input::file('aiff_certificate_copy')->move($destinationPath,$doc);
                $registeration_details->certificate_copy = $destinationPath.$doc;
            }
            if(Input::hasFile('aiff_latest_copy')){
                $extension = Input::file('aiff_latest_copy')->getClientOriginalExtension();
                $doc = "aiffLatest_".Auth::id().'_'.str_replace(' ','-',Input::file('aiff_latest_copy')->getClientOriginalName());
                Input::file('aiff_latest_copy')->move($destinationPath,$doc);
                $registeration_details->latest_certificate_copy = $destinationPath.$doc;
            }
            $registeration_details->save();
            Coach::where('id',Auth::User()->coach_id)->update(["status"=>1]);
            return Redirect::back()->with('success','All Details Uploaded Successfully');
        } 
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');     
    }
    public function updatePassport(){
        $cre = ['passport_no'=>Input::get('passport_no'),'passport_expiry'=>Input::get('passport_expiry')];
        $rules = ['passport_no'=>'required','passport_expiry'=>'required|date'];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $coach_parameter_id = CoachParameter::select('id')->where('coach_id',Auth::User()->coach_id)->first();
            $destinationPath = 'coaches-doc/';
            $updatePassport = CoachParameter::find($coach_parameter_id->id);
            $updatePassport->passport_no= Input::get('passport_no');
            $updatePassport->passport_expiry = Input::get('passport_expiry');
            if(Input::hasFile('passport_proof')){
                $extension = Input::file('passport_proof')->getClientOriginalExtension();
                $name = "PassportProof_".Auth::id().'_'.strtotime("now").'.'.$extension;
                Input::file('passport_proof')->move($destinationPath,$name);
                $updatePassport->passport_copy=$destinationPath.$name;
            }
            $updatePassport->save();
            return Redirect::Back()->with('success','Passport Details Updated Successfully');
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!'); 
    }
    public function updateContact(){
        $cre = [
            'address1'=>Input::get('address1'),
            'city'=>Input::get('city'),
            'pincode'=>Input::get('pincode'),
            'address_state_id'=>Input::get('state'),
            'mobile'=>Input::get('mobile'),
            ];
        $rules =  [
            'address1'=>'required',
            'city'=>'required',
            'pincode'=>'required',
            'address_state_id'=>'required',
            'mobile'=>'required',
            ];   
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $updateContact = CoachParameter::where('coach_id',Auth::User()->coach_id)->update(["address1"=>Input::get('address1'),"address2"=>Input::get('address2'),"city"=>Input::get('city'),"pincode"=>Input::get('pincode'),"address_state_id"=>Input::get('state'),"mobile"=>Input::get('mobile'),"landline"=>Input::get('landline'),"alternate_email"=>Input::get('aemail')]);
            return Redirect::Back()->with('success','Contact Details Updated Successfully');
        } 
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');  
    }
    public function employmentDetails(){
        $employment = EmploymentDetails::where('coach_id',Auth::User()->coach_id)->get();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'2']);
        $this->layout->main = View::make('coaches.employments.employment',['employment'=>$employment]);
    }
    public function addNewEmployment(){
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make('coaches.employments.addEmployment');
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
            $employment->start_date = date('Y-m-d',strtotime(Input::get('date_since_emp')));
            $employment->end_date = date('Y-m-d',strtotime(Input::get('end_date')));
            if(Input::hasFile('present_emp_copy')){
                $extension = Input::file('present_emp_copy')->getClientOriginalExtension();
                $doc = "presentemp_".Auth::id().'_'.str_replace(' ','-',Input::file('present_emp_copy')->getClientOriginalName());
                
                Input::file('present_emp_copy')->move($destinationPath,$doc);
                $employment->contract = $destinationPath.$doc;
            }
            $employment->save();
            return Redirect::to('coach/employmentDetails')->with('success','Employment Details Added Successfully');    
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
        
    }
    public function editEmployment($id){
        $employment = EmploymentDetails::find($id);
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>"2"]);
        $this->layout->main =  View::make('coaches.employments.addEmployment',['employment'=>$employment]);
    }
    public function updateEmployment($id){
        $cre = [
            'present_emp'=>Input::get('present_emp'),
            'start_date'=>Input::get('date_since_emp'),
            'end_date'=>Input::get('end_date')
            ];
        $rules = [
            'present_emp'=>'required',
            'start_date'=>'required',
            'end_date'=>'required'
            ];    
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $destinationPath = 'coaches-doc/';
            $updateEmployment = EmploymentDetails::find($id);
            $updateEmployment->employment = Input::get('present_emp');
            $updateEmployment->start_date = date('Y-m-d',strtotime(Input::get('date_since_emp')));
            $updateEmployment->end_date = date('Y-m-d',strtotime(Input::get('end_date')));
            if(Input::hasFile('present_emp_copy')){
                $extension = Input::file('present_emp_copy')->getClientOriginalExtension();
                $doc = "presentemp_".Auth::id().'_'.str_replace(' ','-',Input::file('present_emp_copy')->getClientOriginalName());
                Input::file('present_emp_copy')->move($destinationPath,$doc);
                $updateEmployment->contract = $destinationPath.$doc;
            }
            $updateEmployment->save();            
            return Redirect::back()->with('success','Details Updated Successfully');    
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
    }
    public function deleteEmployment($id){
        $count = EmploymentDetails::where('id',$id)->count();
        if($count<1){
            $data['success'] = false;
            $data['message'] = "Can Not Delete Employment";
        }
        else{
            $delete = EmploymentDetails::find($id)->delete();
            $data['success'] = true;
        }
        return json_encode($data);
    }

    public function coachLicense(){
        $id = Auth::User()->coach_id;
        $coachLicense = CoachLicense::listing()->where('coach_id',$id)->get();
        $licenses = License::licenseList();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>2]);
        $this->layout->main = View::make('coaches.profile',['coachLicense'=>$coachLicense,"profileType"=>6,'title'=>'Coach Licenses',"licenses"=>$licenses]);
    }

    public function addLicense(){
        $cre = ["license_id"=>Input::get("license_id"),"start_date"=>Input::get("start_date"),"number"=>Input::get("number"),"end_date"=>Input::get("end_date")];
        $rules = ["license_id"=>'required',"start_date"=>"required|date","end_date"=>"date|after:start_date","number"=>"required"];
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $coachLicense = new CoachLicense;
            $coachLicense->coach_id = Auth::User()->coach_id;
            $coachLicense->license_id = Input::get("license_id");
            $coachLicense->number = Input::get("number");
            $coachLicense->start_date = date("Y-m-d",strtotime(Input::get("start_date")));
            $coachLicense->end_date = date("Y-m-d",strtotime(Input::get("end_date")));
            $destinationPath = "coach-licenses/";
            if(Input::hasFile('document')){
                $extension = Input::file('document')->getClientOriginalExtension();
                $doc = "dobProof_".Auth::id().'_'.str_replace(' ','-',Input::file('document')->getClientOriginalName());
                Input::file('document')->move($destinationPath,$doc);
                $coachLicense->document = $destinationPath.$doc;
            }
            $coachLicense->save();
            return Redirect::back()->with('success','New license added successfully');

        }
        else{
            return Redirect::back()->withErrors($validator)->withInput()->with('failure','All fields are not properly field');
        }
    }

    public function deleteLicense($coach_license_id){
        $count = CoachLicense::where('coach_id',Auth::User()->coach_id)->where('id',$coach_license_id)->count();
        if($count>0){
            CoachLicense::find($coach_license_id)->delete();
            $data["success"] = true;
            $data["message"] = "License deleted successfully";
        }
        else{
            $data["message"] = "Invalid requerst made || Authentication Problem";
        }
        return json_encode($data);
    }   
}