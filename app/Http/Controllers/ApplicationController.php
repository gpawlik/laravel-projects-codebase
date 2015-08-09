<?php namespace App\Http\Controllers;

use App\Role;
use App\Employee;
use App\Bank;
use App\Application;
use App\Job;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class ApplicationController extends Controller {

	public function index()
	{
    if(self::checkUserPermissions("hrm_application_can_view"))
		{
      $data['title'] = "Job applications";
	    $data['applications'] = Application::orderBy("updated_at","DESC")->paginate(20);
      $data['activeLink'] = "application";
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Application",
					"route" => "/hrm/applications/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_application_can_add"
				),
				array
				(
					"title" => "Search for application",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "hrm_application_can_search"
				)
			);

      return view('dashboard.hrm.applications.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function add()
	{
    if(self::checkUserPermissions("hrm_application_can_add"))
		{
      $data['title'] = "Add Job Application";
      $data['activeLink'] = "application";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Job Application List",
					"route" => "/hrm/applications",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_application_can_view"
	      )
	    );

      return view('dashboard.hrm.applications.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

	public function create()
	{
		if(self::checkUserPermissions("hrm_application_can_add"))
		{
			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/applications/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
				$application = new Application;

				$fileDestinationPath = public_path('uploads/');

				if(Input::file("applicant_cv_file_name"))
				{
					$cvFile = Input::file("applicant_cv_file_name");
					$cvFileName = Input::get("applicant_first_name")."_".Input::get("applicant_last_name")."_CV_".$cvFile -> getClientOriginalName();

					$cvFile -> move($fileDestinationPath, $cvFileName);

					$application -> applicant_cv_file_name = $cvFileName;

				}
				else
				{
					$application -> applicant_cv_file_name = null;
				}

				if(Input::file("applicant_letter_file_name"))
				{
					$letterFile = Input::file("applicant_letter_file_name");
					$letterFileName = Input::get("applicant_first_name")."_".Input::get("applicant_last_name")."_letter_".$letterFile -> getClientOriginalName();

					$letterFile -> move($fileDestinationPath, $letterFileName);

					$application -> applicant_letter_file_name = $letterFileName;

				}
				else
				{
					$application -> applicant_letter_file_name = null;
				}

				$application -> applicant_first_name = Input::get("applicant_first_name");
				$application -> applicant_last_name = Input::get("applicant_last_name");
				$application -> applicant_email = Input::get("applicant_email");
				$application -> applicant_contact_number = Input::get("applicant_contact_number");
				$application -> application_status = "PENDING";
				$application -> application_date = Input::get("application_date");

				if(Input::get("applicant_interview_date"))
				{
					$application -> applicant_interview_date = Input::get("applicant_interview_date");
				}
				else
				{
					$application -> applicant_interview_date = null;
				}


			}
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function getRules()
	{
		return array(
			'applicant_first_name' => 'required',
			'applicant_last_name' => 'required',
			'applicant_email' => 'required',
			'applicant_contact_number' => 'required',
			'application_date' => 'required'
		);
	}

}
