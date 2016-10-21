<?php

namespace App\Http\Controllers;

use App\AccountActivation;
use App\Http\Requests\VerifyCodeRequest;
use App\Investor;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Session;

class MyAuthController extends Controller
{
    //
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


    public function resendCode(Request $request)
    {
        $email = $request->session()->get('email');
        $activation = AccountActivation::valid()->for($email)->latest();
        $activation->renew();
        $activation->send();
    }

    //MANUAL ENTRY OF CODE
    //TODO : REMOVE THIS FUNCTION USE URL based AUTH INSTEAD
    public function verifyCode(VerifyCodeRequest $request)
    {
        $email = $request->session()->get('email');

        $activator = AccountActivation::valid()->for($email)->latest()->first();

        $expected_code = $activator->code;
        $actual_code = $request->input('code');

        if($actual_code == $expected_code)
        {
            $user = User::where('email', $email)->first();
            if (isset($user)) {

                //$activator->deactivate();
                return view('auth.passwords.firstTimePassword', compact('email', 'actual_code'));
            } else {
                return redirect(url('register'))->withInput(['email' => $email]);
            }
        }
        else{
            $request->session()->flash('code_mismatch','The provided code doesn\'t match');
            return view('auth.verify');
        }
    }

//    public function check(Request $request)
//    {
//
//        $investor = Investor::where('email','=',$request->input('email'))->first();
//
//        if(is_null($investor))
//        {
//            return view('errors.investorNotFound',['message' => 'Sorry, but you are not a known investor.']);
//        }
//        $matches = false;
//        if(strlen($request->input('passport_num')) > 0 || strlen($request->input('licence_num')) > 0 ) {
//            $matches = $investor->passport_num == $request->input('passport_num')
//                || $investor->passport_num == $request->input('passport_num');
//
//        }
//
//
//        if(!$matches)
//        {
//            $request->session()->flash('detail_mismatch','Your details don\'t match our records.');
//            return redirect(url('/myregister'))->withInput();
//        }
//        else
//        {
//            $request->session()->put('investor',$investor);
//            return redirect(url('/code/destination'));
//        }
//
//    }

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

                //$activator->deactivate();
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

    public function register(Request $request)
    {
        $request->session()->put('email', $request->input('email'));
        return redirect(url('/code/destination'));
    }
}
