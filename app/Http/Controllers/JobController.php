<?php namespace App\Http\Controllers;

use App\Role;
use App\Job;
use App\Department;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class JobController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("hrm_job_can_view"))
		{
      $data['title'] = "Jobs";
      $data['activeLink'] = "job";
      $data['jobs'] = Job::orderBy("updated_at","DESC")->paginate(20);

      $data['subLinks'] = array(
        array
        (
          "title" => "Add Job",
          "route" => "/hrm/jobs/add",
          "icon" => "<i class='fa fa-plus'></i>",
          "permission" => "hrm_job_can_add"
        ),
        array
        (
          "title" => "Search for job",
          "icon" => "<i class='fa fa-search'></i>",
          "permission" => "hrm_job_can_search"
        )
      );


      return view('dashboard.hrm.jobs.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function add()
  {
    if(self::checkUserPermissions("hrm_job_can_add"))
		{
      $data['title'] = "Add Job";
      $data['activeLink'] = "job";
      $data['subLinks'] = array(
        array
        (
          "title" => "Job List",
          "route" => "/hrm/jobs",
          "icon" => "<i class='fa fa-th-list'></i>",
          "permission" => "hrm_job_can_view"
        )
      );

      //Obtain list of roles
      $departments = \DB::table("departments")->orderBy("department_name","ASC")->get();
      $departments_array = array();

      foreach ($departments as $department) {
        $departments_array[$department->id] = $department->department_name;
      }

      $data['departments'] = $departments_array;

      return view('dashboard.hrm.jobs.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function create()
  {
    if(self::checkUserPermissions("hrm_job_can_add"))
		{
      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/jobs/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
        $job = new Job;

        $job -> job_title = Input::get("job_title");
        $job -> department_id = Input::get("department");

        $job -> save();
				Session::flash('message','Job Added');
				return Redirect::to('/hrm/jobs');
      }
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function edit($id)
  {
    if(self::checkUserPermissions("hrm_job_can_edit"))
		{
      $job = Job::find($id);

			$data['title'] = "Edit Job";
			$data['activeLink'] = "job";
			$data['subLinks'] = array(
				array
				(
					"title" => "Job List",
					"route" => "/hrm/jobs",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_job_can_view"
				)
			);
			$data['job'] = $job;

			//Obtain list of roles
			$departments = Department::all();
			$departments_array = array();

			foreach ($departments as $department) {
			     $departments_array[$department->id] = $department->department_name;
			}

			$data['departments'] = $departments_array;
			$data['jobs_department'] = Department::where('id','=',$job -> department_id)->first();

			return view('dashboard.hrm.jobs.edit',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function update($id)
  {
    if(self::checkUserPermissions("hrm_job_can_edit"))
		{
      $job = Job::find($id);

      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/jobs/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}
			else
			{
        $job -> job_title = Input::get("job_title");
        $job -> department_id = Input::get("department");

        $job -> push();
				Session::flash('message','Job updated');
				return Redirect::to('/hrm/jobs');
      }
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function delete($id)
	{
		if(self::checkUserPermissions("hrm_job_can_delete"))
		{
			$job = Job::find($id);

	    $job -> delete();

	    Session::flash('message', 'Job deleted');
			return Redirect::to("/hrm/jobs");
		}
		else
		{
			return "You are not authorized";die();
		}
	}

  public function getRules()
	{
		return array(
			'job_title' => 'required',
			'department' => 'required'
		);

	}

}
