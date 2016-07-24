<?php


class CoachDocument extends Eloquent {

	protected $table = 'coach_documents';

	public static function DocTypes(){
		return  array(
			'' => 'Select',
			'1'=>'Aadhar Card',
			'2'=>'Voter Id Card',
			'3'=>'PAN Card',
			'4'=>'Driving License',
			'5'=>'Passport',
			'6'=>'Others'
		 );
	}
}
