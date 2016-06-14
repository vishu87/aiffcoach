<?php


class License extends Eloquent {

	protected $table = 'license';

	public static function Authority(){
		return [""=>"select","1"=>"AFC",'2'=>"AIFF"];
	}

	public static function licenseList(){
		return [""=>"Select"]+License::lists('name','id');
	}
}
