<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
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
    public function store(Request $request)
    {
        $request->validate([
            'state' => 'required|in:pending,confirmed,in preparation,prepared,delivered,not delivered'
        ]);
        $meal = new meal();
        $meal->fill($request->all());
        $meal->save();
        return response()->json(new MealResource($meal), 201);
    }
}