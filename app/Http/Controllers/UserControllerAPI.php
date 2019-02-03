<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Auth;
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
            'username' => 'required|min:3|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'type' => 'required|in:manager,waiter,cook,cashier',
            'file' => 'image',
        ]);
        $user = new User();
        $user->fill($request->all());
        $user->leader = ($request['leader'] ? 1 : 0);
        $user->password = Hash::make($user->password);
        $user->username=$request->email;
        if($request->file('file')!=null) {
            $user->photo_url = basename($request->file('file')->store('public/profiles'));
        }
        $user->save();
        $this->sendRegistrationMail($user->id);


        return response()->json(new UserResource($user), 201);
    }

    public function update(Request $request, $id='')
    {
        if($id!=''){
            $user = User::findOrFail($id);
        }else{
            $user = User::findOrFail(Auth::user()->id);
        }

        if($request['password']=='' || $request['password']==''){
            $request['password']=$user->password;
        }
        $request->validate([
            'name' => 'min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'type' => 'in:manager,waiter,cook,cashier',
            'file' => 'image',
            'password' => 'min:3'
        ]);


        $users = User::where('email',$request['email'])->where('id', '!=', $user->id)->get();
        if(count($users)!=0){
            return response()->json('["The email has already been taken."]',405);
        }
        $users = User::where('username', $request['username'])->where('id', '!=', $user->id)->get();
        if(count($users)!=0){
            return response()->json('["The username has already been taken."]',405);
        }


        $user->fill($request->except(['photo_url', 'password']));
        $user->password = Hash::make($request['password']);
        if($request->file('file')!=null) {
            $user->photo_url = basename($request->file('file')->store('public/profiles'));
        }
        $userArray = (new UserResource($user))->toArray('');
        if(starts_with($userArray['photo_url'], '/storage/profiles/')){
            $userArray['photo_url'] = str_replace_first('/storage/profiles/', '', $userArray['photo_url']);
        }

        //$user->save();
        $user->update($userArray);
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

    public function startShift()
    {
        $user = Auth::user();
        $user->last_shift_start = Carbon::now()->toDateTimeString();
        $user->shift_active = 1;

        $user->save();
        return new UserResource($user);
    }

    public function endShift()
    {
        $user = Auth::user();
        $user->last_shift_end = Carbon::now()->toDateTimeString();
        $user->shift_active = 0;

        $user->save();
        return new UserResource($user);
    }

    public function toggleLeader($id){
        $user = User::findOrFail($id);

        $user->leader = ($user->leader ? 0 : 1);

        $user->save();

        return new UserResource($user);
    }

    public function filter($option){
        $users = [];
        switch ($option){
            case 'all':
                $users = User::all();
            break;
            case 'leaders':
                $users = User::where('leader', 1)->get();
            break;
            case 'others':
                $users = User::where('leader', 0)->get();
            break;
        }

        return UserResource::collection($users);
    }

}
