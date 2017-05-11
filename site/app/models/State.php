<?php

class State extends Eloquent {

	protected $table = 'states';

	public static function states(){
		$states = State::orderBy('name')->lists('name','id');
		unset($states[37]);
		$states[37] = 'Other';
		return [''=>'Select State'] + $states;
	}

}
