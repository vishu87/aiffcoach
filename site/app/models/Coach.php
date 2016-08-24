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
        return $query->where('coaches.status', '=', 2);
    }

    public function scopePending($query){
        return $query->where('coaches.status', '=', 1)->orWhere('coaches.status','=',0);
    }

    public function scopeDisapproved($query){
        return $query->where('coaches.status', '=', 3);
    }

    public static function listing(){
    	return Coach::select('coaches.id','coaches.gender','coaches.dob','coaches.first_name','coaches.middle_name','coaches.last_name','states.name as state_reference','coach_parameters.email','coach_parameters.mobile','coaches.status')->join('states','coaches.state_id','=','states.id')->join('coach_parameters','coaches.id','=','coach_parameters.coach_id');
    }

}
