<?php

namespace App\Http\Controllers;

use App\Camera;
use App\PartOrder;
use App\Sim;
use App\Tracker;
use Illuminate\Http\Request;

use App\Http\Requests;

class PartOrderController extends Controller
{
    //

    public function api_new(Request $request, $item_type, $id)
    {
        $item = null;
        if ($item_type == 'tracker')
            $item = Tracker::find($id);
        if ($item_type == 'camera')
            $item = Camera::find($id);
        if ($item_type == 'sim')
            $item = Sim::find($id);

        if ($item == null)
            return response("Invalid item type or Item not found");

        $partOrder = PartOrder::firstOrCreate($request->all());
        $partOrder->supplier_id = $item->supplier_id;
        $item->orders()->save($partOrder);
        $partOrder->supplier = $partOrder->supplier;
        return $partOrder;
    }

    public function api_get($id)
    {
        return PartOrder::with('deliveries')->where('id', $id)->get()->first();
    }

    public function api_update(Request $request, $order_id)
    {
        $order = PartOrder::find($order_id);
        if ($order == null)
            return response("Order not found", 404);
        else {
            $order->supplier_id = $request->has('supplier_id') ? $request->supplier_id : $order->supplier_id;
            $order->status = $request->has('status') ? $request->status : $order->status;
            $order->cost = $request->has('cost') ? $request->cost : $order->cost;
            $order->auth_user = $request->has('auth_user') ? $request->auth_user : $order->auth_user;
            $order->comments = $request->has('comments') ? $request->comments : $order->comments;
            $order->save();
            return $order;
        }
    }

    public function api_deliveries($id)
    {
        return PartOrder::find($id)->deliveries;
    }
}
