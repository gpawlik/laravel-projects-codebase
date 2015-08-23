<?php namespace App\Http\Controllers;

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
					"route" => "/system/branches/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_branch_can_add"
				),
				array
				(
					"title" => "Search for Branch",
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

  public function add()
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

  public function create()
  {
    if(self::checkUserPermissions("system_branch_can_add"))
		{
      $rules = self::getRules();
			$rules["branch_name"] = "unique:branches";

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails())
      {
        return Redirect::to('/system/branches/add')
              ->withErrors($validator)
              ->withInput();
      }
      else
      {
        $branch = new Branch;

        $branch -> branch_name = Input::get("branch_name");

        if(Input::get("branch_location"))
        {
          $branch -> branch_location = Input::get("branch_location");
        }
        else
        {
          $branch -> branch_location = null;
        }


        $branch -> save();
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

	public function update($id)
	{
		if(self::checkUserPermissions("system_branch_can_edit"))
		{
			$rules = self::getRules();

      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails())
      {
        return Redirect::to('/system/branches/edit/'.$id)
              ->withErrors($validator)
              ->withInput();
      }
      else
      {
				$branch = Branch::find($id);

				$branch -> branch_name = Input::get("branch_name");

				if(Input::get("branch_location"))
				{
					$branch -> branch_location = Input::get("branch_location");
				}
				else
				{
					$branch -> branch_location = null;
				}


				$branch -> push();
				Session::flash('message','Branch Updated');
				return Redirect::to('/system/branches');
			}
		}
		else
		{
				return "You are not authorized";die();
		}
	}

	public function view($id)
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
					"route" => "/system/branches/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "system_branches_can_add"
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

  public function getRules()
  {
    return array(
      'branch_name' => 'required'
    );

  }

}
