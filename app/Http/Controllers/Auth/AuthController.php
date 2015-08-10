<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

     //Redirect to after login authentication
     protected $redirectTo = "/dashboard";

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    //redefine the postLogin function to suit our needs
    public function postLogin(Request $request)
     {
         $this->validate($request, [
             'username' => 'required', 'password' => 'required',
         ]);

         $credentials = $this->getCredentials($request);

         if (Auth::attempt($credentials, $request->has('remember'))) {
             return redirect()->intended($this->redirectPath());
         }

         return redirect($this->loginPath())
             ->withInput($request->only('username', 'remember'))
             ->withErrors([
                 'username' => $this->getFailedLoginMessage(),
             ]);
     }

     protected function getCredentials(Request $request)
     {
         return $request->only('username', 'password');
     }

     protected function getFailedLoginMessage()
     {
         return 'Incorrect login credentials';
     }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

     //redefine validator to suit our needs too
     protected function validator(array $data)
     {
         return Validator::make($data, [
             'username' => 'required|max:255|unique:users',
             'password' => 'required|confirmed',
         ]);
     }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
     protected function create(array $data)
     {
         return User::create([
             'username' => $data['username'],
             'password' => bcrypt($data['password']),
         ]);
     }


}
