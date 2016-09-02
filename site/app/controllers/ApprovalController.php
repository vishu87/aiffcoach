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
                    break;
                case 3:
                    $coach_license = CoachLicense::find($entity_id);
                    $coach_license->status = Input::get('type');
                    $coach_license->save();
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

    public function viewApproveList($coach_license_id){
        $coach = CoachLicense::where('coach_licenses.id',$coach_license_id)->first();
        if(sizeof($coach)>0){
            $data['success'] = true;
            $data['message'] = html_entity_decode(View::make('admin.coaches.view',["coach"=>$coach]));
        }
        else{
            $data["message"] = "No record found";
        }
        return json_encode($data);
    }
}