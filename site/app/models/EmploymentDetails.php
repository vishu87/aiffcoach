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
    	return array("1" => "Present" , "2" => "Previous" , '3' => 'Unemployed');
    }

    public static function organization_types(){
        return array('1' =>'Association' ,'2' => 'Club' , '3'=>'School' , '0'=>'Other' );
    }

    public static function associations(){
        return DB::connection('mysql_teams')->table('Association')->orderBy('AssociationName')->lists('AssociationName','AssociationId');
    }

    public static function clubs(){
        return DB::connection('mysql_teams')->table('Club')->orderBy('ClubName')->lists('ClubName','ClubId');
    }

    public static function schools(){
        return DB::connection('mysql_teams')->table('schools')->orderBy('school_name')->lists('school_name','id');
    }

    public static function designations(){
        return [
            '1'=>'Technical Director',
            '2'=>'Head of Youth Development',
            '3'=>'Head Coach',
            '4'=>'Assistant Coach',
            '5'=>'Goalkeeping Coach',
            '6'=>'Head of Talent Identification & Recruitment',
            '7'=>'Scout',
            '8'=>'Fitness Coach',
            '9'=>'Futsal Coach',
            '10'=>'Grassroots Leader',
            '0'=>'Other',
        ];
    }
    

}
