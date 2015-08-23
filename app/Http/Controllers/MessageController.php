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
		$data['subTitle'] = "All Messages";
		$data['messages'] = \DB::table("messages")->where("to_user_id",Auth::user()->id)->orWhere("from_user_id",Auth::user()->id)->orderBy("created_at","DESC")->paginate(20);
    //var_dump(\DB::table("messages")->where("to_user_id",Auth::user()->id)->orWhere("from_user_id",Auth::user()->id)->orderBy("updated_at","DESC")->get());die();

		return view('dashboard.messages.index',$data);
  }

  public function add()
  {
    $data['title'] = "Send Message";
		$data['subTitle'] = "Send message";

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
			$toUser = Input::get("to_user");

			$toUserFirstName = array_pad(explode(" ", $toUser,3),3,null)[0];
			$toUserLastName = array_pad(explode(" ", $toUser,3),3,null)[1];
			$toUserEmail = str_replace(")","",str_replace("(", "", array_pad(explode(" ", $toUser,3),3,null)[2]));

			if($toUserEmail != null)
			{
				if(Auth::user()->email == $toUserEmail)
				{
					return Redirect::to('/dashboard/messages/add')
								->withErrors("You cannot send a message to yourself")
								->withInput();
				}
				else
				{
					$user = \DB::table("users")->where("email",$toUserEmail)->get();

					$message -> subject = Input::get("subject");
					$message -> message = Input::get("message");
					$message -> status = "UNREAD";
					$message -> to_user_id = $user[0]->id;
					$message -> from_user_id = Auth::user()->id;

					$message -> save();
					Session::flash('message','Message Sent');
					return Redirect::to('/dashboard/messages');
				}

			}
			else
			{
				return Redirect::to('/dashboard/messages/add')
							->withErrors("Recipient not found")
							->withInput();
			}

    }

  }

	public function view($id)
	{
		$message = Message::find($id);

		$data['title'] = "Read Message";
		$data['subTitle'] = "View Message";
		$data['message'] = $message;

		if($message->status == "UNREAD")
		{
			$message -> status = "READ";
			$message -> push();
		}

    return view('dashboard.messages.view',$data);
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
