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
                    // aprove coach documents
                    //forrach document
                    // $log = new Approval;
                    // $log->status = Input::get('type');
                    // $log->entity_id = $document->id;
                    // $log->entity_type = 2;
                    // $log->user_id = Auth::id();
                    // $log->remarks = Input::get('remarks');
                    // $log->save();
                    //endforeach
                    break;
                
                default:
                    
                    break;
            }
            // if(Input::hasFile('document')){
            //     $destinationPath = "approval_docs/";
            //     $extension = Input::file('document')->getClientOriginalExtension();
            //     $filename = $log_id.'-LogDocument-'.strtotime("now").'.'.$extension;
            //     Input::file('document')->move($destinationPath,$filename);
            //     $log->document = $destinationPath.$filename;
            // }
            return Redirect::Back();
 
        } else {
            return Redirect::Back()->with('failure','Please fill all the required fields');
        }
    }
}