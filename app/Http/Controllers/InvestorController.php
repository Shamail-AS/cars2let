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
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Log;


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
        $investor->acc_period_start = $request->input('acc_period_start');
        $investor->acc_period_end = $request->input('acc_period_end');
        $investor->phone = $request->input('phone');
        $investor->tracking_url = $request->input('tracking_url');
        $investor->save();
        return;
    }

    public function api_revenues($id)
    {
        return Investor::find($id)->allRevenues;
    }

    public function api_cars($id)
    {
        $carList = Investor::find($id)->cars;
        $carList->each(function ($car) {
            $car->available = Carbon::parse($car->available_since)->toFormattedDateString();
            $car->currentContract = $car->currentContract;
            $car->totalContracts = $car->totalContracts;
            $car->totalRevenue = $car->totalRevenue;
            $car->totalRent = $car->totalRent;

        });
        return $carList;
    }

    public function api_contracts($id)
    {
        return Investor::find($id)->contracts()->with('car', 'driver', 'handovers')->get();
    }

    public function api_drivers($id)
    {
        return Investor::find($id)->drivers;
    }


    //-----------------//

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
        $acc_periods = $investor->getAccountingPeriods();
        $next_acc_periods = $investor->getAccountingPeriods(1);
        return view('investor.home', compact('investor', 'acc_periods', 'next_acc_periods'));
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
        $investorList = Investor::orderBy('created_at', 'desc')->get();
        return view('admin.investor.index',compact('investorList'));
    }

    public function show($id)
    {
        if (Auth::user()->isAdmin)
            return view('admin.investor.show');
        else {
            return view('investor.show');
        }
    }
    public function create()
    {
        return view('admin.investor.create');
    }
    public function store(RegisterInvestorRequest $request)
    {

        $mono = Log::getMonolog();
        $mono->pushHandler(new \Monolog\Handler\FirePHPHandler());
        $mono->addInfo("Investor store", $request->all());


        $investor = Investor::create($request->all());
        if (!$request->has('name')) {
            $investor->name = explode("@", $request->input('email'), 1)[0];
        }

        $user = User::create([
            'email'=>$request->input('email'),
            'password'=>bcrypt('sample'),
            'status'=>'new',
            'type'=>'investor'
        ]);
        $user->save();

        $activator = AccountActivation::create([
            'email'=>$request->input('email'),
            'code' => random_int(1000, 9999)
        ]);
        $activator->save();


        return view('emails.firstPassword',compact('email'));

    }

    public function admin_store(RegisterInvestorRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        $mono = Log::getMonolog();
        $mono->pushHandler(new \Monolog\Handler\FirePHPHandler());
        $mono->addInfo("Investor store", $request->all());

        Investor::create($request->all());

        if ($user == null) {
            User::create([
                'email' => $request->input('email'),
                'password' => bcrypt('sample'),
                'status' => 'new',
                'type' => 'investor'
            ]);
        } else {
            $user->type = 'investor';
            $user->save();
        }

        $activator = AccountActivation::create([
            'delivered_to' => $request->input('email'),
            'active' => true,
            'destination' => 'email',
            'source' => 'admin'
        ]);
        $activator->renew();
        $activator->send();

        return redirect(url('/admin/investor/all'));
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
        $email = $request->input('email');
        $activator = AccountActivation::where('code', $token)->valid()->for($email)->latest();
        if (!isset($activator))
            return redirect('/');
        $user = User::where('email', $email)->first();
        $user->password = bcrypt($request->input('password'));
        $user->status = 'active';

        $user->save();
        $activator->deactivate();

        if (Auth::attempt(['email' => $user->email, 'password' => $request->input('password')])) {
            return redirect(url('/home'));
        } else {
            return redirect(url('/auth/login'));
        }

    }

    public function messageAdmin(Request $request)
    {
        $this->validate($request, [
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
            return redirect(url('/help'))->with("captcha_error", "Invalid Captcha");

        $investor = Auth::user()->investor;
        $admin = User::is('admin')->active()->orderBy('created_at', 'desc')->first();
        $emails = [
            'admin' => $admin->email,
            'investor' => $investor->email
        ];

        Mail::send('emails.helpInvestor', ['question' => $request->input('message'), 'investor' => $investor], function ($m) use ($emails) {
            $m->from('support@cars2let.com', 'Cars2Let Investor Support');
            $m->cc($emails['investor']);
            $m->to($emails['admin'])->subject('An Investor needs help');
        });

        return redirect('/investor');
    }
}
