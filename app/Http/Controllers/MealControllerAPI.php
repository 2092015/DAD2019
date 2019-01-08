<?php

namespace App\Http\Controllers;


use App\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\meal as MealResource;
use App\Meal;
use App\StoreMealRequest;
//use Hash;

class MealControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return MealResource::collection(meal::orderBy('end','desc')->paginate(5));
        } else {
            return MealResource::collection(meal::orderBy('end','desc')->get());
        }

    }
    public function pending(Request $request)
    {
        if ($request->has('page')) {

            return MealResource::collection(meal::whereNotIn('state', ['paid'])->paginate(5));
        } else {
            return MealResource::collection(meal::whereNotIn('state', ['paid'])->orderBy('start')->get());
        }

    }

    public function show($id)
    {
        return new MealResource(meal::find($id));
    }

    public function startMeal($id){

        if(count(Meal::where('table_number', $id)->where('state', 'active')->get())>0){
            return response()->json('Table already has 1 active meal', 403);
        }

        $meal = new meal();
        $meal->state = 'active';
        $meal->table_number = $id;
        $meal->start = Carbon::now()->toDateTimeString();
        $meal->responsible_waiter_id = Auth::user()->id;
        $meal->total_price_preview = 0;
        $meal->save();

        return response()->json(new MealResource($meal), 201);
    }
}
