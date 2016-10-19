<?php

namespace App\Http\Controllers;

use App\Revenue;
use Illuminate\Http\Request;

use App\Http\Requests;

class RevenueController extends Controller
{
    // API METHODS

    public function api_all()
    {
        return Revenue::all();
    }

    public function api_get($id)
    {
        return Revenue::find($id);
    }

    public function api_update(Request $request)
    {
        $r = Revenue::find($request->input('id'));
        $r->amount_paid = (float)$request->input('amount_paid');
        $r->contract_id = $request->input('contract_id');

        $r->currency = 'GBP';

        $r->save();
        return response("Updated");
    }

    public function api_new(Request $request)
    {
        $r = new Revenue();
        $r->amount_paid = (float)$request->input('amount_paid');
        $r->contract_id = $request->input('contract_id');
        $r->currency = 'GBP';

        $r->save();
        return $r;
    }

    public function api_delete($id)
    {
        Revenue::destroy($id);
        return response("Deleted");
    }

    //---------------
}
