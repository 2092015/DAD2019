<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\order as MealResource;
use Illuminate\Support\Facades\DB;

use App\Order;
use App\StoreMealRequest;
//use Hash;

class MealControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return OrderResource::collection(order::paginate(5));
        } else {
            return OrderResource::collection(order::all());
        }

    }
    public function pending(Request $request)
    {
        if ($request->has('page')) {

            return OrderResource::collection(order::whereNotIn('state', ['delivered','not delivered'])->paginate(5));
        } else {
            return OrderResource::collection(order::whereNotIn('state', ['delivered','not delivered'])->orderByRaw('start')->get());
        }

    }

    public function show($id)
    {
        return new OrderResource(order::find($id));
    }
}