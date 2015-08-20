<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model {

	protected $table = 'ranks';

	protected $fillable = ['rank_name','rank_code'];

	public static function getPermissions()
	{
		return array(
      // "hrm_rank_can_add",
			// "hrm_rank_can_edit",
      // "hrm_rank_can_view",
      // "hrm_rank_can_delete",
      // "hrm_rank_can_search"
		);
	}

}
