<?php

class EmploymentDetails extends Eloquent {

	protected $table = 'employment_details';

	public function check_admin(){
        if(Session::get('privilege') == 2 && $this->status == 0){
            return true;
        } else {
            return false;
        }
    }

    public static function emp_status(){
    	return array("1" => "Present" , "2" => "Previous");
    }
}
