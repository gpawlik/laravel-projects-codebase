<?php namespace App\Http\Controllers;

use App\Role;
use App\Disciplinary;
use App\Identification;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class DisciplinaryController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("hrm_disciplinary_can_view"))
		{
      $data['title'] = "Disciplinary Records";
      $data['activeLink'] = "discipline";
			$data['subTitle'] = "Disciplinary / Grievance Records";
      $data['disciplinaries'] = Disciplinary::orderBy("updated_at","DESC")->paginate(20);

      $data['subLinks'] = array(
        array
        (
          "title" => "Add Disciplinary",
          "route" => "/hrm/disciplinaries/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_disciplinary_can_add"
        ),
        array
        (
          "title" => "Search for Disciplary Record",
          "route" => "/hrm/disciplinaries/search",
          "icon" => "<i class='fa fa-search'></i>",
          "permission" => "hrm_disciplinary_can_search"
        )
      );


      return view('dashboard.hrm.disciplinaries.index',$data);
      }
      else
      {
        return "You are not authorized";die();
      }

  }

  public function add()
  {
    if(self::checkUserPermissions("hrm_disciplinary_can_add"))
		{
      $data['title'] = "Add Disciplinary Record";
      $data['activeLink'] = "discipline";
			$data['subTitle'] = "Add Disciplinary / Grievance Record";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Disciplinary Records",
					"route" => "/hrm/disciplinaries",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_disciplinary_can_view"
	      )
	    );

      $data['employee_name'] = "";

      return view('dashboard.hrm.disciplinaries.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function create()
  {
    if(self::checkUserPermissions("hrm_disciplinary_can_add"))
		{
      if(Input::get("action_taken") == "SUSPENSION" && !Input::get("suspension_number_of_days"))
      {
        return Redirect::to('/hrm/disciplinaries/add')
              ->withErrors("Number of days on Suspension Required")
              ->withInput();
      }

      $employee = Input::get("employee");

      $employeeFirstName = array_pad(explode(" ", $employee,3),3,null)[0];
      $employeeLastName = array_pad(explode(" ", $employee,3),3,null)[1];
      $employeeEmail = str_replace(")","",str_replace("(", "", array_pad(explode(" ", $employee,3),3,null)[2]));

      //get user's leave days
      if($employeeEmail != null)
      {
        $employeeDetails = \DB::table("employees")->where("email",$employeeEmail)->get()[0];

        if($employeeDetails -> employment_status == "TERMINATED")
        {
          return Redirect::to('/hrm/disciplinaries/add')
                ->withErrors("Employee not active")
                ->withInput();
        }

        $employeeId = $employeeDetails->id;

        $disciplinary = new Disciplinary;

        $disciplinary -> type_of_warning = Input::get("type_of_warning");
        $disciplinary -> action_taken = Input::get("action_taken");
        if(Input::get("action_taken") == "SUSPENSION")
        {
          $disciplinary -> suspension_number_of_days = (Input::get("suspension_number_of_days") == "" ? null : Input::get("suspension_number_of_days"));
        }
        else
        {
          $disciplinary -> suspension_number_of_days = null;
        }
        $disciplinary -> offense = (Input::get("offense") == "" ? null : Input::get("offense"));
        $disciplinary -> employee_id = $employeeId;

        $disciplinary -> save();

        Session::flash('message', 'Disciplinary Record Added');
        return Redirect::to("/hrm/disciplinaries");
      }
      else
      {
        return Redirect::to('/hrm/disciplinaries/add')
              ->withErrors("Employee not found")
              ->withInput();
      }
    }
    else
    {
        return "You are not authorized";die();
    }

  }

  public function edit($id)
  {
    if(self::checkUserPermissions("hrm_disciplinary_can_edit"))
		{
      $disciplinary = Disciplinary::find($id);

			$data['title'] = "Edit Disciplinary Record";
			$data['activeLink'] = "discipline";
			$data['subTitle'] = "Edit Disciplinary / Grievance Record";
			$data['disciplinary'] = $disciplinary;
	    $data['subLinks'] = array(
        array
	      (
	        "title" => "Disciplinary Records",
					"route" => "/hrm/disciplinaries",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_disciplinary_can_view"
	      ),
				array
	      (
          "title" => "Add Disciplinary Record",
          "route" => "/hrm/disciplinaries/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_disciplinary_can_add"
	      )
	    );

      $employee = \DB::table("employees")->where("id",$disciplinary->employee_id)->get();

      $data['employee_name'] = $employee[0]->first_name . " " . $employee[0]->last_name . " " . "(".$employee[0]->email.")";

      $data['type_of_warning'] = $disciplinary -> type_of_warning;

      $data['action_taken'] = $disciplinary -> action_taken;


	    return view('dashboard.hrm.disciplinaries.edit',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function update($id)
  {
    if(self::checkUserPermissions("hrm_disciplinary_can_edit"))
		{
      if(Input::get("action_taken") == "SUSPENSION" && !Input::get("suspension_number_of_days"))
      {
        return Redirect::to('/hrm/disciplinaries/edit/'.$id)
              ->withErrors("Number of days on Suspension Required")
              ->withInput();
      }

      $employee = Input::get("employee");

      $employeeFirstName = array_pad(explode(" ", $employee,3),3,null)[0];
      $employeeLastName = array_pad(explode(" ", $employee,3),3,null)[1];
      $employeeEmail = str_replace(")","",str_replace("(", "", array_pad(explode(" ", $employee,3),3,null)[2]));

      //get user's leave days
      if($employeeEmail != null)
      {
        $employeeDetails = \DB::table("employees")->where("email",$employeeEmail)->get()[0];

        if($employeeDetails -> employment_status == "TERMINATED")
        {
          return Redirect::to('/hrm/disciplinaries/edit/'.$id)
                ->withErrors("Employee not active")
                ->withInput();
        }

        $employeeId = $employeeDetails->id;

        $disciplinary = Disciplinary::find($id);

        $disciplinary -> type_of_warning = Input::get("type_of_warning");
        $disciplinary -> action_taken = Input::get("action_taken");

        if(Input::get("action_taken") == "SUSPENSION")
        {
          $disciplinary -> suspension_number_of_days = (Input::get("suspension_number_of_days") == "" ? null : Input::get("suspension_number_of_days"));
        }
        else
        {
          $disciplinary -> suspension_number_of_days = null;
        }

        $disciplinary -> offense = (Input::get("offense") == "" ? null : Input::get("offense"));

        $disciplinary -> employee_id = $employeeId;

        $disciplinary -> push();

        Session::flash('message', 'Disciplinary Record Updated');
        return Redirect::to("/hrm/disciplinaries");
      }
      else
      {
        return Redirect::to('/hrm/disciplinaries/edit/'.$id)
              ->withErrors("Employee not found")
              ->withInput();
      }
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function view($id)
  {
    if(self::checkUserPermissions("hrm_disciplinary_can_view"))
		{
      $disciplinary = Disciplinary::find($id);

			$data['title'] = "View Disciplinary Record";
			$data['activeLink'] = "discipline";
			$data['subTitle'] = "View Disciplinary / Grievance Record Details";
			$data['disciplinary'] = $disciplinary;

			$data['subLinks'] = array(
        array
	      (
	        "title" => "Disciplinary Records",
					"route" => "/hrm/disciplinaries",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_disciplinary_can_view"
	      ),
				array
	      (
          "title" => "Add Disciplinary Record",
          "route" => "/hrm/disciplinaries/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_disciplinary_can_add"
	      ),
				array
				(
					"title" => "Edit Disciplinary Record",
					"route" => "/hrm/disciplinaries/edit/".$id,
					"icon" => "<i class='fa fa-pencil'></i>",
					"permission" => "hrm_disciplinary_can_edit"
				),
				array
				(
					"title" => "Delete Disciplinary Record",
					"route" => "/hrm/disciplinaries/delete/".$id,
					"icon" => "<i class = 'fa fa-trash'></i>",
					"permission" => "hrm_disciplinary_can_delete"
				)
			);


			return view('dashboard.hrm.disciplinaries.view',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function delete($id)
  {
    if(self::checkUserPermissions("hrm_disciplinary_can_delete"))
    {
      $disciplinary = Disciplinary::find($id);

      $disciplinary -> delete();

      Session::flash('message', 'Disciplinary Record deleted');
      return Redirect::to("/hrm/disciplinaries");
    }
    else
    {
      return "You are not authorized";die();
    }
  }

}
