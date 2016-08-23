<?php


class CoachDocument extends Eloquent {

	protected $table = 'coach_documents';

	public static function DocTypes(){
		return  DB::table('documents')->lists('name','id');
	}
}
