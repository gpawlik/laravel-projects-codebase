<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model{

	protected $table = 'training';

	protected $fillable = ['training_type','training_total_cost','traning_cost_components','training_start_date','training_end_date','training_facilitator','training_topic','training_location','employee_id'];

	public static function getPermissions()
	{
		return array(
      "hrm_training_can_add",
      "hrm_training_can_view",
			"hrm_training_can_edit",
      "hrm_training_can_delete",
      "hrm_training_can_search",
		);
	}

}
