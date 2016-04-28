<?php


class State extends Eloquent {

	protected $table = 'states';

	public static function states(){
		return [''=>'Select State']+State::orderBy('name')->lists('name','id');
	}
}
