<?php
class ApprovalController extends BaseController {
    protected $layout = 'layout';

    // public function correctData($document_id){
    //     $document = CoachDocument::find($document_id);
    //     if(Input::get('start_date')){
    //         $document->start_date = date('Y-m-d',strtotime(Input::get('start_date')));
    //     }
    //     if(Input::get('expiry_date')){
    //         $document->expiry_date = date('Y-m-d',strtotime(Input::get('expiry_date')));
    //     }
    //     $document->save();
    //     return Redirect::back();
    // }

    public function pendingDocument(){
        $sql = CoachDocument::select('coach_documents.*','documents.name as document_name','coaches.full_name')->leftJoin('documents','coach_documents.document_id','=','documents.id')->leftJoin('coaches','coach_documents.coach_id','=','coaches.id')->join('users','users.coach_id','=','coach_documents.coach_id')->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->where('coach_documents.status',0);

        // $sql = CoachDocument::select('coach_documents.*','documents.name as document_name','coaches.full_name')->leftJoin('documents','coach_documents.document_id','=','documents.id')->leftJoin('coaches','coach_documents.coach_id','=','coaches.id')->join('users','users.coach_id','=','coach_documents.coach_id')->where('coach_documents.start_date',null)->orderBy('coach_documents.id','asc');

        if(Input::get("registration_id") != ''){
          $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
        }
        if(Input::get("official_name") != ''){
          $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
        }
        
        $sql = $sql->where('coaches.status',1);

        $total = $sql->count();
        $max_per_page = 20;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
          $page_id = Input::get('page');
        } else {
          $page_id = 1;
        }

