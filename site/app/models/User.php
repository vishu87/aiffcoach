<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/* priviledge
	1 - official
	2 - admin
	3 - result admin

	official types
	1 - coach
	2 - team official
	3 - club official

*/

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static function OfficialTypes(){
		return array(
			"1" => "Coach",
			"2" => "Team Official",
			"3" => "Club Official",
		);
	}

}
