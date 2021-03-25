<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Traits\Logging;
use Auth;
use DB;

class AuthenticationController extends Controller
{
    use Logging; 

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $accessToken = Auth::user()->createToken('accessToken')->accessToken;

            $this->saveLog(['user_id' => Auth::user()->id, 'message' => 'Successfully logged-in']);

            return response()->json([
                'accessToken' => $accessToken,
                'user' => Auth::user(),
                'user_type' => $this->getUserType(Auth::user()->user_type)
            ], 200);
        }

        return response()->json('User not found', 404);
    }

    public function logout(Request $request) {
        $user = Auth::user();
        $user->token()->revoke();

        if($request->logout_type === "all_session") {
            $this->saveLog(['user_id' => Auth::user()->id, 'message' => 'Successfully logged-out in all sessions']);

            DB::table('oauth_access_tokens')
            ->where('user_id', $user->id)
            ->update([
                'revoked' => true
            ]);
        }

        $this->saveLog(['user_id' => Auth::user()->id, 'message' => 'Successfully logged-out']);

        return response()->json('Logged-out', 200);
    }

    public function register(RegisterRequest $request) {
        
    }

    public function getUserType(int $user_type_id = 0) {
        switch($user_type_id) {
            case 1:
                return 'admin';
                break;
            case 2:
                return 'engineer';
                break;
            case 3:
                return 'client';
                break;
            default:
                return 'unknown_user_type';
        }
    }
}
