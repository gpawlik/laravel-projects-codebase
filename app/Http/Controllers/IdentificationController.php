<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tasks\IdentificationTasks;

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
					"route" => "/system/identification/create",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_identification_can_add"
				),
				array
				(
					"title" => "Search for bank",
					"route" => "/system/identification/search",
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

	public function create()
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

	public function store(Request $request)
	{
		if(self::checkUserPermissions("system_identification_can_add"))
		{
			$rules = self::getRules();
			$rules["identification_name"] = "required | unique:identification";

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/identification/create')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$id = new Identification;

				$model = IdentificationTasks::insertIntoModel($id,$request);

				$model -> save();
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

    public function update(Request $request,$id)
	{
		if(self::checkUserPermissions("system_identification_can_edit"))
		{
			$identification = Identification::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/system/identification/'.$id.'/edit')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$model = IdentificationTasks::insertIntoModel($identification,$request);

				$model -> push();
				Session::flash('message', "Identification Details Updated");
				return Redirect::to("/system/identification");
			}

		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function show($id)
	{
		if(self::checkUserPermissions("system_identification_can_view"))
		{
			$identification = Identification::find($id);

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
					"route" => "/system/identification/create",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_identification_can_add"
				),
				array
				(
					"title" => "Edit Identification",
					"route" => "/system/identification/".$id."/edit",
					"icon" => "<i class='fa fa-pencil'></i>",
					"permission" => "system_identification_can_edit"
				),
				array
				(
					"title" => "Delete Identification",
					"route" => "/system/identification/delete/".$id,
					"icon" => "<i class = 'fa fa-trash'></i>",
					"permission" => "system_identification_can_delete"
				)
			);
			$data['identification'] = $identification;

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

	public function search()
	{
		if(self::checkUserPermissions("system_identification_can_search"))
		{
			$data['title'] = "Search for Identification";
			$data['activeLink'] = "identification";
			$data['subTitle'] = "Search For Identification";
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
					"route" => "/system/identification/create",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_identification_can_add"
				)
			);

			return view('dashboard.system.identification.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$identification = \DB::table("identification")->select("id","identification_name")
		->where("identification_name","ilike","%$data%")

		->get();
	return Response::json(
				$identification
		);
	}

	public function getRules()
	{
		return array(
			'identification_name' => 'required'
		);

	}


}