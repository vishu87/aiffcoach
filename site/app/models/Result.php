<?php
class Result extends Eloquent {
	protected $table = 'results';

	public static function status(){
		$status = [
			""=>"Select",
			"1"=>"Fame",
			"2"=>"Fail",
			"3"=>"Pass",
			"4"=>"Pro Pass"
		];
		return $status;
	}
	
}
