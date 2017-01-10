<?php

namespace App\Http\Controllers;

use App\PartDelivery;
use App\PartOrder;
use Illuminate\Http\Request;

use App\Http\Requests;

class PartDeliveryController extends Controller
{
    //
    public function api_new(Request $request, $id)
    {
        $order = null;
        $order = PartOrder::find($id);
        if ($order == null)
            return response("Invalid item type or Item not found");

        $partDelivery = PartDelivery::create($request->all());
        $order->deliveries()->save($partDelivery);
        return $partDelivery;
    }

    public function api_get($id)
    {
        return PartDelivery::find($id);
    }


    public function api_update(Request $request, $delivery_id)
    {
        $delivery = PartDelivery::find($delivery_id);
        if ($delivery == null)
            return response("Delivery not found", 404);
        else {

            $delivery->scheduled_at = $request->has('scheduled_at') ? $request->scheduled_at : $delivery->scheduled_at;
            $delivery->delivered_at = $request->has('delivered_at') ? $request->delivered_at : $delivery->delivered_at;
            $delivery->received_by = $request->has('received_by') ? $request->received_by : $delivery->received_by;
            $delivery->location = $request->has('location') ? $request->location : $delivery->location;
            $delivery->comments = $request->has('comments') ? $request->comments : $delivery->comments;

            $delivery->save();
            return $delivery;
        }
    }

}
