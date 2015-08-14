<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orientation extends Model
{
    protected $table = 'orientations';

    protected $fillable = ['description','minimum_salary','maximum_salary','job_id'];

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
