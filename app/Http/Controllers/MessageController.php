<?php namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Message;
use Auth;
use Validator;
use Input;
use Redirect;
use Session;
use Hash;
use Image;

class MessageController extends Controller {


	public function index()
	{
    $data['title'] = "My Messages";
		$data['messages'] = \DB::table("messages")->where("to_user_id",Auth::user()->id)->orWhere("from_user_id",Auth::user()->id)->orderBy("updated_at","DESC")->get();
    //var_dump(\DB::table("messages")->where("to_user_id",Auth::user()->id)->orWhere("from_user_id",Auth::user()->id)->orderBy("updated_at","DESC")->get());die();

		return view('dashboard.messages.index',$data);
  }

  public function add()
  {
    $data['title'] = "Send Message";

    return view('dashboard.messages.add',$data);
  }

  public function create()
  {
    $message = new Message;

    $rules = self::getRules();

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('/dashboard/messages/add')
						->withErrors($validator)
						->withInput();
		}
		else
		{
      
    }

  }

  public function getRules()
  {
    return array(
      'subject' => 'required',
      'message' => 'required',
      'to_user' => 'required'
    );
  }

}
