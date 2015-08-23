<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PayGrade;
use App\Job;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;

class PayGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      if(self::checkUserPermissions("hrm_paygrade_can_view"))
      {
        $data['title'] = "Pay Grades";
        $data['activeLink'] = "paygrade";
        $data['subTitle'] = "Pay Grades";
        $data['paygrades'] = PayGrade::orderBy("updated_at","DESC")->paginate(20);

        $data['subLinks'] = array(
          array
          (
            "title" => "Add Pay Grade",
            "route" => "/hrm/pay_grades/add",
            "icon" => "<i class='fa fa-plus'></i>",
            "permission" => "hrm_paygrade_can_add"
          ),
          array
          (
            "title" => "Search for Pay Grade",
            "route" => "/hrm/pay_grades/search",
            "icon" => "<i class='fa fa-search'></i>",
            "permission" => "hrm_paygrade_can_search"
          )
        );


        return view('dashboard.hrm.paygrades.index',$data);
      }
      else
      {
          return "You are not authorized";die();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function add()
    {
      if(self::checkUserPermissions("hrm_paygrade_can_add"))
  		{
        $data['title'] = "Add Pay Grade";
        $data['activeLink'] = "paygrade";
        $data['subTitle'] = "Add Pay Grade";
        $data['subLinks'] = array(
          array
          (
            "title" => "Pay Grade List",
            "route" => "/hrm/pay_grades",
            "icon" => "<i class='fa fa-th-list'></i>",
            "permission" => "hrm_paygrade_can_view"
          )
        );

        //Obtain list of jobs
        $jobs = \DB::table("jobs")->orderBy("job_title","ASC")->get();
        $jobs_array = array();

        foreach ($jobs as $job) {
          $jobs_array[$job->id] = $job->job_title;
        }

        $data['jobs'] = $jobs_array;

        return view('dashboard.hrm.paygrades.add',$data);
      }
      else
      {
          return "You are not authorized";die();
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create()
    {
      if(self::checkUserPermissions("hrm_paygrade_can_add"))
      {
        $rules = self::getRules();

  			$validator = Validator::make(Input::all(), $rules);

  			if ($validator->fails())
  			{
  				return Redirect::to('/hrm/pay_grades/add')
  							->withErrors($validator)
  							->withInput();
  			}
  			else
  			{
          $payGrade = new PayGrade;

          $payGrade -> description = Input::get("description");
          $payGrade -> minimum_salary = Input::get("minimum_salary");
          $payGrade -> maximum_salary = Input::get("maximum_salary");
          $payGrade -> job_id = Input::get("job");

          $payGrade -> save();
  				Session::flash('message','Pay Grade Added');
  				return Redirect::to('/hrm/pay_grades');
        }
      }
      else
      {
          return "You are not authorized";die();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function view($id)
    {
      if(self::checkUserPermissions("hrm_paygrade_can_view"))
      {
        $payGrade = PayGrade::find($id);

        $data['title'] = "View Pay Grade";
        $data['activeLink'] = "paygrade";
        $data['subTitle'] = "View Pay Grade Details";
        $data['payGrade'] = $payGrade;

        $data['subLinks'] = array(
          array
  				(
  					"title" => "Pay Grade List",
  					"route" => "/hrm/pay_grades",
  					"icon" => "<i class='fa fa-th-list'></i>",
  					"permission" => "hrm_paygrade_can_view"
  				),
  				array
  				(
  					"title" => "Add Pay Grade",
  					"route" => "/hrm/pay_grades/add",
  					"icon" => "<i class='fa fa-plus'></i>",
  					"permission" => "hrm_paygrade_can_add"
  				)
        );


        return view('dashboard.hrm.paygrades.view',$data);
      }
      else
      {
          return "You are not authorized";die();
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
      if(self::checkUserPermissions("hrm_paygrade_can_edit"))
      {
        $payGrade = PayGrade::find($id);

        $data['title'] = "Edit Pay Grade";
        $data['activeLink'] = "paygrade";
        $data['subTitle'] = "Edit Pay Grade Details";
        $data['subLinks'] = array(
          array
          (
            "title" => "Pay Grade List",
            "route" => "/hrm/pay_grades",
            "icon" => "<i class='fa fa-th-list'></i>",
            "permission" => "hrm_paygrade_can_view"
          )
        );
        $data['payGrade'] = $payGrade;

        //Obtain list of jobs
        $jobs = \DB::table("jobs")->orderBy("job_title","ASC")->get();
        $jobs_array = array();

        foreach ($jobs as $job) {
          $jobs_array[$job->id] = $job->job_title;
        }

        $data['jobs'] = $jobs_array;

        $data['paygrades_job'] = Job::where('id','=',$payGrade -> job_id)->first();

        return view('dashboard.hrm.paygrades.edit',$data);
      }
      else
      {
          return "You are not authorized";die();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
      if(self::checkUserPermissions("hrm_paygrade_can_edit"))
      {
        $payGrade = PayGrade::find($id);

        $rules = self::getRules();
        $rules['description'] = "unique:pay_grades";

  			$validator = Validator::make(Input::all(), $rules);

  			if ($validator->fails())
  			{
  				return Redirect::to('/hrm/pay_grades/edit/'.$id)
  							->withErrors($validator)
  							->withInput();
  			}
  			else
  			{
          $payGrade -> description = Input::get("description");
          $payGrade -> minimum_salary = Input::get("minimum_salary");
          $payGrade -> maximum_salary = Input::get("maximum_salary");
          $payGrade -> job_id = Input::get("job");

          $payGrade -> push();
  				Session::flash('message','Pay Grade Updated');
  				return Redirect::to('/hrm/pay_grades');
        }
      }
      else
      {
        return "You are not authorized";die();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
      if(self::checkUserPermissions("hrm_paygrade_can_delete"))
      {
        $payGrade = PayGrade::find($id);

        $payGrade -> delete();

        Session::flash('message', 'Pay Grade deleted');
        return Redirect::to("/hrm/pay_grades");
      }
      else
      {
        return "You are not authorized";die();
      }
    }

    public function search()
  	{
  		if(self::checkUserPermissions("hrm_paygrade_can_search"))
  		{
  			$data['title'] = "Search for Pay Grades";
  			$data['activeLink'] = "paygrade";
        $data['subTitle'] = "Search for Pay Grade";
  			$data['subLinks'] = array(
  				array
  				(
  					"title" => "Pay Grade List",
  					"route" => "/hrm/pay_grades",
  					"icon" => "<i class='fa fa-th-list'></i>",
  					"permission" => "hrm_paygrade_can_view"
  				),
  				array
  				(
  					"title" => "Add Pay Grade",
  					"route" => "/hrm/pay_grades/add",
  					"icon" => "<i class='fa fa-plus'></i>",
  					"permission" => "hrm_paygrade_can_add"
  				)
  			);

  			return view('dashboard.hrm.paygrades.search',$data);
  		}
  		else
  		{
  			return "You are not authorized";die();
  		}
  	}

  	public function apiSearch($data)
  	{
  		$paygrades = \DB::table("pay_grades")->select("pay_grades.id","description","minimum_salary","maximum_salary","job_title")
  		->join("jobs","jobs.id","=","pay_grades.job_id")
  		->where("description","ilike","%$data%")
  		->orWhere("minimum_salary","ilike","%$data%")
  		->orWhere("maximum_salary","ilike","%$data%")
      ->orWhere("job_title","ilike","%$data%")

  		->get();
  	return Response::json(
  				$paygrades
  		);
  	}

    public function getRules()
    {
      return array(
        'description' => 'required',
        'minimum_salary' => 'required',
        'maximum_salary' => 'required',
        'job'  => 'required'
      );

    }
}
