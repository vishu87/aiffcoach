<?php
//status 0 -> Deatails , 1 -> Pending , 2 -> Approved, 3 -> disapproved

class Coach extends Eloquent {
	protected $table = 'coaches';

	public static function Status(){
		return array(
			"0" => "Pending for approval",
            "1" => "Approved",
			"2" => "Refer Back",
			"3" => "Rejected",
		);
	}

	public function scopeApproved($query){
        return $query->where('coaches.status', '=', 1);
    }

    public function scopePending($query){
        return $query->whereIn('coaches.status', array(0,2));
    }

    public function scopeReferBack($query){
        return $query->where('coaches.status', '=', 2);
    }

    public function scopeRejected($query){
        return $query->where('coaches.status', '=', 3);
    }

    public static function listing(){
    	return Coach::select('coaches.id','coaches.registration_id','coaches.gender','coaches.dob','coaches.full_name','states.name as state_reference','coach_parameters.email','coach_parameters.mobile','coaches.status','users.official_types')->join('users','users.coach_id','=','coaches.id')->leftJoin('states','coaches.state_id','=','states.id')->leftJoin('coach_parameters','coaches.id','=','coach_parameters.coach_id')->where('coaches.deleted',0);
    }

    public function check_admin(){
        if(Session::get('privilege') == 2){
            return true;
        } else {
            return false;
        }
    }

    public function check_coach(){
        if(Session::get('privilege') == 1 && $this->status == 2){
            return true;
        } else {
            return false;
        }
    }
}
