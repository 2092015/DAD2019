<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\User;
use App\StoreUserRequest;
use Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class UserControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return UserResource::collection(User::paginate(5));
        } else {
            return UserResource::collection(User::all());
        }

    }

    public function show($id)
    {

        return new UserResource(User::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'min:3'
        ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->username=$request->email;
        $user->save();
        $this->sendRegistrationMail($user->id);

        return response()->json(new UserResource($user), 201);


    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
    /*public function emailAvailable(Request $request)
    {
        $totalEmail = 1;
        if ($request->has('email') && $request->has('id')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->where('id', '<>', $request->id)->count();
        } else if ($request->has('email')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->count();
        }
        return response()->json($totalEmail == 0);
    }*/
    public function myProfile(Request $request)
    {
        return new UserResource($request->user());
    }

    public function sendRegistrationMail($id, $url=''){
        $user = User::findOrFail($id);
        Mail::to($user->email)->send(new RegistrationEmail($user));
        return count(Mail::failures());
    }

    public function confirmUser($id){
        $user = User::findOrFail($id);
        $pass = str_random(8);

        if(!$user->email_verified_at){
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->password = Hash::make($pass);
            $user->save();
        }

        return view('confirmed')->with([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $pass
        ]);
    }
}
