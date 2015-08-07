<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Auth;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public static function checkUserPermissions($permission)
    {
      $userPermissions = \DB::table("permissions")->where("role_id",Auth::user()->role_id)->get();

      foreach($userPermissions as $userPermission)
      {
        if($permission == $userPermission->permission_name)
        {
          //check user status to see if password needs to be changed
          if(Auth::user()->status == 2)
          {
            //die();
            //return true for now
            return true;
          }
          else
          {
            return true;
          }
        }

      }
      return false;
    }

}
