<?php namespace App\Http\Controllers;

use App\Role;
use App\Department;
use App\Identification;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class DepartmentController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("hrm_department_can_view"))
		{
      $data['title'] = "Departments";
      $data['activeLink'] = "department";
      $data['departments'] = Department::orderBy("updated_at","DESC")->paginate(20);

      $data['subLinks'] = array(
				array
				(
					"title" => "Add Department",
					"route" => "/hrm/departments/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_department_can_add"
				),
				array
				(
					"title" => "Search for department",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "hrm_department_can_search"
				)
			);


      return view('dashboard.hrm.departments.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }

  }

  public function add()
  {
    if(self::checkUserPermissions("hrm_department_can_add"))
		{
      $data['title'] = "Add department";
      $data['activeLink'] = "department";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Department list",
					"route" => "/hrm/departments",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_department_can_view"
	      )
	    );

      return view('dashboard.hrm.departments.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function create()
  {
    if(self::checkUserPermissions("hrm_department_can_add"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/departments/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$dept = new Department;

				$dept -> department_name = Input::get("department_name");

				$dept -> save();

				Session::flash('message','Department Added');
				return Redirect::to('/hrm/departments');
			}
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function edit($id)
  {
		if(self::checkUserPermissions("hrm_department_can_edit"))
		{
			$dept = Department::find($id);

			$data['title'] = "Edit Department";
			$data['activeLink'] = "department";
			$data['department'] = $dept;
	    $data['subLinks'] = array(
        array
	      (
	        "title" => "Department list",
					"route" => "/hrm/departments",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_department_can_view"
	      ),
				array
	      (
          "title" => "Add Department",
          "route" => "/hrm/departments/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_department_can_add"
	      )
	    );

	    return view('dashboard.hrm.departments.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function update($id)
  {
    $dept = Department::find($id);

    if(self::checkUserPermissions("hrm_department_can_edit"))
		{
      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/departments/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}
			else
			{

				$dept -> department_name = Input::get("department_name");

				$dept -> push();

				Session::flash('message','Department Updated');
				return Redirect::to('/hrm/departments');
			}
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function delete($id)
  {
		if(self::checkUserPermissions("hrm_department_can_delete"))
		{
			$dept = Department::find($id);

			$dept -> delete();

			Session::flash('message', 'Department deleted');
			return Redirect::to("/hrm/departments");
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function getRules()
  {
    return array(
      'department_name' => 'required',
    );
  }

}