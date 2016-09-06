<?php


class CoachDocument extends Eloquent {

	protected $table = 'coach_documents';

	public static function DocTypes(){
		return  DB::table('documents')->lists('name','id') + ["0"=>"Others"];
	}

	public function check_admin(){
        if(Session::get('privilege') == 2 && $this->status == 0){
            return true;
        } else {
            return false;
        }
    }

    public function check_coach(){
        if(Session::get('privilege') == 1 $$ $this->coach_id == Auth::user()->coach_id && $this->status == 2){
            return true;
        } else {
            return false;
        }

    }
}
