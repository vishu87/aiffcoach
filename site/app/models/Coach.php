<?php
//status 0 -> Deatails , 1 -> Pending , 2 -> Approved, 3 -> disapproved

class Coach extends Eloquent {
	protected $table = 'coaches';

	public static function Status(){
		return array(
			"0" => "Registered",
			"1" => "Pending",
			"2" => "Approved",
			"3" => "Disapproved",
		);
	}

	public function scopeApproved($query){
        return $query->where('coaches.status', '=', 1);
    }

    public function scopePending($query){
        return $query->where('coaches.status', '=', 0);
    }

    public function scopeReferBack($query){
        return $query->where('coaches.status', '=', 2);
    }

    public function scopeRejected($query){
        return $query->where('coaches.status', '=', 3);
    }

    public static function listing(){
    	return Coach::select('coaches.id','coaches.registration_id','coaches.gender','coaches.dob','coaches.full_name','states.name as state_reference','coach_parameters.email','coach_parameters.mobile','coaches.status','users.official_types')->join('users','users.coach_id','=','coaches.id')->leftJoin('states','coaches.state_id','=','states.id')->leftJoin('coach_parameters','coaches.id','=','coach_parameters.coach_id');
    }

}
