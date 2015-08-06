<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model {

	protected $table = 'jobs';

	protected $fillable = ['job_title','department_id'];

	public static function getPermissions()
	{
		return array(
      "hrm_job_can_add",
			"hrm_job_can_edit",
      "hrm_job_can_view",
      "hrm_job_can_delete",
      "hrm_job_can_search"
		);
	}

}
