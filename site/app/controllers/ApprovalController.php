<?php
class ApprovalController extends BaseController {
    protected $layout = 'layout';

    public function pendingDocument(){
        $sql = CoachDocument::select('coach_documents.*','documents.name as document_name','coaches.full_name')->leftJoin('documents','coach_documents.document_id','=','documents.id')->leftJoin('coaches','coach_documents.coach_id','=','coaches.id')->join('users','users.coach_id','=','coach_documents.coach_id')->where('users.official_types','LIKE','%'.Auth::user()->manage_official_type.'%')->where('coach_documents.status','!=',1);
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
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'pendingDocument','subsidebar'=>0]);
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
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'pendingDocument','subsidebar'=>0]);
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
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'pendingDocument','subsidebar'=>0]);
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
        $this->layout->sidebar = View::make('admin.sidebar',['sidebar'=>'pendingDocument','subsidebar'=>0]);
        $this->layout->main = View::make('admin.pendingDocuments.list',["docType"=>'pendingActivities' , "activities"=>$activities, 'ApprovalStatus'=>$ApprovalStatus ,"total" => $total, "page_id"=>$page_id, "max_per_page" => $max_per_page, "total_pages" => $total_pages,'input_string'=>$input_string, "link_string"=>$link_string]);
    }

    public function postApprove($entity_type,$entity_id){
        $cre=[
            "remarks"=>Input::get('remarks'),
            "type"=>Input::get('type')
        ];
        $rules=[
            "remarks"=>"required",
            "type"=>"required"
        ];
        $validation=Validator::make($cre,$rules);
        if($validation->passes()){
            $log = new Approval;
            $log->status = Input::get('type');
            $log->entity_id = $entity_id;
            $log->entity_type = $entity_type;
            $log->user_id = Auth::id();
            $log->remarks = Input::get('remarks');
            $log->save();

            switch ($entity_type) {
                case 1:
                    $coach = Coach::find($entity_id);
                    $coach->status = Input::get('type');
                    $coach->save();
                    // break;
                    // aprove coach documents
                    $CoachDocument = CoachDocument::where('coach_id',$coach->id)->get();
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