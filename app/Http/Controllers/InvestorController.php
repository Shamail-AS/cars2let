<?php

namespace App\Http\Controllers;

use App\AccountActivation;
use App\Car;
use App\Contract;
use App\Driver;
use App\Http\Requests\RegisterInvestorRequest;
use App\Investor;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
    //

    public function RevenueSummary()
    {
        $investor = Auth::user()->investor;
        $cars = $investor->cars()->count();
        $contracts = $investor->contracts()->count();
        $drivers = count($investor->drivers);

    }
    public function AssetsSummary()
    {
        $investor = Auth::user()->investor;
        $cars = $investor->cars()->count();
        $contracts = $investor->contracts()->count();
        $drivers = count($investor->drivers);

        return [
            'cars' => $cars,
            'contracts' => $contracts,
            'drivers' => $drivers,
        ];
    }

    public function home()
    {
        $investor = Auth::user()->investor;
        return view('investor.home',compact('investor'));
    }
    public function cars()
    {
        $cars = Auth::user()->investor->cars()->orderBy('created_at','desc')->get();
        return view('investor.cars',compact('cars'));
    }
    public function contracts()
    {
        return view('investor.assets.contract.details');
    }
    public function drivers()
    {
        $drivers = Auth::user()->investor->drivers->sortByDesc('created_at');
        return view('investor.assets.driver.all',compact('drivers'));
    }
    public function reports()
    {
        return view('investor.reports');
    }
    public function index()
    {
        $investorList = Investor::all();
        return view('admin.investor.index',compact('investorList'));
    }
    public function create()
    {
        return view('admin.investor.create');
    }
    public function store(RegisterInvestorRequest $request)
    {
        $investor = Investor::create($request->all());

        $user = User::create([
            'email'=>$request->input('email'),
            'password'=>bcrypt('sample'),
            'status'=>'new',
            'type'=>'investor'
        ]);
        $user->save();

        $activator = AccountActivation::create([
            'email'=>$request->input('email'),
            'code' => $this->getToken()
        ]);
        $activator->save();

        $email = $this->getWelcomeEmail($investor,$activator);

        return view('emails.firstPassword',compact('email'));

    }

    private function getToken()
    {
        return $this->GUID();
    }
    private function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
    private function getWelcomeEmail($investor,$activator)
    {
        $activationURL = url('/activate/email/'.$activator->code);

        $email = "Welcome to cars2let, ".$investor->name
                    ."please click the link below to activate your account
                    <a href='$activationURL'>Activate now</a>";
        return $email;
    }

    public function activate($token)
    {
        $activator = AccountActivation::valid()->latest();
        if($token == $activator->code)
        {
            $user = $activator->user;

            $user->status = 'first-time-password-change-pending';
            $user->save();
            return view('auth.passwords.firstTimePassword',compact('token'));
        }
        else
        {

        }
    }
    public function resetFirstTimePassword(Request $request)
    {
        $this->validate($request,[
            'password'=>'confirmed|min:6|same:password_confirmation'
        ]);

        $token = $request->input('token');
        $user = AccountActivation::where('code','=',$token)->valid()->latest()->user;
        $user->password = bcrypt($request->input('password'));
        $user->status = 'active';
        $user->save();
        AccountActivation::where('code','=',$token)->delete();

        if(Auth::attempt(['email'=>$user->email,'password'=>$request->input('password')]))
        {
            return redirect(url('/home'));
        }
        else
        {
            return redirect(url('/auth/login'));
        }

    }
}
