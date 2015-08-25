<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model{

	protected $table = 'branches';

	protected $fillable = ['branch_name','branch_location'];

	public static function getPermissions()
	{
		return array(
			"system_branch_can_add",
			"system_branch_can_edit",
			"system_branch_can_delete",
			"system_branch_can_view",
			"system_branch_can_search"
		);
	}

}
