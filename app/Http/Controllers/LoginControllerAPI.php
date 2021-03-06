<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


//define('YOUR_SERVER_URL', 'http://restaurant.restadadurant.tk');
//define('YOUR_SERVER_URL', 'http://restaurant.test');
// Check "oauth_clients" table for next 2 values:
define('CLIENT_ID', '2');
define('CLIENT_SECRET', 'fAZzh77ldU2h06vdRw0DYxciU64OQR915j24a5Te');

class LoginControllerAPI extends Controller
{
    public function login(Request $request)
    {
        /*var_dump(URL::to('/'));*/
        $url=str_replace_first('/api/login','/oauth/token',URL::current());
        /*var_dump($url);*/
        $http = new \GuzzleHttp\Client;
        $response = $http->post($url, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => CLIENT_ID,
                'client_secret' => CLIENT_SECRET,
                'username' => $request->email,
                'password' => $request->password,
                'scope' => ''
            ],
            'exceptions' => false,
        ]);
        $errorCode= $response->getStatusCode();

        if ($errorCode=='200') {
            return json_decode((string) $response->getBody(), true);
        } else {
            return response()->json(['msg'=>'User credentials are invalid'], $errorCode);
        }
    }

    public function logout()
    {
        \Auth::guard('api')->user()->token()->revoke();
        \Auth::guard('api')->user()->token()->delete();
        return response()->json(['msg'=>'OK'], 200);
    }
}
