<?php
class ApprovalController extends BaseController {
    protected $layout = 'layout';

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
            return Redirect::Back();
 
        } else {
            return Redirect::Back()->with('failure','Please fill all the required fields');
        }
    }

}