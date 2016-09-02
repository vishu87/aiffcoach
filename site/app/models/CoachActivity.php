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
}
