<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model{

	protected $table = 'banks';

	protected $fillable = ['bank_name','bank_code'];

	public static function getPermissions()
	{
		return array(
			"system_bank_can_add",
			"system_bank_can_edit",
			"system_bank_can_delete",
			"system_bank_can_view",
			"system_bank_can_search"
		);
	}

}
