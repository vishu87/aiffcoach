<?php
// status 0=>Not approved , 1=>"Approved"
class CoachLicense extends Eloquent {
	protected $table = 'coach_licenses';

    public static function listing(){
    	return CoachLicense::select('coach_licenses.*','license.name as license_name','coaches.full_name','CL.name as equivalent_license')->leftJoin('coaches','coach_licenses.coach_id','=','coaches.id')->join('license','coach_licenses.license_id','=','license.id')->leftJoin('license as CL','CL.id','=','coach_licenses.equivalent_license_id');
    }

    public function check_admin(){
    	if(Session::get('privilege') == 2 && $this->status == 0){
            return true;
        } else {
            return false;
        }
    }
}
