<?php

namespace App\Http\Controllers\Auth;

use App\AccountActivation;
use App\Investor;
use App\User;
use Validator;
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
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
        $in = Investor::create([
            'email' => $data['email'],
            'name' => $data['name'],
        ]);

        $activator = AccountActivation::where('delivered_to', $in->email)->valid()->first();
        $adminEmails = User::is(['admin', 'super-admin'])->active()->get()->pluck('email')->all();
        $activator->sendActivationNotification($adminEmails);
        $activator->deactivate();


        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => 'active',
            'access_level' => 'full',
            'type' => 'investor'
        ]);

    }


}
