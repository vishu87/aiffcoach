<?php

class AdminController extends BaseController {
  protected $layout = 'layout';

  public function removeSpace(){
    $coaches = Coach::select("full_name","id")->get();
    foreach ($coaches as $coach) {
      $full_name = $coach->full_name ;
      $full_name = str_replace("  "," ",$full_name);
      if($full_name != $coach->full_name){
        echo $coach->full_name." updated<br>";
      }
      Coach::where('id',$coach->id)->update(["full_name"=>$full_name]); 
    }
    die();
    
  }
  
  public function index(){
    
    $approved_officials = Coach::listing()->approved()->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->count();

    $pending_officials = Coach::listing()->pending()->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->count();
    $active_courses =  Course::Active()->where('courses.user_type',Auth::user()->manage_official_type)->count();
    $all_courses = Course::select('courses.*','license.name as license_name','license.authorised_by')
      ->join('license','courses.license_id','=','license.id')
      ->where('courses.user_type',Auth::user()->manage_official_type)
      ->count();

    $approved_applications =   Application::applications()->where('courses.user_type',Auth::user()->manage_official_type)->where('applications.status',2)->count();

    $pending_applications =   Application::applications()->where('courses.user_type',Auth::user()->manage_official_type)->where('applications.status',0)->count();
    
    $payment_under_approval =   Application::applicationsWithPayments()->where('courses.user_type',Auth::user()->manage_official_type)->where('applications.status',2)->where('payment.status',0)->where('payment.amount','!=',0)->count();

    $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'dashboard','subsidebar'=>1]);
    
    $this->layout->main = View::make('admin.index',["approved_officials" => $approved_officials, "pending_officials" => $pending_officials, "active_courses" => $active_courses,"all_courses" => $all_courses, "approved_applications" => $approved_applications, "pending_applications" => $pending_applications, "payment_under_approval" => $payment_under_approval,]);
  }

  public function get_sidebar(){
    if(Session::get('privilege') == 2){
      return 'admin.sidebar';
    }
    else if(Session::get('privilege') == 4){
      return 'superAdmin.sidebar';
    } else {
      return '';
    }
  }

  public function coachEmployments(){
    $current_season = 2;
    $designations = [
      "1"=>"Certified Head of Youth Development",
      "2"=>"Certified Head Coach - Elite Youth Age-Groups",
      "3"=>"Certified Assistant Coach - Elite Youth Age-Groups",
      "4"=>"Certified Grassroot Leaders/Grassroot Coaches - Children's Age-groups",
      "5"=>"Dedicated Certified Goalkeeping Coaches",
      "6"=>"Certified Physiotherapist #1",
      "7"=>"Certified Physiotherapist #2",
      "8"=>"Certified Physiotherapist #3",
      "9"=>"Doctor",
    ];

    $sql = DB::connection('mysql_teams')->table('club_coaches')->select('club_coaches.season_id','club_coaches.coach_id','club_coaches.designation_id','club_coaches.contract','Club.ClubName as club_name')->leftJoin('Club','Club.ClubId','=','club_coaches.club_id')
      ->where('club_coaches.session_id',$current_season)->orderBy('Club.ClubName');

    $total = $sql->count();
    $max_per_page = 100;
    $total_pages = ceil($total/$max_per_page);
    if(Input::has('page')){
      $page_id = Input::get('page');
    } else {
      $page_id = 1;
    }

    $input_string = 'admin/coach-employments?';
    $count_string = 0;
    foreach (Input::all() as $key => $value) {
      if($key != 'page'){
        $input_string .= ($count_string == 0)?'':'&';
        $input_string .= $key.'='.$value;
        $count_string++;
      }
    }

    if(Input::has('exportExcel') && Input::get('exportExcel') == 1){

      $coaches = $sql->get();
    }else{

      $coaches = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
    }


    foreach ($coaches as $coach) {
      $coachdetail = Coach::select('coaches.full_name','coaches.registration_id','coach_parameters.email')->where('coaches.id',$coach->coach_id)->leftJoin('coach_parameters','coach_parameters.coach_id','=','coaches.id')->first();
      $coach->full_name = $coachdetail->full_name;
      $coach->registration_id = $coachdetail->registration_id;
      $coach->email = $coachdetail->email;

      $coach->hyperlink = ($coach->contract != '')?url($coach->contract):'';

      $employments  = EmploymentDetails::where('coach_id',$coach->coach_id)->where('status',1)->lists('employment');
      $coach->employments = implode(' , ',$employments);
      $coach->designation = (isset($designations[$coach->designation_id]))?$designations[$coach->designation_id]:'';
      
    } 
    // return $coaches;
    if(Input::has('exportExcel') && Input::get('exportExcel') == 1){

      if(sizeof($coaches) > 0){
        include(app_path().'/libraries/Classes/PHPExcel.php');
        include(app_path().'/libraries/export/export-employments.php');
      }else{
        return Redirect::back()->with('failure','No data found to export');
      }
    }

    $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach-employments','subsidebar'=>0]);
    
    $this->layout->main = View::make('admin.coaches.employments',["coaches"=>$coaches,'flag'=>1,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string ]);
  }

  public function approvedCoach(){

    if(Session::get('privilege') == 4){
  	  $sql = Coach::listing()->approved();
    } else {
      $sql = Coach::listing()->approved()->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%');
    }

    if(Input::get("registration_id") != ''){
      $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
    }

    if(Input::get("license_id") != ''){
      $sql = $sql->join('coach_licenses','coach_licenses.coach_id','=','coaches.id')->where('coach_licenses.license_id','=',Input::get('license_id'));
    }

    if(Input::get("official_name") != ''){
      $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
    }

    if(Input::get("state_id") != ''){
      $sql = $sql->where('coaches.state_id',Input::get('state_id'));
    }

    $total = $sql->count();
    $max_per_page = 100;
    $total_pages = ceil($total/$max_per_page);
    if(Input::has('page')){
      $page_id = Input::get('page');
    } else {
      $page_id = 1;
    }

    $input_string = 'admin/approvedCoach?';
    $count_string = 0;
    foreach (Input::all() as $key => $value) {
      if($key != 'page'){
        $input_string .= ($count_string == 0)?'':'&';
        $input_string .= $key.'='.$value;
        $count_string++;
      }
    }
    
    $coaches = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
    $status = Coach::Status();

    $sidebar_file = $this->get_sidebar();

    $licenses = License::licenseList();
    $states = State::states();

    $this->layout->sidebar = View::make($sidebar_file,['sidebar'=>'coach','subsidebar'=>1]);
    $this->layout->main = View::make('admin.coaches.list',['coaches'=>$coaches,"title"=>'Approved Coaches', "status" => $status,'flag'=>1,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string , "licenses" => $licenses , "states" => $states]);
  }

  public function pendingCoach(){

    $pending_type = 0;

    if(Input::has('pending_type')){
      $pending_type = Input::get('pending_type');
    }

    if(Session::get('privilege') == 4){
      $sql = Coach::listing()->where('coaches.status', $pending_type);
    } else {
      $sql = Coach::listing()->where('coaches.status', $pending_type)->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%');
    }

    if(Input::get("registration_id") != ''){
      $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
    }

    if(Input::get("license_id") != ''){
      $sql = $sql->join('coach_licenses','coach_licenses.coach_id','=','coaches.id')->where('coach_licenses.license_id','=',Input::get('license_id'));
    }

    if(Input::get("official_name") != ''){
      $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
    }

    if(Input::get("state_id") != ''){
      $sql = $sql->where('coaches.state_id',Input::get('state_id'));
    }

    $total = $sql->count();
    $max_per_page = 100;
    $total_pages = ceil($total/$max_per_page);
    if(Input::has('page')){
      $page_id = Input::get('page');
    } else {
      $page_id = 1;
    }

    $input_string = 'admin/pendingCoach?';
    $count_string = 0;
    foreach (Input::all() as $key => $value) {
      if($key != 'page'){
        $input_string .= ($count_string == 0)?'':'&';
        $input_string .= $key.'='.$value;
        $count_string++;
      }
    }

    $coaches = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
    $status = Coach::Status();

    $licenses = License::licenseList();
    $states = State::states();
    
    $this->layout->sidebar = View::make($this->get_sidebar(),['sidebar'=>'coach','subsidebar'=>2]);
    $this->layout->main = View::make('admin.coaches.list',['coaches'=>$coaches,"title"=>'Coaches Under Process', "status" => $status,'flag'=>2,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string ,"pending_type" => $pending_type, "licenses" => $licenses , "states" => $states]);
  }

  public function deleteCoachProfile($coach_id){
    $deleteCoach = Coach::find($coach_id);
    $deleteCoach->delete();
    
    User::where('coach_id',$coach_id)->delete();

    Application::where('coach_id',$coach_id)->delete();
    CoachActivity::where('coach_id',$coach_id)->delete();
    CoachDocument::where('coach_id',$coach_id)->delete();
    CoachLicense::where('coach_id',$coach_id)->delete();
    CoachParameter::where('coach_id',$coach_id)->delete();

    $data['success'] = true;
    $data['message'] = "Coach Deleted successfully";

    return json_encode($data);
  }

  public function checkDuplicate($coach_id){

    $coach = Coach::select('coaches.first_name','coaches.middle_name','coaches.last_name','coaches.full_name','coaches.id','coaches.dob','coach_parameters.email','coach_parameters.mobile', 'coaches.status')
      ->leftJoin('coach_parameters','coach_parameters.coach_id','=','coaches.id')->where('coaches.id',$coach_id)->first();

    $first_names = explode(',', $coach->first_name);
    $coach->first_name_one = $first_names[0];

    $match_ids = Coach::where(function($query) use ($coach){
      $query->where('coaches.first_name','=',$coach->first_name)->orWhere('coaches.full_name','=',$coach->full_name)->orWhere('coaches.first_name','=',$coach->first_name." ".$coach->middle_name)->orWhere('coaches.full_name','=',$coach->first_name." ".$coach->middle_name." ".$coach->last_name)->orWhere('coaches.first_name','LIKE','%'.$coach->first_name_one);
    })->where('coaches.dob',$coach->dob)->where('coaches.id','!=',$coach_id)->lists('id');

    if(sizeof($match_ids) < 1){
      $match_ids = CoachParameter::where(function($query) use ($coach){
        $query->where('coach_parameters.email',$coach->email);
      })->where('coach_parameters.coach_id','!=',$coach_id)->lists('coach_id');
    }

    if(sizeof($match_ids) > 0){
      $coaches = Coach::select('coaches.full_name','coaches.registration_id','coaches.dob','coaches.photo','coaches.id','coaches.dob','coach_parameters.email','coach_parameters.mobile' , 'coaches.status')
      ->leftJoin('coach_parameters','coach_parameters.coach_id','=','coaches.id')->whereIn('coaches.id',$match_ids)->get();
    }else{
      $coaches = [];
    }

    $status = Coach::status();
    return View::make('admin.coaches.duplicate',["coaches"=>$coaches , "status" => $status]);

  }
  
  public function viewCoachDetails($id){
    $coach = Coach::select('coaches.*','states.name as state_registation','coach_parameters.email','coach_parameters.address1','coach_parameters.address2','coach_parameters.city','coach_parameters.pincode','coach_parameters.mobile')->leftJoin('states','coaches.state_id','=','states.id')->join('coach_parameters','coaches.id','=','coach_parameters.coach_id')->where('coaches.id',$id)->first();
    // return $coach;
    $documents = CoachDocument::select('coach_documents.*','documents.name as document_name')->leftJoin('documents','coach_documents.document_id','=','documents.id')->where('coach_id',$id)->get();

    $coachLicense = CoachLicense::listing()->where('coach_id',$id)->get();
    // return $coachLicense;
    $employmentDetails = EmploymentDetails::where('coach_id',$id)->get();
    $activities = CoachActivity::where('coach_id',$id)->get();
    $courses = Application::select('applications.*','courses.name as course_name','courses.venue')->join('courses','applications.course_id','=','courses.id')->where('coach_id',$id)->get();
    $coachStatus = Coach::status();
    $licenseList = License::lists('name','id');
    $ApprovalStatus = Approval::status();

    if(Auth::user()->privilege == 4){
      $this->layout->sidebar = View::make('superAdmin.sidebar',['sidebar'=>'coach','subsidebar'=>2]);
    }else{

      $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>2]);
    }
    $this->layout->main = View::make('admin.coaches.profile',['coach' => $coach, 'employmentDetails' => $employmentDetails, "documents" => $documents, "activities" => $activities, "courses" => $courses, "licenseList" => $licenseList, "coachStatus" => $coachStatus, "coachLicense" => $coachLicense, 'ApprovalStatus' => $ApprovalStatus]);
  }

  public function deleteCoachEmployment($employment_id){
    $employmentDetails = EmploymentDetails::find($employment_id);
    if($employmentDetails){
      $employmentDetails->delete();
      $data['success'] = true;
      $data['message'] = 'employment is removed successfully';
    }else{
      $data['success'] = false;
      $data['message'] = 'Employment Details does not exist please try again ';
    }
    return json_encode($data);
  }

  public function editCoachProfile($coach_id){
    $coach = Coach::select('coaches.*','states.name as state_registation','coach_parameters.email','coach_parameters.address1','coach_parameters.address2','coach_parameters.city','coach_parameters.pincode','coach_parameters.mobile')->leftJoin('states','coaches.state_id','=','states.id')->join('coach_parameters','coaches.id','=','coach_parameters.coach_id')->where('coaches.id',$coach_id)->first();
    $officialTypes = User::OfficialTypes();
    $selectedOfficialTypes = User::where('coach_id',$coach_id)->first();
    if($selectedOfficialTypes->official_types != ''){
      $selectedOfficialTypes = explode(',',$selectedOfficialTypes->official_types);
    } else {
      $selectedOfficialTypes = [];
    }
    $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
    $this->layout->main = View::make('admin.coaches.editProfile',["coach" => $coach, "officialTypes" => $officialTypes, "selectedOfficialTypes" => $selectedOfficialTypes]);
  }

  public function updateCoachProfile($coach_id){
    $coach = User::select('id as user_id')->where('coach_id',$coach_id)->first();
    $cre = ["full_name"=>Input::get('full_name'),'email'=>Input::get('email'),'gender'=>Input::get('gender'),'dob'=>Input::get('dob')];
    $rules = ["full_name"=>'required','email'=>'required|email|unique:users,username,'.$coach->user_id,'gender'=>'required','dob'=>'required'];
    $validator = Validator::make($cre,$rules);
    if($validator->passes()){
      $coach = Coach::find($coach_id);
      $coach->full_name = ucwords(strtolower(Input::get('full_name')));
      $coach->dob = date('Y-m-d',strtotime(Input::get('dob')));
      $coach->gender = Input::get('gender');
      $destinationPath = 'coaches-doc/';
      if(Input::hasFile('photo')){
        $extension = Input::file('photo')->getClientOriginalExtension();
        if(in_array($extension, User::fileExtensions())){
          $doc = "photo_".str_replace(' ','-',Input::file('photo')->getClientOriginalName());
          Input::file('photo')->move($destinationPath,$doc);
          $coach->photo = $destinationPath.$doc;
        }
      }
      $coach->save();
      $coach_parameters = CoachParameter::where('coach_id',$coach_id)->update(["email"=>Input::get('email'),'mobile'=>Input::get('mobile')]);
      if(Input::has('official_types')){
        $official_types = implode(',',Input::get('official_types'));
        $user = User::where('coach_id',$coach_id)->update(["official_types"=>$official_types]);
      }

      return Redirect::to('admin/viewCoachDetails/'.$coach_id)->with('success','profile updated successfully');

    }
    else{
      return Redirect::back()->withErrors($validator)->withInput()->with('failure','All fields are not field');
    }
  }  
  
  public function ApplicationsResults(){
    $status = Application::status();
    $courses[""] = "All Courses";
    $courses_get = Course::where('user_type',Auth::user()->manage_official_type)->orderBy('start_date')->get();

    foreach ($courses_get as $course) {
        $courses[$course->id] = $course->name.', '.$course->venue.', '.date("d-m-Y", strtotime($course->start_date));
    }
    if(Input::has('course')){
      $sql = Application::select('courses.name as course_name','courses.id as course_id','applications.id','applications.status','coaches.full_name','license.name as license_name','application_result.status as finalResult','application_result.remarks')
        ->join('coaches','applications.coach_id','=','coaches.id')
        ->join('users','applications.coach_id','=','users.coach_id')
        ->leftJoin('courses','applications.course_id','=','courses.id')
        ->leftJoin('license','courses.license_id','=','license.id')
        ->leftJoin('application_result','applications.id','=','application_result.application_id')
        ->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')
        ->where('applications.status',3)
        ->where('applications.course_id',Input::get('course'));
      $resultStatus = Result::status();
    }else{
      $sql = Application::select('courses.name as course_name','courses.id as course_id','applications.id','applications.status','coaches.full_name','license.name as license_name','application_result.status as finalResult','application_result.remarks')
        ->join('coaches','applications.coach_id','=','coaches.id')
        ->join('users','applications.coach_id','=','users.coach_id')
        ->join('courses','applications.course_id','=','courses.id')
        ->leftJoin('license','courses.license_id','=','license.id')
        ->leftJoin('application_result','applications.id','=','application_result.application_id')
        ->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')
        ->where('applications.status',3);
      $resultStatus = Result::status();
      // $applications = Application::applications()->where('applications.status',3)->get();
    }
    if(Input::has('course')){
      if(Input::get('course') != '' && Input::get('course') != 0){
        $sql = $sql->where('applications.course_id',Input::get('course'));
      }
    }
    $input_string = 'admin/ApplicationResults?';
    $total = $sql->count();
    $max_per_page =50;
    $total_pages = ceil($total/$max_per_page);
    if(Input::has('page')){
      $page_id = Input::get('page');
    } else {
      $page_id = 1;
    }
    $count_string = 0;
    foreach (Input::all() as $key => $value) {
      if($key != 'page'){
        $input_string .= ($count_string == 0)?'':'&';
        $input_string .= $key.'='.$value;
        $count_string++;
      }
    }

    $applications = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();

    $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'results']);
    $this->layout->main = View::make('resultAdmin.applications.index',['status'=>$status,"applications"=>$applications,'title'=>'Applications Results','flag'=>1, "courses" => $courses,'resultStatus'=>$resultStatus ,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string]);
  }  

  public function editParameterMarks($application_id){
    $course = Application::select('license.id as license_id')->join('courses','applications.course_id','=','courses.id')->join('license','courses.license_id','=','license.id')->where('applications.id',$application_id)->first();
    $parameters = CourseParameter::select('parameters.parameter','parameters.max_marks','courses_parameter.parameter_id')
      ->join('parameters','courses_parameter.parameter_id','=','parameters.id')
      ->where('license_id',$course->license_id)
      ->where('courses_parameter.active',0)
      ->get();
    $results = Result::where('application_id',$application_id)->lists('marks','parameter_id');
    $status = Result::status();
    $finalResult = ApplicationResult::where('application_id',$application_id)->first();
    $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'results']);
    $this->layout->main = View::make('resultAdmin.result.view',["application_id"=>$application_id,'parameters'=>$parameters,"results"=>$results,'application_id'=>$application_id,'status'=>$status,"finalResult"=>$finalResult]);
  }

  public function ViewApplicationsResult($application_id){
    $checkApp = ApplicationResult::where('application_id',$application_id)->count();
    if ($checkApp>0) {
      $course = Application::select('license.id as license_id')->join('courses','applications.course_id','=','courses.id')->join('license','courses.license_id','=','license.id')->where('applications.id',$application_id)->first();
      $parameters = CourseParameter::select('parameters.parameter','parameters.max_marks','courses_parameter.parameter_id')
        ->join('parameters','courses_parameter.parameter_id','=','parameters.id')
        ->where('license_id',$course->license_id)
        ->where('courses_parameter.active',0)
        ->get();
      $resultStatus = Result::status();
      $results = Result::where('application_id',$application_id)->get();
      $applicationStatus = ApplicationResult::where('application_id',$application_id)->first();
      return View::make('resultAdmin.result.list',['parameters'=>$parameters,'application_id'=>$application_id,"results"=>$results,"applicationStatus"=>$applicationStatus,"resultStatus"=>$resultStatus]);
    }
    else{
      return "<span style='color:red'>Result for this application is pending / Result Not found</span>";
    }  
  }

  public function uploadLicense($application_id){
    $coach = Application::select('applications.coach_id','applications.course_id','coaches.full_name','coaches.id','license.name as license_name','courses.license_id')->join('courses','courses.id','=','applications.course_id')->leftJoin('license','courses.license_id','=','license.id')->join('coaches','applications.coach_id','=','coaches.id')->join('users','users.coach_id','=','applications.coach_id')->where('applications.id',$application_id)->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->first();
    $checkLicense = CoachLicense::where('coach_id',$coach->id)->where('course_id',$coach->course_id)->count();
    $coachLicense = CoachLicense::listing()->where('coach_id',$coach->coach_id)->get(); 
    if($checkLicense>0){
      $editLicense = CoachLicense::where('coach_id',$coach->id)->where('course_id',$coach->course_id)->first();
      $parameters = ["coach"=>$coach,"coachLicense"=>$coachLicense,"editLicense"=>$editLicense];
    }
    else{
      $parameters = ["coach"=>$coach,"coachLicense"=>$coachLicense];
    }
    $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'results']);
    $this->layout->main = View::make('resultAdmin.result.uploadLicense',$parameters);
  }

  public function storeLicense($coach_id){
    $cre = ["start_date"=>Input::get("start_date"),"number"=>Input::get("number"),"end_date"=>Input::get("end_date")];
    $rules = ["start_date"=>"required|date","end_date"=>"date|after:start_date","number"=>"required"];
    $validator = Validator::make($cre,$rules);
    if($validator->passes()){
      $checkLicense = CoachLicense::where('coach_id',$coach_id)->where('course_id',Input::get('course_id'))->count();
      if($checkLicense>0){
        $editLicense = CoachLicense::where('coach_id',$coach_id)->where('course_id',Input::get('course_id'))->first();
        $coachLicense = CoachLicense::find($editLicense->id);
      }
      else{
        $coachLicense = new CoachLicense;
      }
      
      $coachLicense->coach_id = $coach_id;
      if(Input::has('course_id')){
        $coachLicense->course_id = Input::get('course_id');
      }
      $coachLicense->license_id = Input::get("license_id");
      $coachLicense->number = Input::get("number");
      $coachLicense->start_date = date("Y-m-d",strtotime(Input::get("start_date")));
      $coachLicense->end_date = date("Y-m-d",strtotime(Input::get("end_date")));
      $destinationPath = "coach-licenses/";
      if(Input::hasFile('document')){
        $extension = Input::file('document')->getClientOriginalExtension();
        if(in_array($extension, User::fileExtensions())){
          $doc = "dobProof_".Auth::id().'_'.str_replace(' ','-',Input::file('document')->getClientOriginalName());
          Input::file('document')->move($destinationPath,$doc);
          $coachLicense->document = $destinationPath.$doc;
        }
      }
      $coachLicense->save();
      return Redirect::back()->with('success','License added successfully');
    }
    else{
      return Redirect::back()->withErrors($validator)->withInput()->with('failure','All fields are not properly field');
    }
  }

  public function deleteLicense($license_id){
    $check = CoachLicense::where('id',$license_id)->count();
    if($check>0){
      CoachLicense::find($license_id)->delete();
      $data["success"] = true;
      $data["message"] = "License deleted successfully";
    }
    else{
      $data["message"] = "No license found to delete";
    }
    return json_encode($data);
  }

  public function editRemark($approval_log_id){
    $log = Approval::find($approval_log_id);
    $data = html_entity_decode(View::make('admin.coaches.editRemark',["log"=>$log , "flag"=>false]));
    return $data;
  }

  public function updateRemark($approval_log_id){
    $log = Approval::find($approval_log_id);
    $log->remarks = Input::get('remarks');
    $log->save();
    $log_data = Approval::select('approval.*','users.name as user_name', 'users.privilege')->join('users','users.id','=','approval.user_id')->where('approval.id',$approval_log_id)->first();
    $data['success'] = true;
    $data['message'] = html_entity_decode(View::make('admin.coaches.editRemark',['log_data'=>$log_data ,'flag'=>1 , "count" => Input::get('count')]));
    return json_encode($data);
  }

  public function deleteRemark($approval_log_id){
    $deleteRemark = Approval::find($approval_log_id)->delete();
    if($deleteRemark){
      $data['success'] = true;
      $data['message'] = 'Remark Deleted Successfully';
    }else{
      $data['success'] = false;
      $data['message'] = 'Remark no longer exist';
    }
    return json_encode($data);
  }

  public function logins(){
    $users = User::select('id','name','username','mobile')->where('privilege',1)->orderBy('name','ASC')->get();
    
    $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'logins']);
    $this->layout->main = View::make('admin.logins.list',["users" => $users]);
  }

  public function loginByUser($user_id){
    Auth::loginUsingId($user_id);
    Session::put('privilege', Auth::user()->privilege);
    return Redirect::to('/coach/dashboard');
  }

  public function changeOfficialType($user_id){
    $user = User::find($user_id);
    $current_user_types = explode(',',$user->official_types);
    return View::make('admin.logins.change-official-type',["user_id" => $user_id,"current_user_types"=>$current_user_types]);
  }

  public function updateOfficialType($user_id){
    $official_types = Input::get('official_types');
    if(sizeof($official_types) >0){
      $user = User::find($user_id);
      $user->official_types = implode(',',$official_types);
      $user->save();
      $data['success'] = true;
      $data['confirm'] = true;
      $data['message'] = "User official types are updated successfully";
    }else{
      $data['success'] = false;
      $data['message'] = 'Select at least 1 user type';
    }
    return json_encode($data);
  }

  public function changeEmail($user_id){
    $user = User::find($user_id);
    $current_user_types = explode(',',$user->official_types);
    return View::make('admin.logins.update-email',["user_id" => $user_id,"user"=>$user]);
  }

  public function updateEmail($user_id){
    $email = Input::get('email');
    if($email){
      $user = User::find($user_id);
      $user->username = $email;
      $user->save();
      $coach_parameter = CoachParameter::where('coach_id',$user->coach_id)->update(["email"=>$email]);
      $data['success'] = true;
      // $data['confirm'] = true;
      $data['message'] = html_entity_decode(View::make('admin.logins.view',["count"=>Input::get("count"), "data"=>$user]));
    }else{
      $data['success'] = false;
      $data['message'] = 'Email can not be left blank';
    }
    return json_encode($data);
  }

  public function resetUserPassword($user_id){
    return View::make('admin.logins.reset-password',["user_id" => $user_id]);
  }

  public function changeUserPassword($user_id){
    $cre = ["new_pwd"=>Input::get('new_pwd'),"con_pwd"=>Input::get('con_pwd')];

    $rules = ["new_pwd"=>'required|min:5',"con_pwd"=>'required'];

    $validator = Validator::make($cre,$rules);

    if($validator->passes()){

      if(Input::get('new_pwd') === Input::get('con_pwd')){
        $user = User::find($user_id);
        $user->password_check = Input::get("new_pwd");
        $user->password = Hash::make(Input::get('new_pwd'));
        $user->save();
        $data['success'] = true;
        $data['confirm'] = true;
        $data['message'] = "Password Updated Successfully";
      }else{
        $data['success'] = false;
        $data['confirm'] = false;
        $data['message'] = "New Password and Confirm Password does not match";
      }

    }else{
      $data['success'] = false;
      $data['confirm'] = false;
      $messages = $validator->messages();
      foreach($messages->all() as $message){
        $data["message"] = $message;
        break;
      }
    }
    return json_encode($data);
  }


}