        $input_string = 'pendingApprovals/pendingDocument?';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $input_string .= ($count_string == 0)?'':'&';
            $input_string .= $key.'='.$value;
            $count_string++;
          }
        }

        $link_string = '';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $link_string .= ($count_string == 0)?'':'&';
            $link_string .= $key.'='.$value;
            $count_string++;
          }
        }

        $documents = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $ApprovalStatus = Approval::status();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
        $this->layout->main = View::make('admin.pendingDocuments.list',["docType"=>'pendingDocument' , "documents"=>$documents , 'ApprovalStatus'=>$ApprovalStatus ,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string,'link_string'=>$link_string]);
    }
    public function pendingLicenses(){
        $sql = CoachLicense::listing()->join('users','users.coach_id','=','coach_licenses.coach_id')->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->where('coach_licenses.status','!=',1);
        if(Input::get("registration_id") != ''){
          $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
        }
        if(Input::get("official_name") != ''){
          $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
        }

        $sql = $sql->where('coaches.status',1);

        $total = $sql->count();
        $max_per_page = 20;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
          $page_id = Input::get('page');
        } else {
          $page_id = 1;
        }

        $input_string = 'pendingApprovals/pendingLicenses?';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $input_string .= ($count_string == 0)?'':'&';
            $input_string .= $key.'='.$value;
            $count_string++;
          }
        }

        $link_string = '';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $link_string .= ($count_string == 0)?'':'&';
            $link_string .= $key.'='.$value;
            $count_string++;
          }
        }

        $coachLicense = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $ApprovalStatus = Approval::status();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
        $this->layout->main = View::make('admin.pendingDocuments.list',["docType"=>'pendingLicenses', "coachLicense"=>$coachLicense, 'ApprovalStatus'=>$ApprovalStatus ,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string, "link_string"=>$link_string]);
    }
    public function pendingEmploymentDetails(){
        $sql = EmploymentDetails::select('employment_details.*','coaches.full_name')->leftJoin('coaches','employment_details.coach_id','=','coaches.id')->join('users','users.coach_id','=','employment_details.coach_id')->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->where('employment_details.status','!=',1);
        if(Input::get("registration_id") != ''){
          $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
        }
        if(Input::get("official_name") != ''){
          $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
        }
        $sql = $sql->where('coaches.status',1);
        
        $total = $sql->count();
        $max_per_page = 20;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
          $page_id = Input::get('page');
        } else {
          $page_id = 1;
        }

        $input_string = 'pendingApprovals/pendingEmploymentDetails?';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $input_string .= ($count_string == 0)?'':'&';
            $input_string .= $key.'='.$value;
            $count_string++;
          }
        }

        $link_string = '';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $link_string .= ($count_string == 0)?'':'&';
            $link_string .= $key.'='.$value;
            $count_string++;
          }
        }

        $employmentDetails = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $ApprovalStatus = Approval::status();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
        $this->layout->main = View::make('admin.pendingDocuments.list',["docType"=>'pendingEmploymentDetails', 'employmentDetails'=>$employmentDetails, 'ApprovalStatus'=>$ApprovalStatus ,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string ,'link_string'=>$link_string]);
    }
    public function pendingActivities(){
        $sql = CoachActivity::select('coach_activity.*','coaches.full_name')->leftJoin('coaches','coach_activity.coach_id','=','coaches.id')->join('users','users.coach_id','=','coach_activity.coach_id')->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->where('coach_activity.status','!=',1);
        if(Input::get("registration_id") != ''){
          $sql = $sql->where('coaches.registration_id','LIKE','%'.Input::get('registration_id').'%');
        }
        if(Input::get("official_name") != ''){
          $sql = $sql->where('coaches.full_name','LIKE','%'.Input::get('official_name').'%');
        }
        $total = $sql->count();
        $max_per_page = 20;
        $total_pages = ceil($total/$max_per_page);
        if(Input::has('page')){
          $page_id = Input::get('page');
        } else {
          $page_id = 1;
        }

        $input_string = 'pendingApprovals/pendingActivities?';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $input_string .= ($count_string == 0)?'':'&';
            $input_string .= $key.'='.$value;
            $count_string++;
          }
        }

        $link_string = '';
        $count_string = 0;
        foreach (Input::all() as $key => $value) {
          if($key != 'page'){
            $link_string .= ($count_string == 0)?'':'&';
            $link_string .= $key.'='.$value;
            $count_string++;
          }
        }
        $activities = $sql->skip(($page_id-1)*$max_per_page)->take($max_per_page)->get();
        $ApprovalStatus = Approval::status();
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'coach','subsidebar'=>3]);
        $this->layout->main = View::make('admin.pendingDocuments.list',["docType"=>'pendingActivities' , "activities"=>$activities, 'ApprovalStatus'=>$ApprovalStatus ,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string, "link_string"=>$link_string]);
    }

    public function postApprove($entity_type,$entity_id){
        $cre=[
            "type"=>Input::get('type')
        ];
        $rules=[
            "type"=>"required"
        ];
        $validation=Validator::make($cre,$rules);
        if($validation->passes()){
            $log = new Approval;
            $log->status = Input::get('type');
            $log->entity_id = $entity_id;
            $log->entity_type = $entity_type;
            $log->user_id = Auth::id();
            if(Input::has('remarks')){
                $log->remarks = Input::get('remarks');
            } else {
                $log->remarks = '';    
            }
            
            $log->save();

            switch ($entity_type) {
                case 1:
                    $coach = Coach::find($entity_id);
                    if(Session::get('privilege') == 2){
                        $coach->status = Input::get('type');
                    } else {
                        $coach->status = 0;
                    }
                    $coach->save();
                    // break;
                    
                    if(Session::get('privilege') == 2 && Input::get('type') == 1){ // only in case of admin and approval

                        // aprove coach documents
                        $CoachDocument = CoachDocument::where('coach_id',$coach->id)->where('status',0)->get();
                        foreach ($CoachDocument as $document) {
                            $log = new Approval;
                            $log->status = Input::get('type');
                            $log->entity_id = $document->id;
                            $log->entity_type = 2;
                            $log->user_id = Auth::id();
                            $log->remarks = 'Approved';
                            $log->save();
                            $document->status = 1;
                            $document->save();
                        }

                        // aprove coach licenses
                        $CoachLicense = CoachLicense::where('coach_id',$coach->id)->where('status',0)->get();
                        foreach ($CoachLicense as $license) {
                            $log = new Approval;
                            $log->status = Input::get('type');
                            $log->entity_id = $license->id;
                            $log->entity_type = 3;
                            $log->user_id = Auth::id();
                            $log->remarks = 'Approved';
                            $log->save();
                            $license->status = 1;
                            $license->save();
                        }

                        // aprove coach employment
                        $EmploymentDetails = EmploymentDetails::where('coach_id',$coach->id)->where('status',0)->get();
                        foreach ($EmploymentDetails as $employment) {
                            $log = new Approval;
                            $log->status = Input::get('type');
                            $log->entity_id = $employment->id;
                            $log->entity_type = 4;
                            $log->user_id = Auth::id();
                            $log->remarks = 'Approved';
                            $log->save();
                            $employment->status = 1;
                            $employment->save();
                        }
                    }
                    break;
                case 2:
                    $coach = CoachDocument::find($entity_id);
                    $coach->status = Input::get('type');
                    $coach->save();
                    break;
                case 3:
                    $coach_license = CoachLicense::find($entity_id);
                    $coach_license->status = Input::get('type');
                    $coach_license->save();
                    break; 
                case 4:
                    $coach_employment = EmploymentDetails::find($entity_id);
                    $coach_employment->status = Input::get('type');
                    $coach_employment->save();
                    break;
                case 5:
                    $coach_activity = CoachActivity::find($entity_id);
                    $coach_activity->status = Input::get('type');
                    $coach_activity->save();
                    break;            
                default:
                    break;
            }
            if(Input::hasFile('document')){
                $destinationPath = "coaches_doc/";
                $extension = Input::file('document')->getClientOriginalExtension();
                $filename = $log->id.'-LogDocument-'.strtotime("now").'.'.$extension;
                Input::file('document')->move($destinationPath,$filename);
                $log->document = $destinationPath.$filename;
            }
            $log->save();
            return Redirect::Back()->with('success','Status updated');
 
        } else {
            return Redirect::Back()->with('failure','Please fill all the required fields');
        }
    }

    
}