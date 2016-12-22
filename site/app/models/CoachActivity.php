<?php


class CoachActivity extends Eloquent {

	protected $table = 'coach_activity';

	public function check_admin(){
        if(Session::get('privilege') == 2 && $this->status == 0){
            return true;
        } else {
            return false;
        }
    }

    public static function coach_roles(){
    	return  array("1" => "Ast Coach" , "2" => "Head Coach" , "3" => "GK Coach" , "4" => "Team Manager" , "5" => "Physiotherapist","6" => "Others");
    }
}
