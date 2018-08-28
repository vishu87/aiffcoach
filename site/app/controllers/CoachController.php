<?php
class CoachController extends BaseController {
    protected $layout = 'layout';
    public function dashboard(){
        
        $courses = array();
        $user_type = explode(',',Auth::user()->official_types);
        $courses_get =  Course::Active()->whereIn('courses.user_type',$user_type)->get();
        
        foreach ($courses_get as $course) {
            $application = Application::where('coach_id',Auth::User()->coach_id)->where('course_id',$course->id)->first();
            if($application){
                $course->application_id = $application->id;
                $course->application_status = $application->status;
            }
            $courses[] = $course;
        }
        
        $coach_employments = EmploymentDetails::where('coach_id',Auth::user()->coach_id)->count();
        
        $coach_licenses = CoachLicense::where('coach_id',Auth::user()->coach_id)->count();
        
        $coach = Coach::find(Auth::user()->coach_id);
        
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>'dashboard']);
        $this->layout->main = View::make('coaches.dashboard',['courses'=>$courses,'title'=>'Active Courses', "coach" => $coach , "coach_employments" => $coach_employments , "coach_licenses" => $coach_licenses]);
    }
    public function contactInformation(){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        $state =[""=>'Select'] + State::orderBy('name','asc')->lists('name','id');
        $CoachParameters = CoachParameter::where('coach_id',Auth::User()->coach_id)->first();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>2]);
        $this->layout->main = View::make('coaches.profile',['state'=>$state,'coach'=>$CoachParameters,"profileType"=>2,'title'=>'Contact Information']);
    }
    
    public function personalInformation(){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        $state = State::states();
        $associations = [""=>"Select"] + DB::table('associations')->lists('association_name','id');
        $CoachParameter = CoachParameter::where('coach_id',Auth::User()->coach_id)->first();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>1]);
        $this->layout->main = View::make('coaches.profile',['coach'=>$coach,'CoachParameter'=>$CoachParameter,"profileType"=>1,'title'=>'Personal Details' , "state" => $state , "associations"=>$associations]);
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
            $coach->association_id = (Input::has('association_id'))?Input::get('association_id'):0;
            $destinationPath = 'coaches-doc/';//folder in root for all uploaded documents
            if(Input::hasFile('photo')){
                $extension = Input::file('photo')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "photo_".Auth::id().'_'.str_replace(' ','-',Input::file('photo')->getClientOriginalName());
                    Input::file('photo')->move($destinationPath,$doc);
                    $coach->photo = $destinationPath.$doc;
                }
            }

            if(Input::hasFile('doctor_degree')){
                $extension = Input::file('doctor_degree')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "Doctor_degree_".strtotime("now").'_'.rand(1,100).'.'.$extension;
                    
                    Input::file('doctor_degree')->move($destinationPath,$doc);
                    $coach->doctor_degree = $destinationPath.$doc;
                }
            }

            if(Input::has('is_doctor') && Input::get('is_doctor') ==1){
                $coach->is_doctor = Input::get('is_doctor');
            }else{
                $coach->is_doctor = 0;
                $coach->doctor_degree = '';
            }

            $coach->state_id = Input::get('state_id');
            
            if(Input::get('state_id') == 37){

                $coach->domicile_state = Input::get('domicile_state');
                $coach->domicile_country = Input::get('domicile_country');
            }else{
                $coach->domicile_state = '';
                $coach->domicile_country = '';
            }   


            $coach->save();
            return Redirect::back()->with('success','Details Updated Successfully');
        }
        else{
            return Redirect::back()->withErrors($validator)->withInput();
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
        $this->layout->main = View::make('coaches.profile',['documents'=>$documents,'document_types'=>$document_types,"profileType"=>5,'title'=>'Documents' , "ApprovalStatus"=>$ApprovalStatus]);
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
        if(Input::get('document') != 2){
            $cre["number"] = Input::get('number');
            $rules["number"] = 'required';
        }

        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $document = new CoachDocument;
            $document->coach_id = $id;
            $document->document_id = Input::get('document');
            $document->number = Input::get('number');
            $document->remarks = Input::get('remarks');
            
            $document->start_date = (Input::get('start_date') != '')?date('Y-m-d',strtotime(Input::get('start_date'))):null;
            $document->expiry_date = (Input::get('expiry') != '')?date('Y-m-d',strtotime(Input::get('expiry'))):null;

            if(Input::has('doc_name')){
                $document->name = Input::get('doc_name');
            }

            $destinationPath= 'coaches-doc/';
            if(Input::hasFile('file')){
                $extension = Input::file('file')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "file_".Auth::id().'_'.strtotime("now").'.'.$extension;
                    Input::file('file')->move($destinationPath,$doc);
                    $document->file = $destinationPath.$doc;
                }
            }
            $document->save();
            return Redirect::back()->with('success','New Documents Added Successfully');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    } 

    public function editDocument($document_id){
        $id = Auth::User()->coach_id;
        $coach = Coach::find($id);
        $ApprovalStatus = Approval::status();
        $documents = CoachDocument::where('coach_id',$id)->get();
        $document_types = [''=>"select"]+CoachDocument::DocTypes();
        $document = CoachDocument::find($document_id);
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>1]);
        $this->layout->main = View::make('coaches.profile',['documents'=>$documents,'document_types'=>$document_types,"profileType"=>5,'title'=>'Documents' , "ApprovalStatus"=>$ApprovalStatus , "document" => $document]);
    }

   public function updateDocument($document_id){
        $document = CoachDocument::find($document_id);
        $cre = [
            "document"=>Input::get('document'),
            
        ];
        $rules = [
            "document"=>'required',
            
        ];
        if(Input::get('document') != 2){
            $cre["number"] = Input::get('number');
            $rules["number"] = 'required';
        }
        if($document->file == ''){
            $cre["file"] = Input::file('file');
            $rules["file"] = "required";
        }
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){

            $document->document_id = Input::get('document');
            $document->number = Input::get('number');
            $document->remarks = Input::get('remarks');
            
            $document->start_date = (Input::get('start_date') != '')?date('Y-m-d',strtotime(Input::get('start_date'))):null;
            $document->expiry_date = (Input::get('expiry') != '')?date('Y-m-d',strtotime(Input::get('expiry'))):null;

            if(Input::has('doc_name')){
                $document->name = Input::get('doc_name');
            }

            $destinationPath= 'coaches-doc/';
            if(Input::hasFile('file')){
                $extension = Input::file('file')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "file_".Auth::id().'_'.strtotime("now").'.'.$extension;
                    Input::file('file')->move($destinationPath,$doc);
                    $document->file = $destinationPath.$doc;
                }
            }
            $document->save();
            return Redirect::to('/coach/addDocument')->with('success','Document Updated Successfully');
        }
        return Redirect::back()->withErrors($validator)->withInput();
    }

    public function deleteDocument($id){

        if(Session::get('privilege') == 2){
            $count = CoachDocument::find($id)->count();
        } else {
            $count = CoachDocument::where('coach_id',Auth::User()->coach_id)->where('id',$id)->count();    
        }

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
                if(in_array($extension, User::fileExtensions())){
    	            $doc = "photo_".Auth::id().'_'.str_replace(' ','-',Input::file('photo')->getClientOriginalName());
    	            Input::file('photo')->move($destinationPath,$doc);
    				$coach->photo = $destinationPath.$doc;
                }
			}
            $coach->save();
            $coach_parameter = new CoachParameter;
            $coach_parameter->coach_id = $coach->id;
            /******upload coach photograph*****/
            if(Input::hasFile('dob_proof')){
                $extension = Input::file('dob_proof')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "dobProof_".Auth::id().'_'.str_replace(' ','-',Input::file('dob_proof')->getClientOriginalName());
                    Input::file('dob_proof')->move($destinationPath,$doc);
                    $coach_parameter->dob_proof = $destinationPath.$doc;
                }
            }
     		/******upload coach passport copy*****/
     		if(Input::hasFile('passport_proof')){
	            $extension = Input::file('passport_proof')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
    	            $doc = "PassportProof_".Auth::id().'_'.str_replace(' ','-',Input::file('passport_proof')->getClientOriginalName());
    	            Input::file('passport_proof')->move($destinationPath,$doc);
    				$coach_parameter->passport_copy = $destinationPath.$doc;
                }
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
                if(in_array($extension, User::fileExtensions())){
                    $name = "PassportProof_".Auth::id().'_'.strtotime("now").'.'.$extension;
                    Input::file('passport_proof')->move($destinationPath,$name);
                    $updatePassport->passport_copy=$destinationPath.$name;
                }
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
            // return Input::get('address_state_id');
            $params = [
                    "address1"=>Input::get('address1'),
                    "address2"=>Input::get('address2'),
                    "city"=>Input::get('city'),
                    "pincode"=>Input::get('pincode'),
                    "address_state_id"=>Input::get('state'),
                    "mobile"=>Input::get('mobile'),
                    "landline"=>Input::get('landline'),
                    "alternate_email"=>Input::get('aemail')
                    ];
            if(Input::get('state') == 37){
                $params = $params + ["address_state" => Input::get("address_state") , "address_country" => Input::get("address_country")];
            }else{
                $params = $params + ["address_state" => '' , "address_country" => ''];
            }
            $updateContact = CoachParameter::where('coach_id',Auth::User()->coach_id)
                ->update($params);
            return Redirect::Back()->with('success','Contact Details Updated Successfully');
        } 
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');  
    }
    public function employmentDetails(){
        $employment = EmploymentDetails::where('coach_id',Auth::User()->coach_id)->get();
        $emp_status = ["" => "Select"] + EmploymentDetails::emp_status();

        $employmentStatus = Approval::status();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'2']);
        $this->layout->main = View::make('coaches.employments.employment',['employment'=>$employment, 'employmentStatus'=>$employmentStatus , 'emp_status' => $emp_status]);
    }
    public function addNewEmployment(){
        $emp_status = ["" => "Select"] + EmploymentDetails::emp_status();
        $this->layout->sidebar = View::make('coaches.sidebar',['sidebar'=>2]);
        $this->layout->main = View::make('coaches.employments.addEmployment',["emp_status" => $emp_status]);
    }
    public function addEmployment(){
        $cre = [
            'employment_status' => Input::get('employment_status'),
            'referral_contact' => Input::get('referral_contact'),
            'referral_name' => Input::get('referral_name'),
            'cv' => Input::file('cv'),
        ];
        $rules = [
            'employment_status' => 'required',
            'referral_contact' => 'required',
            'referral_name' => 'required',
            'cv' => 'required',
        ];     

        if(Input::get('employment_status') != 3){
            $cre = $cre + [
                'present_emp'=>Input::get('present_emp'),
                'start_date'=>Input::get('date_since_emp'),
                'present_emp_copy' => Input::file('present_emp_copy')
            ];
            $rules = $rules + [
                'present_emp'=>'required',
                'start_date'=>'required',
                'present_emp_copy' => 'required'
            ]; 
        }
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $destinationPath = 'coaches-doc/';
            $employment = new EmploymentDetails;
            $employment->coach_id = Auth::User()->coach_id;
            $employment->employment = Input::get('present_emp');
            $employment->emp_status = Input::get('employment_status');
            $employment->referral_name = Input::get('referral_name');
            $employment->referral_contact = Input::get('referral_contact');
            $employment->start_date = (Input::get('date_since_emp') != '') ? date('Y-m-d',strtotime(Input::get('date_since_emp'))) : null;

            $employment->end_date = (Input::get('end_date') != '') ? date('Y-m-d',strtotime(Input::get('end_date'))) : null;

            if(Input::hasFile('present_emp_copy')){
                $extension = Input::file('present_emp_copy')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "presentemp_".Auth::id().'_'.strtotime("now").'.'.$extension;
                    
                    Input::file('present_emp_copy')->move($destinationPath,$doc);
                    $employment->contract = $destinationPath.$doc;
                }
            }

            if(Input::hasFile('cv')){
                $extension = Input::file('cv')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "cv_".Auth::id().'_'.strtotime("now").'.'.$extension;
                    Input::file('cv')->move($destinationPath,$doc);
                    $employment->cv = $destinationPath.$doc;
                }
            }

            $employment->save();
            return Redirect::to('coach/employmentDetails')->with('success','Employment Details Added Successfully');    
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Field!');
        
    }
    public function editEmployment($id){
        $employment = EmploymentDetails::find($id);
        $emp_status = ["" => "Select"] + EmploymentDetails::emp_status();
        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>"2"]);
        $this->layout->main =  View::make('coaches.employments.addEmployment',['employment'=>$employment , "emp_status" => $emp_status]);
    }
    public function updateEmployment($id){
        $cre = [
            'employment_status' => Input::get('employment_status'),
            'referral_contact' => Input::get('referral_contact'),
            'referral_name' => Input::get('referral_name'),
        ];
        $rules = [
            'employment_status' => 'required',
            'referral_contact' => 'required',
            'referral_name' => 'required',
        ];     

        if(Input::get('employment_status') != 3){
            $cre = $cre + [
                'present_emp'=>Input::get('present_emp'),
                'start_date'=>Input::get('date_since_emp'),
                
            ];
            $rules = $rules + [
                'present_emp'=>'required',
                'start_date'=>'required',
                
            ]; 
        }
        $validator = Validator::make($cre,$rules);
        if($validator->passes()){

            $destinationPath = 'coaches-doc/';
            $updateEmployment = EmploymentDetails::find($id);
            $updateEmployment->employment = Input::get('present_emp');
            $updateEmployment->emp_status = Input::get('employment_status');

            $updateEmployment->start_date  = (Input::get('date_since_emp') != '')?date('Y-m-d',strtotime(Input::get('date_since_emp'))):null;

            $updateEmployment->end_date  = (Input::get('end_date') != '')?date('Y-m-d',strtotime(Input::get('end_date'))):null;
            
            if(Input::hasFile('present_emp_copy')){
                $extension = Input::file('present_emp_copy')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "presentemp_".Auth::id().'_'.strtotime("now").'.'.$extension;
                    Input::file('present_emp_copy')->move($destinationPath,$doc);
                    $updateEmployment->contract = $destinationPath.$doc;
                }
            }
            
            if(Input::hasFile('cv')){
                $extension = Input::file('cv')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "cv_".Auth::id().'_'.strtotime("now").'.'.$extension;
                    Input::file('cv')->move($destinationPath,$doc);
                    $updateEmployment->cv = $destinationPath.$doc;
                }
            }

            $updateEmployment->referral_name = Input::get('referral_name');
            $updateEmployment->referral_contact = Input::get('referral_contact');

            $updateEmployment->status = 0;
            
            $updateEmployment->save();  

            return Redirect::back()->with('success','Details Updated Successfully');    
        }
        return Redirect::back()->withErrors($validator)->withInput()->with('failure','All Fields Are Not Filled !');
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

        $sql = License::where('user_type',Auth::user()->official_types)->where('show_dropdown','!=',1);

        $licenseUploaded = [];
        if(sizeof($coachLicense) > 0){
            foreach ($coachLicense as $license) {
                if($license->license_id != 21){
                    array_push($licenseUploaded, $license->license_id);
                }
            }
            if(sizeof($licenseUploaded) > 0){

            $sql = $sql->whereNotIn('id',$licenseUploaded);
            }
        }

        $licenses = $sql->lists('name','id');

        $licenses = ["" => "Select"] + $licenses;

        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>2]);
        $this->layout->main = View::make('coaches.profile',['coachLicense'=>$coachLicense,"profileType"=>6,'title'=>'Licenses',"licenses"=>$licenses]);
    }

    public function addLicense(){
        $cre = ["license_id"=>Input::get("license_id"),"start_date"=>Input::get("start_date"),"number"=>Input::get("number"),"end_date"=>Input::get("end_date")];
        $rules = ["license_id"=>'required',"start_date"=>"required|date","end_date"=>"date|after:start_date","number"=>"required"];

        if(Input::has('recc')){
            $cre["equivalent_license_id"] = Input::get("equivalent_license_id");
            $rules["equivalent_license_id"] = "required";
        }

        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $coachLicense = new CoachLicense;
            $coachLicense->coach_id = Auth::User()->coach_id;
            $coachLicense->license_id = Input::get("license_id");
            $coachLicense->number = Input::get("number");

            $coachLicense->start_date = date("Y-m-d",strtotime(Input::get("start_date")));
            if(Input::get("end_date") != '') $coachLicense->end_date = date("Y-m-d",strtotime(Input::get("end_date")));
            
            $destinationPath = "coach-licenses/";
            if(Input::hasFile('document')){
                $extension = Input::file('document')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "license_".Auth::id().'_'.strtotime("now").'.'.$extension;
                    Input::file('document')->move($destinationPath,$doc);
                    $coachLicense->document = $destinationPath.$doc;
                }
            }
            if(Input::has('recc')){
                $coachLicense->recc = Input::get('recc');
                $coachLicense->equivalent_license_id = Input::get('equivalent_license_id');
                if(Input::hasFile('recc_document')){
                    $extension = Input::file('recc_document')->getClientOriginalExtension();
                    if(in_array($extension, User::fileExtensions())){
                        $doc = "license_recc_".Auth::id().'_'.strtotime("now").'.'.$extension;
                        Input::file('recc_document')->move($destinationPath,$doc);
                        $coachLicense->recc_document = $destinationPath.$doc;
                    }
                }
            }
            $coachLicense->save();
            return Redirect::back()->with('success','New license added successfully');

        }
        else{
            return Redirect::back()->withErrors($validator)->withInput()->with('failure','All fields are not properly field');
        }
    }

    public function editLicense($license_id){
        $id = Auth::User()->coach_id;
        $coachLicense = CoachLicense::listing()->where('coach_id',$id)->get();
        $license = CoachLicense::find($license_id);

        $licenses = License::where('user_type',Auth::user()->official_types)->lists('name','id');

        $licenses = ["" => "Select"] + $licenses;

        $this->layout->sidebar = View::make('coaches.sidebar',["sidebar"=>'profile','subsidebar'=>2]);
        $this->layout->main = View::make('coaches.profile',['coachLicense'=>$coachLicense,"profileType"=>6,'title'=>'Licenses',"licenses"=>$licenses ,"license"=>$license]);
    }

    public function updateLicense($license_id){
        $cre = ["start_date"=>Input::get("start_date"),"number"=>Input::get("number"),"end_date"=>Input::get("end_date")];
        $rules = ["start_date"=>"required|date","end_date"=>"date|after:start_date","number"=>"required"];

        if(Input::has('recc')){
            $cre["equivalent_license_id"] = Input::get("equivalent_license_id");
            $rules["equivalent_license_id"] = "required";
        }

        $validator = Validator::make($cre,$rules);
        if($validator->passes()){
            $coachLicense = CoachLicense::find($license_id);

            $coachLicense->number = Input::get("number");
            $coachLicense->status = 0;

            $coachLicense->start_date = date("Y-m-d",strtotime(Input::get("start_date")));
            if(Input::get("end_date") != '') $coachLicense->end_date = date("Y-m-d",strtotime(Input::get("end_date")));
            
            $destinationPath = "coach-licenses/";
            if(Input::hasFile('document')){
                $extension = Input::file('document')->getClientOriginalExtension();
                if(in_array($extension, User::fileExtensions())){
                    $doc = "license_".Auth::id().'_'.strtotime("now").'.'.$extension;
                    Input::file('document')->move($destinationPath,$doc);
                    $coachLicense->document = $destinationPath.$doc;
                }
            }
            if(Input::has('recc')){
                $coachLicense->recc = Input::get('recc');
                $coachLicense->equivalent_license_id = Input::get('equivalent_license_id');
                if(Input::hasFile('recc_document')){
                    $extension = Input::file('recc_document')->getClientOriginalExtension();
                    if(in_array($extension, User::fileExtensions())){
                        $doc = "license_recc_".Auth::id().'_'.strtotime("now").'.'.$extension;
                        Input::file('recc_document')->move($destinationPath,$doc);
                        $coachLicense->recc_document = $destinationPath.$doc;
                    }
                }
            }else{
                $coachLicense->recc = 0;
                $coachLicense->equivalent_license_id = 0;
            }
            $coachLicense->save();
            return Redirect::to('/coach/coachLicense')->with('success','license updated successfully');

        }
        else{
            return Redirect::back()->withErrors($validator)->withInput()->with('failure','All fields are not properly field');
        }
    }

    public function deleteLicense($coach_license_id){
        if(Session::get('privilege') == 2){
            $count = CoachLicense::find($coach_license_id)->count();
        } else {
            $count = CoachLicense::where('coach_id',Auth::User()->coach_id)->where('id',$coach_license_id)->count();    
        }
        
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

    public function viewAllCoaches(){
        
        $sql = Coach::listing()->approved()->where('users.official_types',1);
        

        if(Input::get("registration_id") != ''){
          $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
        }

        if(Input::get("official_name") != ''){
          $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
        }

        if(Input::get("gender") != ''){
          $sql = $sql->where('coaches.gender',Input::get('gender'));
        }


        if(Input::get("license_id") != ''){
          $sql = $sql->addSelect('license.name as latest_license','license.id as license_id','coach_licenses.recc','coach_licenses.equivalent_license_id')
            ->join('coach_licenses','coach_licenses.coach_id','=','coaches.id')
            ->join('license','coach_licenses.license_id','=','license.id')
            ->orderBy('coach_licenses.start_date','desc')
            ->where('coach_licenses.license_id','=',Input::get('license_id'));
            // ->orWhere('coach_licenses.equivalent_license_id','=',Input::get('license_id'));
        }

        if(Input::get("state_id") != ''){
          $sql = $sql->where('coaches.state_id',Input::get('state_id'));
        }
        $exportCoaches = $sql->get();
        $total = $sql->count();

        $max_per_page = 100;

        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
          $page_id = Input::get('page');
        } else {
          $page_id = 1;
        }

        $input_string = 'view-all-coaches?';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $input_string .= ($count_string == 0)?'':'&';
            $input_string .= $key.'='.$value;
            $count_string++;
          }
        }
        
        $coaches = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->groupBy('coaches.id')->get();
        $status = Coach::Status();
        $licenses = License::licenseList();
        $states = State::states();
        // return $coaches;
        $coach_licenses_sql = CoachLicense::select('coach_licenses.coach_id','coach_licenses.start_date','coach_licenses.license_id','license.name as license_name','coach_licenses.equivalent_license_id','coach_licenses.recc')
            ->join('license','license.id','=','coach_licenses.license_id');

        if(Input::has('license_id') && Input::get("license_id") != ''){
          $coach_licenses_sql = $coach_licenses_sql->where('coach_licenses.license_id','!=',Input::get('license_id'));
        }
        if(Input::has('license_id') && Input::get("license_id") != '' && Input::get('license_id') == 21){
            $coach_licenses_sql = $coach_licenses_sql->orWhere('coach_licenses.license_id','=',Input::get('license_id'));
        }
        $coach_licenses = $coach_licenses_sql->where('status',1)->orderBy('start_date','desc')->get();

        $latest_license = [];

        foreach ($coach_licenses as $license) {

            if(!isset($latest_license[$license->coach_id]))$latest_license[$license->coach_id] = array();

            if(Input::has('license_id') && Input::get('license_id') != $license->equivalent_license_id ){

                if($license->recc == 1){
                    if(isset($licenses[$license->equivalent_license_id])){

                        array_push($latest_license[$license->coach_id], $license->license_name.' ( '.$licenses[$license->equivalent_license_id].' ) ');
                    }
                }else{

                    array_push($latest_license[$license->coach_id], $license->license_name);
                }
            }else{
                array_push($latest_license[$license->coach_id], $license->license_name);
            }
        }

        $coach_emps = EmploymentDetails::select('coach_id','employment')->where('status',1)->orderBy('start_date','desc')->get();

        $latest_emps = [];

        foreach ($coach_emps as $emps) {
            if(!isset($latest_emps[$emps->coach_id]))
                $latest_emps[$emps->coach_id] = $emps->employment;
        }

        if(Input::has('export_excel') && Input::get('export_excel')){
            $coaches = $exportCoaches;
            if(sizeof($coaches)>0){
                include(app_path().'/libraries/Classes/PHPExcel.php');
                include(app_path().'/libraries/export/export-all-coaches.php'); 
            } else {
                return Redirect::back()->with('failure','No data found to export');
            }
        }
        
        
        return View::make('coaches',['coaches'=>$coaches,"title"=>'Registered Coaches', "status" => $status,'flag'=>1,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string , "licenses" => $licenses , "states" => $states , "latest_license" => $latest_license , "latest_emps" => $latest_emps]);
    }
}