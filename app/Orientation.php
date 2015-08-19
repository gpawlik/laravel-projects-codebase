<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orientation extends Model
{
    protected $table = 'orientations';

    protected $fillable = ['orientation_start_date','orientation_end_date','orientation_outcome','employee_id'];

    public static function getPermissions()
    {
      return array(
        "hrm_orientation_can_add",
        "hrm_orientation_can_edit",
        "hrm_orientation_can_view",
        "hrm_orientation_can_delete",
        "hrm_orientation_can_search"
      );
    }
}
