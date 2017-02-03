<?php

namespace App\Http\Controllers;

use App\AccountActivation;
use App\Http\Requests\VerifyCodeRequest;
use App\Investor;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Auth;
use Session;

class MyAuthController extends Controller
{
    //

    public function api_authUser()
    {
        return Auth::user();
    }
    public function getlogin()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        if(Auth::attepmt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
            dd(Auth::user());
        }
        else
        {

        }
    }

    //USED WHEN INVESTORS GET SENT THEIR FIRST CODE
    public function sendCode(Request $request)
    {
        $email = $request->session()->get('email');
        if (!$email) return redirect(url('/myregister'));

        $activator = AccountActivation::valid()->for($email)->latest()->first();
        if (isset($activator))
        {
            $activator->renew();
            $activator->destination = $request->input('sendTo') == 'email' ? 'email' : 'phone';
        }
        else
        {
            $activator = AccountActivation::create([
                'delivered_to' => $email,
                'active' => true,
                'destination' => $request->input('sendTo') == 'email' ? 'email' : 'phone',
                'source' => 'self'
            ]);
            $activator->renew();
        }

        $activator->send();

        return redirect(url('/code/verify'));
    }


    public function reset()
    {
        $user = Auth::user();
        if ($user->isDisabled)
            return redirect('/disabled');

        $user->status = 'new';
        $user->save();

        $activator = AccountActivation::create([
            'delivered_to' => $user->email,
            'active' => true,
            'destination' => 'email',
            'source' => 'forgot'
        ]);
        $activator->renew();
        $activator->send();

        Auth::logout();
        return redirect(url('/code/verify'));
    }

    public function passwordChange(){
        return view('auth.passwords.reset-password');
    }
    public function passwordUpdate(Request $request){
        $user = Auth::user();
        if ($user->isDisabled)
            return redirect('/disabled');
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'old_password' => 'required|old_password:' . Auth::user()->password
        ],['old_password'=>'The :attribute is incorrect']);
        

        if ($validator->fails()) {
            return redirect('change/password')
                        ->withErrors($validator)
                        ->withInput();
        }
        $user->password = bcrypt($request->password);
        $user->save();
        Auth::logout();
        return redirect('/login');
    }
    public function resendCode(Request $request)
    {
        $email = $request->session()->get('email');
        $activation = AccountActivation::valid()->for($email)->latest();
        $activation->renew();
        $activation->send();
    }

    //USED WHEN INVESTORS OPEN LINK IN EMAIL
    public function verifyToken($token)
    {
        $activator = AccountActivation::where('code', $token)->valid()->first();
        if (isset($activator)) {
            $dest = $activator->delivered_to;
            if ($activator->destination == 'email')
                $user = User::where('email', $dest)->first();
            else
                $user = User::where('phone', $dest)->first();

            if (isset($user)) {
                if ($user->type == 'driver') {
                    $user->status = 'active';
                    $adminEmails = User::is(['admin', 'super-admin'])->active()->get()->pluck('email')->all();
                    $activator->sendActivationNotification($adminEmails);
                    $activator->deactivate();
                    return redirect('/');
                }
                return view('auth.passwords.firstTimePassword', compact('dest', 'token'));
            } else {
                if ($activator->destination == 'email')
                    return redirect(url('register'))->withInput(['email' => $dest]);
                else
                    return redirect(url('register'))->withInput(['phone' => $dest]);


            }
        } else {
            return redirect(url('/'));
        }
    }

    //USED WHEN INVESTORS SIGN UP THEMSELVES
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'g-recaptcha-response' => 'required'
        ]);

        $client = new Client();
        $captcha_response = $client->post('https://www.google.com/recaptcha/api/siteverify',
            [
                'query' => [
                    'secret' => '6Ld39AkUAAAAAMboW5zfWXIZ2N1bBZ4VJCPCO2Yx',
                    'response' => $request->input('g-recaptcha-response')
                ]
            ]);
        $body = \GuzzleHttp\json_decode($captcha_response->getBody()->getContents());

        if (!$body->success)
            return redirect()->back()->with("captcha_error", "Invalid user");

        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if ($user == null) {
            $request->session()->put('email', $request->input('email'));
            return redirect(url('/code/destination'));
        } else {
            return redirect()->back()->with('error', 'An account already exists for this email. Please go to the login form, you may reset your password there if you have forgotten it.');
        }

    }
}
