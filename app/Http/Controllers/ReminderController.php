<?php namespace App\Http\Controllers;

use App\Job;
use App\User;
use App\Role;
use App\Department;
use App\Employee;
use App\Reminder;
use Auth;
use Validator;
use Input;
use Redirect;
use Session;
use Hash;
use Image;

class ReminderController extends Controller {


	public function index()
	{
		$data['title'] = "My Reminders";
		$data['reminders'] = \DB::table("reminders")->where("user_id",Auth::user()->id)->orderBy("updated_at","DESC")->paginate(20);
    //var_dump(\DB::table("reminders")->where("user_id",Auth::user()->id)->orderBy("updated_at","DESC")->get());die();

		return view('dashboard.reminders.index',$data);
  }

  public function add()
  {
    $data['title'] = "Add Reminder";

    return view('dashboard.reminders.add',$data);
  }

  public function create()
  {
    $reminder = new Reminder;

    $rules = self::getRules();

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/dashboard/reminders/add')
						->withErrors($validator)
						->withInput();
		}
		else
		{

      $reminder -> note = Input::get("note");

      if(Input::get("description"))
      {
        $reminder -> description = Input::get("description");
      }
      else
      {
        $reminder -> description = null;
      }

      if(Input::get("due_date"))
      {
        $reminder -> due_date = Input::get("due_date");
      }
      else
      {
        $reminder -> due_date = null;
      }

      $reminder -> status = "PENDING";
      $reminder -> user_id = Auth::user()->id;

      $reminder->save();

      Session::flash('message', "Reminder Saved");
      return Redirect::to("/dashboard/reminders");

    }

  }

  public function edit($id)
  {
    $data['title'] = "Edit Reminder";
    $data['reminder'] = Reminder::find($id);

    return view('dashboard.reminders.edit',$data);
  }

  public function update($id)
  {
    $reminder = Reminder::find($id);

    $rules = self::getRules();

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/dashboard/reminders/edit/'.$id)
						->withErrors($validator)
						->withInput();
		}
		else
		{
      $reminder -> note = Input::get("note");

      if(Input::get("description"))
      {
        $reminder -> description = Input::get("description");
      }
      else
      {
        $reminder -> description = null;
      }

      if(Input::get("due_date"))
      {
        $reminder -> due_date = Input::get("due_date");
      }
      else
      {
        $reminder -> due_date = null;
      }

      $reminder -> status = "PENDING";
      $reminder -> user_id = Auth::user()->id;

      $reminder->push();

      Session::flash('message', "Reminder Edited");
      return Redirect::to("/dashboard/reminders");
    }

  }

  public function view($id)
  {
    $data['title'] = "View Reminder";
    $data['reminder'] = Reminder::find($id);

    return view('dashboard.reminders.view',$data);
  }

  public function delete($id)
  {
    $reminder = Reminder::find($id);

    $reminder -> delete();

    Session::flash('message', "Reminder Deleted");
    return Redirect::to("/dashboard/reminders");
  }

  public function complete($id)
  {
    $reminder = Reminder::find($id);

    $reminder -> status = "COMPLETE";

    $reminder->push();

    Session::flash('message', "Reminder Complete");
    return Redirect::to("/dashboard/reminders");
  }

  public function undoComplete($id)
  {
    $reminder = Reminder::find($id);

    $reminder -> status = "PENDING";

    $reminder->push();

    Session::flash('message', "Reminder reverted");
    return Redirect::to("/dashboard/reminders");
  }

  public function getRules()
  {
    return array(
      'note' => 'required'
    );
  }

}
