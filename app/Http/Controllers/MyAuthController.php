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

    public function apiVerifyCode($code)
    {
        $user = Auth::user();
        $expectedCode = $user->codes()->latest();
        if($expectedCode != $code)
        {
            return "Sorry, but the codes don't match";
        }
        else
        {
            $user->active = 1;
            $user->save();
            return "Success";
        }
    }
    //
    public function getlogin()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        if(Auth::attepmt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {

        }
        else
        {

        }
    }

    public function sendCode(Request $request)
    {
        $investor = $request->session()->get('investor');
        if(!$investor)
            dd([$request,$investor]);


        $activator = AccountActivation::create([
            'email'=>$investor->email,
            'code' => random_int(1000,9999)
        ]);

        if($request->input('sendTo') == 'email')
        {
            $activator->sendCodeToEmail();
        }
        else
        {
            $activator->sendCodeToPhone($investor->email);
        }
        return view('auth.verify');
    }


    public function verifyCode(VerifyCodeRequest $request)
    {
        $investor = $request->session()->get('investor');

        $expected_code = AccountActivation::where('email','=',$investor->email)->orderBy('created_at','desc')->first()->code;
        $actual_code = $request->input('code');

        if($actual_code == $expected_code)
        {
            return redirect(url('register'))->withInput(['email'=>$investor->email,'name'=>$investor->name]);
        }
        else{
            $request->session()->flash('code_mismatch','The provided code doesn\'t match');
            return view('auth.verify');
        }
    }

    public function check(Request $request)
    {

        $investor = Investor::where('email','=',$request->input('email'))->first();

        if(is_null($investor))
        {
            return view('errors.investorNotFound',['message' => 'Sorry, but you are not a known investor.']);
        }
        $matches = false;
        if(strlen($request->input('passport_num')) > 0 || strlen($request->input('licence_num')) > 0 ) {
            $matches = $investor->passport_num == $request->input('passport_num')
                || $investor->passport_num == $request->input('passport_num');

        }

        
        if(!$matches)
        {
            $request->session()->flash('detail_mismatch','Your details don\'t match our records.');
            return redirect(url('/myregister'))->withInput();
        }
        else
        {
            $request->session()->put('investor',$investor);
            return redirect(url('/code/destination'));
        }

    }

    public function register(Request $request)
    {
        $investor = new Investor();
        $investor->email = $request->input('email');
        $investor->password = $request->input('pass');
        $request->session()->put('investor',$investor);
        return redirect(url('/code/destination'));
    }
}
