<?php namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use App\Bank;
use App\Identification;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class IdentificationController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("system_identification_can_view"))
		{
      $data['title'] = "Identification Types";
	    $data['banks'] = Identification::orderBy("updated_at","DESC")->paginate(20);
      $data['activeLink'] = "identification";
			$data['subTitle'] = "Identification Types";
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Identification Type",
					"route" => "/system/identification/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_identification_can_add"
				),
				array
				(
					"title" => "Search for bank",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "system_identification_can_search"
				)
			);

      return view('dashboard.system.identification.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

	public function add()
	{
		if(self::checkUserPermissions("system_identification_can_add"))
		{
      $data['title'] = "Add Identification";
      $data['activeLink'] = "identification";
			$data['subTitle'] = "Add Identification Type";
      $data['subLinks'] = array(
        array
        (
          "title" => "Identification List",
          "route" => "/system/identification",
          "icon" => "<i class='fa fa-th-list'></i>",
          "permission" => "system_identification_can_view"
        )
      );

      return view('dashboard.system.identification.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function create()
	{
		if(self::checkUserPermissions("system_identification_can_add"))
		{
			$rules = self::getRules();
			$rules["identification_name"] = "unique:identification";

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/identification/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$id = new Identification;

				$id -> identification_name = Input::get("identification_name");

				$id -> save();
				Session::flash('message','Identification Added');
				return Redirect::to('/system/identification');
			}
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function edit($id)
	{
		if(self::checkUserPermissions("system_identification_can_edit"))
		{
	    $id = Identification::find($id);

	    $data['title'] = "Edit Identification";
			$data['activeLink'] = "identification";
			$data['subTitle'] = "Edit Identification Type";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Identification List",
	        "route" => "/system/identification",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "system_identification_can_view"
	      )
	    );
	    $data['identification'] = $id;

	    return view('dashboard.system.identification.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function update($id)
	{
		if(self::checkUserPermissions("system_identification_can_edit"))
		{
			$id = Identification::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/identification/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$id -> identification_name = Input::get("identification_name");

				$id -> push();
				Session::flash('message', "Identification Details Updated");
				return Redirect::to("/system/identification");
			}

		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function view($id)
	{
		if(self::checkUserPermissions("system_identification_can_view"))
		{
			$id = Identification::find($id);

			$data['title'] = "View Identification Details";
			$data['activeLink'] = "identification";
			$data['subTitle'] = "View Identification Type Details";
			$data['subLinks'] = array(
				array
				(
					"title" => "Identification List",
					"route" => "/system/identification",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "system_identification_can_view"
				),
				array
				(
					"title" => "Add Identification",
					"route" => "/system/identification/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_identification_can_add"
				)
			);
			$data['identification'] = $id;

			return view('dashboard.system.identification.view',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function delete($id)
	{
		if(self::checkUserPermissions("system_identification_can_delete"))
		{
			$id = Identification::find($id);

			$id -> delete();

			Session::flash('message', 'Identification deleted');
			return Redirect::to("/system/identification");
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function getRules()
	{
		return array(
			'identification_name' => 'required'
		);

	}


}
