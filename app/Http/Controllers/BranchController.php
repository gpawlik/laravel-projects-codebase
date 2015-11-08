<?php namespace App\Http\Controllers;

use App\Http\Tasks\BranchTasks;
use Illuminate\Http\Request;

use App\Role;
use App\Permission;
use App\Branch;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class BranchController extends Controller {

	public function index()
	{
    	if(self::checkUserPermissions("system_branch_can_view"))
		{
      		$data['title'] = "Branches";
	    	$data['branches'] = Branch::orderBy("updated_at","DESC")->paginate(20);
      		$data['activeLink'] = "branch";
			$data['subTitle'] = "Company's Branches";
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Branch",
					"route" => "/system/branches/create",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_branch_can_add"
				),
				array
				(
					"title" => "Search for Branch",
					"route" => "/system/branches/search",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "system_branch_can_search"
				)
			);

      		return view('dashboard.system.branches.index',$data);
    	}
    	else
    	{
        	return "You are not authorized";die();
    	}

  }

  public function create()
  {
    if(self::checkUserPermissions("system_branch_can_add"))
	{
     	$data['title'] = "Add Branch";
      	$data['activeLink'] = "branch";
		$data['subTitle'] = "Add a Company Branch";
      	$data['subLinks'] = array(
        	array
        	(
          		"title" => "Branch List",
          		"route" => "/system/branches",
          		"icon" => "<i class='fa fa-th-list'></i>",
          		"permission" => "system_branch_can_view"
        	)
      	);

      	return view('dashboard.system.branches.add',$data);
	}
	else
	{
    	return "You are not authorized";die();
	}
  }

  public function store(Request $request)
  {
   	if(self::checkUserPermissions("system_branch_can_add"))
	{
    	$rules = self::getRules();
		$rules["branch_name"] = "required | unique:branches";

      	$validator = Validator::make(Input::all(), $rules);

      	if ($validator->fails())
      	{
        	return Redirect::to('/system/branches/create')
              ->withErrors($validator)
              ->withInput();
      	}
      	else
      	{
        	$branch = new Branch;

        	$model = BranchTasks::insertIntoModel($branch,$request);

        	$model -> save();
        	Session::flash('message','Branch Added');
        	return Redirect::to('/system/branches');
      	}
    }
    else
    {
        return "You are not authorized";die();
    }
  }

	public function edit($id)
	{
		if(self::checkUserPermissions("system_branch_can_edit"))
		{
			$branch = Branch::find($id);

	    	$data['title'] = "Edit Branch";
			$data['activeLink'] = "branch";
			$data['subTitle'] = "Edit Company's Branch";
	    	$data['subLinks'] = array(
	      		array
	      		(
	        		"title" => "Branch List",
	        		"route" => "/system/branches",
	        		"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "system_branch_can_view"
	      		)
	    	);
	    	
	    	$data['branch'] = $branch;

	    	return view('dashboard.system.branches.edit',$data);
    	}
    	else
    	{
        	return "You are not authorized";die();
    	}
	}

	public function update(Request $request, $id)
	{
		if(self::checkUserPermissions("system_branch_can_edit"))
		{
			$rules = self::getRules();

      		$validator = Validator::make(Input::all(), $rules);

      		if ($validator->fails())
      		{
        		return Redirect::to('/system/branches/'.$id."/edit")
              		->withErrors($validator)
              		->withInput();
      		}
      		else
      		{
				$branch = Branch::find($id);

				$model = BranchTasks::insertIntoModel($branch,$request);

				$model -> push();
				Session::flash('message','Branch Updated');
				return Redirect::to('/system/branches');
			}
		}
		else
		{
				return "You are not authorized";die();
		}
	}

	public function show($id)
	{
		if(self::checkUserPermissions("system_branch_can_view"))
		{
			$branch = Branch::find($id);

			$data['title'] = "View Branch Details";
			$data['activeLink'] = "branch";
			$data['subTitle'] = "View Company Branch Details";
			$data['subLinks'] = array(
				array
				(
					"title" => "Branch List",
					"route" => "/system/branches",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "system_branch_can_view"
				),
				array
				(
					"title" => "Add Branch",
					"route" => "/system/branches/create",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_branch_can_add"
				),
				array
				(
					"title" => "Edit Branch",
					"route" => "/system/branches/".$id."/edit",
					"icon" => "<i class='fa fa-pencil'></i>",
					"permission" => "system_branch_can_edit"
				),
				array
				(
					"title" => "Delete Branch",
					"route" => "/system/branch/delete/".$id,
					"icon" => "<i class = 'fa fa-trash'></i>",
					"permission" => "system_branch_can_delete"
				)
			);
			$data['branch'] = $branch;

			return view('dashboard.system.branches.view',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function delete($id)
	{
		if(self::checkUserPermissions("system_branch_can_delete"))
		{
			$branch = Branch::find($id);

			$branch -> delete();

			Session::flash('message', 'Branch deleted');
			return Redirect::to("/system/branches");
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function search()
	{
		if(self::checkUserPermissions("system_branch_can_search"))
		{
			$data['title'] = "Search for Branch";
			$data['activeLink'] = "branch";
			$data['subTitle'] = "Search For Branch";
			$data['subLinks'] = array(
				array
				(
					"title" => "Branch List",
					"route" => "/system/branches",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "system_branch_can_view"
				),
				array
				(
					"title" => "Add Branch",
					"route" => "/system/branches/create",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_branch_can_add"
				)
			);

			return view('dashboard.system.branches.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$branches = \DB::table("branches")->select("id","branch_name","branch_location")
			->where("branch_name","ilike","%$data%")
			->orWhere("branch_location","ilike","%$data%")

		->get();
	return Response::json(
				$branches
		);
	}


  public function getRules()
  {
    return array(
      'branch_name' => 'required'
    );

  }

}
