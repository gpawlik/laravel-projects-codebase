<?php namespace App\Http\Controllers;

use App\Rank;
use App\Permission;
use Validator;
use Image;
use Hash;
use Session;
use Input;
use Redirect;
use Response;
use Auth;


class RankController extends Controller {

	public function index()
	{
		if(self::checkUserPermissions("hrm_rank_can_view"))
		{
      $data['title'] = "Ranks";
			$data['activeLink'] = "rank";
	    $data['ranks'] = Rank::orderBy("updated_at","DESC")->paginate(20);
			$data['subLinks'] = array(
				array
				(
					"title" => "Add Rank",
					"route" => "/hrm/ranks/add",
					"icon" => "<i class='fa fa-plus'></i>",
					"permission" => "hrm_rank_can_add"
				),
				array
				(
					"title" => "Search for rank",
					"icon" => "<i class='fa fa-search'></i>",
					"permission" => "hrm_rank_can_search"
				)
			);

			return view('dashboard.hrm.ranks.index',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function add()
  {
    if(self::checkUserPermissions("hrm_rank_can_add"))
		{
      $data['title'] = "Add Rank";
			$data['activeLink'] = "rank";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Rank List",
	        "route" => "/hrm/ranks",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_rank_can_view"
	      )
	    );

			return view('dashboard.hrm.ranks.add',$data);
    }
    else
    {
        return "You are not authorized";die();
    }
  }

  public function create()
  {
    if(self::checkUserPermissions("hrm_rank_can_add"))
		{
      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/ranks/add')
							->withErrors($validator)
							->withInput();
			}
			else
			{
        $rank = new Rank;

        $rank -> rank_code = Input::get("rank_code");
        $rank -> rank_name = Input::get("rank_name");

        $rank -> save();
        Session::flash('message','Rank Added');
				return Redirect::to('/hrm/ranks');
      }

    }
    else
    {
        return "You are not authorized";die();
    }

  }

  public function edit($id)
  {
    if(self::checkUserPermissions("hrm_rank_can_edit"))
		{
	    $rank = Rank::find($id);

	    $data['title'] = "Edit Rank";
			$data['activeLink'] = "rank";
	    $data['subLinks'] = array(
	      array
	      (
	        "title" => "Rank List",
	        "route" => "/hrm/ranks",
	        "icon" => "<i class='fa fa-th-list'></i>",
					"permission" => "hrm_rank_can_view"
	      )
	    );
	    $data['rank'] = $rank;

	    return view('dashboard.hrm.ranks.edit',$data);
		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function update($id)
  {
    if(self::checkUserPermissions("hrm_rank_can_edit"))
		{
      $rank = Rank::find($id);

      $rules = self::getRules();

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::to('/hrm/ranks/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}
			else
			{
        $rank -> rank_code = Input::get("rank_code");
        $rank -> rank_name = Input::get("rank_name");

        $rank -> push();
        Session::flash('message','Rank Details Updated');
				return Redirect::to('/hrm/ranks');
      }

		}
		else
		{
			return "You are not authorized";die();
		}
  }

  public function view($id)
  {
    if(self::checkUserPermissions("hrm_rank_can_view"))
		{
			$rank = Rank::find($id);

			$data['title'] = "View Rank Details";
			$data['activeLink'] = "rank";
			$data['subLinks'] = array(
					array
					(
						"title" => "Rank List",
						"route" => "/hrm/ranks",
						"icon" => "<i class='fa fa-th-list'></i>",
						"permission" => "hrm_rank_can_view"
					),
					array
					(
						"title" => "Add Rank",
						"route" => "/hrm/ranks/add",
						"icon" => "<i class='fa fa-plus'></i>",
						"permission" => "hrm_rank_can_add"
					)
				);

				$data['rank'] = $rank;

				return view('dashboard.hrm.ranks.view',$data);
			}
			else
			{
				return "You are not authorized";die();
			}
  }

  public function delete($id)
  {
		if(self::checkUserPermissions("hrm_rank_can_delete"))
		{
		    $rank = Rank::find($id);

        $rank -> delete();

				Session::flash('message', 'Rank deleted');
				return Redirect::to("/hrm/ranks");
		}
		else
		{
			return "You are not authorized";die();
		}

  }


  public function getRules()
  {
    return array(
      'rank_code' => 'required',
      'rank_name' => 'required'
    );

  }


}
