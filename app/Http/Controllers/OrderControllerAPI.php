<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\order as OrderResource;
use Illuminate\Support\Facades\DB;

use App\Order;
use App\StoreOrderRequest;
use Hash;

class OrderControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return OrderResource::collection(order::paginate(5));
        } else {
            return OrderResource::collection(order::all());
        }

    }
    /*public function pending(Request $request)
    {
        return $orders = DB::table('orders')
            ->whereNotIn('state', 'delivered' /*and 'not delivered')
            ->get();

    }*/

    public function show($id)
    {
        return new OrderResource(order::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state' => 'required|in:pending,confirmed,in preparation,prepared,delivered,not delivered'
        ]);
        $order = new order();
        $order->fill($request->all());
        $order->save();
        return response()->json(new OrderResource($order), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'state' => 'required|in:pending,confirmed,in preparation,prepared,delivered,not delivered'
        ]);
        $order = order::findOrFail($id);
        $order->update($request->all());
        return new OrderResource($order);
    }

    public function destroy($id)
    {
        $order = order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }
}
