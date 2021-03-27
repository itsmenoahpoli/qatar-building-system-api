<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Traits\Logging;
use App\Models\UserRole;
use Auth;
use DB;

class AuthenticationController extends Controller
{
    use Logging; 

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $accessToken = Auth::user()->createToken('accessToken')->accessToken;

            $this->saveAuthLog(['user_id' => Auth::user()->id, 'message' => 'Successfully logged-in']);

            return response()->json([
                'accessToken' => $accessToken,
                'user' => Auth::user(),
                'user_type' => $this->getUserRole(Auth::user()->user_role_id)
            ], 200);
        }

        return response()->json('User not found', 404);
    }

    public function logout(Request $request) {
        $user = Auth::user();
        $user->token()->revoke();

        if($request->logout_type === "all_session") {
            $this->saveAuthLog(['user_id' => Auth::user()->id, 'message' => 'Successfully logged-out in all sessions']);

            DB::table('oauth_access_tokens')
            ->where('user_id', $user->id)
            ->update([
                'revoked' => true
            ]);
        }

        $this->saveAuthLog(['user_id' => Auth::user()->id, 'message' => 'Successfully logged-out']);

        return response()->json('Logged-out', 200);
    }

    public function register(RegisterRequest $request) {
        
    }

    public function getUserRole(int $role_id = 0) {
        $role = UserRole::find($role_id)->first();

        if(!$role) {
            return 'invalid-user-type';
        }

        return $role;
    }
}
