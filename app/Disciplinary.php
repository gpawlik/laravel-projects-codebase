<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Disciplinary extends Model {

	protected $table = 'disciplinaries';

	protected $fillable = ['department_name'];

	public static function getPermissions()
	{
		return array(
      "hrm_disciplinary_can_add",
			"hrm_disciplinary_can_edit",
      "hrm_disciplinary_can_view",
      "hrm_disciplinary_can_delete",
      "hrm_disciplinary_can_search"
		);
	}

}
