<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Termination extends Model{

	protected $table = 'terminations';

	protected $fillable = ['date_of_exit','reason_of_exit','details_of_exit','resignation_list','employee_archives_id'];

	public static function getPermissions()
	{
		return array(
      "hrm_termination_can_add",
      "hrm_termination_can_view",
      "hrm_termination_can_delete",
      "hrm_termination_can_search",
			"hrm_termination_can_revert"
		);
	}

}
