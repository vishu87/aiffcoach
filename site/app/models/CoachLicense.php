<?php
// status 0=>Not approved , 1=>"Approved"
class CoachLicense extends Eloquent {
	protected $table = 'coach_licenses';

    public static function listing(){
    	return CoachLicense::select('coach_licenses.*','license.name as license_name')->join('license','coach_licenses.license_id','=','license.id');
    }

}
