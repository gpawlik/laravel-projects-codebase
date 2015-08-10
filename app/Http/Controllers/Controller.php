<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Auth;
use Redirect;

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
            return Redirect::to("/dashboard/change_password")->send();
          }
          else
          {
            return true;
          }
        }

      }
      return false;
    }

    public static function checkUserStatus()
    {
      //check user status to see if password needs to be changed
      if(Auth::user()->status == 2)
      {
        return Redirect::to("/dashboard/change_password")->send();
      }
      else
      {
        return true;
      }
    }


}
