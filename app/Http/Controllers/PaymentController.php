<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Payment;
use Illuminate\Http\Request;

use App\Http\Requests;

class PaymentController extends Controller
{
    //
    public function getContractPayments($contract_id)
    {
        $contract = Contract::find($contract_id);
        if (!isset($contract))
            return response("Contract not found");
        else {
            return $contract->payments()->with('authorizedBy')->orderBy('id', 'desc')->get();
        }

    }

    public function payContract(Request $request)
    {
        $contract = Contract::find($request->contract_id);
        if (!isset($contract))
            return response("Contract not found");
        $payment = new Payment();
        $payment->amount = $request->amount;
        $payment->value_dt = $request->value_dt;
        $payment->comments = $request->comments;
        $payment->auth_user_id = \Auth::user()->id;

        $contract->payments()->save($payment);

        $payment->authorized_by = $payment->authorizedBy;
        return $payment;
    }
}
