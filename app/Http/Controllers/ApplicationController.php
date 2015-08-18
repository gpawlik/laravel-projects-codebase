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
					"route" => "/hrm/applications/search",
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

				$application -> save();
				Session::flash('message','Job Application Added');
				return Redirect::to('/hrm/applications');
			}
    }
    else
    {
        return "You are not authorized";die();
    }
	}

	public function edit($id)
	{
		if(self::checkUserPermissions("hrm_application_can_edit"))
		{
			$application = Application::find($id);

			$data['title'] = "Edit Application";
			$data['activeLink'] = "application";
			$data['subLinks'] = array(
        array
        (
          "title" => "Application List",
          "route" => "/hrm/applications",
          "icon" => "<i class='fa fa-th-list'></i>",
          "permission" => "hrm_application_can_view"
        )
      );

			$data['application'] = $application;

			return view('dashboard.hrm.applications.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function update($id)
	{
		if(self::checkUserPermissions("hrm_application_can_edit"))
		{
			$application = Application::find($id);

			$rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/applications/edit/'.$id)
	        		->withErrors($validator)
	        		->withInput();
			}
	    else
	    {
				$fileDestinationPath = public_path('uploads/');

				//handle CV file upload
				if(Input::file(('applicant_cv_file_name')))
	      {
	          if($application -> applicant_cv_file_name != null)
	          {
	            if (file_exists(public_path('uploads/'.$application -> applicant_cv_file_name)))
	        		{
	              unlink(public_path('uploads/'.$application -> applicant_cv_file_name));
	        		}
	          }

						$cvFile = Input::file("applicant_cv_file_name");
						$cvFileName = Input::get("applicant_first_name")."_".Input::get("applicant_last_name")."_CV_".$cvFile -> getClientOriginalName();

						$cvFile -> move($fileDestinationPath, $cvFileName);

						$application -> applicant_cv_file_name = $cvFileName;

	      }
	      else
	      {
					if(Input::get("cv_delete_check") == 'yes')
	        {
	          if(file_exists(public_path('uploads/'.$application -> applicant_cv_file_name)))
	          {
	            unlink(public_path('uploads/'.$application -> applicant_cv_file_name));
	          }
	          $application -> applicant_cv_file_name = null;
	        }
				}

				//handle letter file upload
				if(Input::file(('applicant_letter_file_name')))
				{
						if($application -> applicant_letter_file_name != null)
						{
							if (file_exists(public_path('uploads/'.$application -> applicant_letter_file_name)))
							{
								unlink(public_path('uploads/'.$application -> applicant_letter_file_name));
							}
						}

						$letterFile = Input::file("applicant_letter_file_name");
						$letterFileName = Input::get("applicant_first_name")."_".Input::get("applicant_last_name")."_CV_".$letterFile -> getClientOriginalName();

						$letterFile -> move($fileDestinationPath, $letterFileName);

						$application -> applicant_letter_file_name = $letterFileName;

				}
				else
				{
					if(Input::get("letter_delete_check") == 'yes')
					{
						if(file_exists(public_path('uploads/'.$application -> applicant_letter_file_name)))
						{
							unlink(public_path('uploads/'.$application -> applicant_letter_file_name));
						}
						$application -> applicant_letter_file_name = null;
					}
				}

				$application -> applicant_first_name = Input::get("applicant_first_name");
				$application -> applicant_last_name = Input::get("applicant_last_name");
				$application -> applicant_email = Input::get("applicant_email");
				$application -> applicant_contact_number = Input::get("applicant_contact_number");
				$application -> application_date = Input::get("application_date");

				if(Input::get("applicant_interview_date"))
				{
					$application -> applicant_interview_date = Input::get("applicant_interview_date");
				}
				else
				{
					$application -> applicant_interview_date = null;
				}

				$application -> push();
				Session::flash('message','Job Application Updated');
				return Redirect::to('/hrm/applications');

			}
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function view($id)
	{
		if(self::checkUserPermissions("hrm_application_can_view"))
		{
			$application = Application::find($id);

			$data['title'] = "View Application Details";
			$data['activeLink'] = "application";
			$data['subLinks'] = array(
				array
				(
					"title" => "Application List",
					"route" => "/hrm/applications",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_application_can_view"
				),
				array
				(
					"title" => "Add Application",
					"route" => "/hrm/applications/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_application_can_add"
				),
				array
				(
					"title" => "Edit Application",
					"route" => "/hrm/applications/edit/".$id,
					"icon" => "<i class='fa fa-pencil'></i>",
					"permission" => "hrm_application_can_edit"
				),
				array
				(
					"title" => "Delete Application",
					"route" => "/hrm/application/delete/".$id,
					"icon" => "<i class = 'fa fa-trash'></i>",
					"permission" => "hrm_application_can_delete"
				),
				array(
          "title" => "Accept Application",
					"route" => "/hrm/applications/accept_application/".$id,
          "icon" => "<i class='fa fa-check-circle'></i>",
          "permission" => "hrm_application_can_accept"
        ),
        array(
          "title" => "Decline Application",
					"route" => "/hrm/applications/decline_application/".$id,
          "icon" => "<i class='fa fa-undo'></i>",
          "permission" => "hrm_application_can_decline"
        )
			);
			$data['application'] = $application;

			return view('dashboard.hrm.applications.view',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function delete($id)
	{
		if(self::checkUserPermissions("hrm_application_can_delete"))
		{
			$application = Application::find($id);

	    if($application -> applicant_cv_file_name != null)
			{

	      if (file_exists(public_path('uploads/'.$application -> applicant_cv_file_name)))
	  		{
	        unlink(public_path('uploads/'.$application -> applicant_cv_file_name));
	  		}

	    }

			if($application -> applicant_letter_file_name != null)
			{

				if (file_exists(public_path('uploads/'.$application -> applicant_letter_file_name)))
				{
					unlink(public_path('uploads/'.$application -> applicant_letter_file_name));
				}

			}

	    $application -> delete();

	    Session::flash('message', 'Application deleted');
			return Redirect::to("/hrm/applications");
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function acceptApplication($id)
	{
		$application = Application::find($id);

		$application -> application_status = "ACCEPTED";
		$application -> applicant_interview_date = null;

		$application -> push();
		Session::flash('message','Job Application Accepted');
		return Redirect::to('/hrm/applications');
	}

	public function declineApplication($id)
	{
		$application = Application::find($id);

		$application -> application_status = "PENDING";

		$application -> push();
		Session::flash('message','Job Application Declined');
		return Redirect::to('/hrm/applications');
	}

	public function search()
	{
		if(self::checkUserPermissions("hrm_application_can_search"))
		{
			$data['title'] = "Search for an Application";
			$data['activeLink'] = "application";
			$data['subLinks'] = array(
				array
				(
					"title" => "Application List",
					"route" => "/hrm/applications",
					"icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_application_can_view"
				),
				array
				(
					"title" => "Add Application",
					"route" => "/hrm/applications/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_application_can_add"
				)
			);

			return view('dashboard.hrm.applications.search',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
	}

	public function apiSearch($data)
	{
		$application = \DB::table("applications")->select('id', 'applicant_first_name', 'applicant_last_name','applicant_email','application_status')
			->where("applicant_first_name","ilike","%$data%")
			->orWhere("applicant_last_name","ilike","%$data%")
			->orWhere("applicant_email","ilike","%$data%")
			->orWhere("application_status","ilike","%$data%")
			->get();
		return Response::json(
					$application
			);
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
