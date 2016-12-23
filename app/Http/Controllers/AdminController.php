<?php

namespace App\Http\Controllers;

use App\AccountActivation;
use App\Http\Requests\RegisterUserRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    // API FUNCTIONS

    public function api_all()
    {
        return User::all();
    }

    public function api_get($id)
    {
        return User::find($id);
    }

    public function api_update(Request $request)
    {
        $user = User::find($request->input('id'));

        $user->email = $request->input('email');
        $user->status = $request->input('status');
        $user->type = $request->input('type');
        $user->access_level = $request->input('access_level');

        $user->save();

        return response("Update success");

    }

    public function api_reset_pass($id)
    {
        $user = User::find($id);
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

        return response("Password reset link sent");
    }


    public function api_delete($id)
    {
        User::destroy($id);
        return response("Deleted");
    }

    //--------------------------------------------//
    public function home()
    {
        return view('admin.home');
    }
    public function index()
    {
        $admins = User::is('admin')->get();
        return view('admin.index',compact('admins'));
    }
    public function create()
    {
        return  view('admin.create');
    }

    public function store(RegisterUserRequest $request)
    {
        dd($request->all());
        $user = User::where('email', $request->input('email'))->first();

        if($user == null)
        {

            $user = User::create($request->all());
            $user->status = 'new';
            $user->password = bcrypt('sample');
            $user->save();


            $activator = AccountActivation::create([
                'delivered_to' => $user->email,
                'active' => true,
                'destination' => 'email',
                'source' => 'admin'
            ]);
            $activator->renew();
            $activator->send();
        }
        return redirect(url('/super/admin/all'));
    }
}
