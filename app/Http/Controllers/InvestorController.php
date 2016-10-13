<?php

namespace App\Http\Controllers;

use App\AccountActivation;
use App\Car;
use App\Contract;
use App\Driver;
use App\Http\Requests\RegisterInvestorRequest;
use App\Investor;
use App\Revenue;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
    //
    //API METHODS

    public function api_all()
    {
        return Investor::all();
    }

    public function api_get($id)
    {

        $investor = Investor::where('id', $id)->with('cars', 'contracts', 'contracts.driver', 'contracts.car')->first();
        $investor->cars = $investor->cars->each(function ($car) {
            $car->available = Carbon::parse($car->available_since)->toFormattedDateString();
            $car->currentContract = $car->currentContract;
            $car->totalContracts = $car->totalContracts;
            $car->totalRevenue = $car->totalRevenue;
            $car->totalRent = $car->totalRent;

        });
        $investor->drivers = $investor->drivers;
        $investor->revenues = $investor->allRevenues;

        return $investor;
    }

    public function api_update(Request $request)
    {
        $investor = Investor::find($request->input('id'));
        $investor->email = $request->input('email');
        $investor->name = $request->input('name');
        $investor->passport_num = $request->input('passport_num');
        $investor->dob = $request->input('dob');
        $investor->phone = $request->input('phone');
        $investor->save();
        return;
    }

    public function api_revenues($id)
    {
        return Investor::find($id)->allRevenues;
    }

    public function api_cars($id)
    {
        return Investor::find($id)->cars;
    }

    public function api_contracts($id)
    {
        return Investor::find($id)->contracts()->with('car', 'driver')->get();
    }

    public function api_drivers($id)
    {
        return Investor::find($id)->drivers;
    }


    //-----------------//

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

    public function show($id)
    {
        return view('admin.investor.show');
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
