<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\Item as ItemResource;
use Illuminate\Support\Facades\DB;

use App\Item;
use App\StoreItemRequest;
use Hash;

class ItemControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return ItemResource::collection(item::paginate(5));
        } else {
            return ItemResource::collection(item::orderByRaw('type')->get());
        }

    }

    public function show($id)
    {
        return new ItemResource(item::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z ]+$/',
            'type' => 'required|in:drink,dish',
            'description' => 'required|regex:/^[a-zA-Z ]+$/',
            'photo_url' => 'required|image',
            'price' => 'required|between:0,99.99'
        ]);
        $item = new item();
        $item->fill($request->all());
        $item->save();
        return response()->json(new ItemResource($item), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z ]+$/',
            'type' => 'required|in:drink,dish',
            'description' => 'required|regex:/^[a-zA-Z ]+$/',
            'photo_url' => 'required|image',
            'price' => 'required|between:0,99.99'
        ]);
        $item = item::findOrFail($id);
        $item->update($request->all());
        return new ItemResource($item);
    }

    public function destroy($id)
    {
        $item = item::findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

}
