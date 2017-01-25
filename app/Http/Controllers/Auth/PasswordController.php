<?php

namespace App\Http\Controllers\Auth;

use App\AccountActivation;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //USED BY INVESTORS, AFTER THEY ENTER THEIR EMAIL
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ]);
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        $user->status = 'new';
        $user->save();

        $activator = AccountActivation::create([
            'delivered_to' => $email,
            'active' => true,
            'destination' => 'email',
            'source' => 'forgot'
        ]);
        $activator->renew();
        $activator->send();

        return redirect(url('/code/verify'));
    }
}
