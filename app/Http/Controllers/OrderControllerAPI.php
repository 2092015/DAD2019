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
    public function index(Request $request, $id)
    {
        if (!$id){

            if ($request->has('page')) {
                return OrderResource::collection(order::paginate(5));
            } else {
                return OrderResource::collection(order::all());
            }}
        else{
            if ($request->has('page')) {
                return OrderResource::collection(order::where('responsible_cook_id',$id)->whereIn('state', ['confirmed','in preparation','prepared'])->orderBy('start','desc')->paginate(5));
            } else {
                return OrderResource::collection(order::where('responsible_cook_id',$id)->whereIn('state', ['confirmed','in preparation','prepared'])->orderBy('start','desc')->get());

            }}

    }


    public function pending(Request $request)
    {
        if ($request->has('page')) {

            return OrderResource::collection(order::whereNotIn('state', ['delivered','not delivered'])->paginate(5));
        } else {
            return OrderResource::collection(order::whereNotIn('state', ['delivered','not delivered'])->orderByRaw('start')->get());
        }

    }
    public function pendingconfirmed(Request $request)
    {
        if ($request->has('page')) {

            return OrderResource::collection(order::where('state', ['pending','confirmed'])->orderByRaw('start')->paginate(5));
        } else {
            return OrderResource::collection(order::where('state', ['pending','confirmed'])->orderByRaw('start')->get());
        }

    }

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
