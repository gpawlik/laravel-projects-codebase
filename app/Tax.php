<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model{

	protected $table = 'income_tax_model';

	//protected $fillable = [''];

	public static function getPermissions()
	{
		return array(
			"hrm_tax_can_add"
		);
	}

}
