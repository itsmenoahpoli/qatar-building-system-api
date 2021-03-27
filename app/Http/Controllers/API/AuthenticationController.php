<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Models\UserRole;
use App\Traits\Logging;
use App\Traits\AuditTrail;
use Auth;
use DB;

class AuthenticationController extends Controller
{
    use Logging, AuditTrail; 

    public function current_user(Request $request) {
        return $request->user();
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $accessToken = Auth::user()->createToken('accessToken')->accessToken;

            $this->saveAuthLog([
                'user_id' => Auth::user()->id, 
                'message' => 'Successfully logged-in'
            ]);

            $this->user_trail([
                'user_id' => Auth::user()->id, 
                'message' => Auth::user()->first_name.' '.Auth::user()->last_name.' successfully logged-in to the system'
            ]);

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
            $this->saveAuthLog([
                'user_id' => Auth::user()->id, 
                'message' => 'Successfully logged-out in all sessions'
            ]);

            DB::table('oauth_access_tokens')
            ->where('user_id', $user->id)
            ->update([
                'revoked' => true
            ]);
        }

        $this->saveAuthLog([
            'user_id' => Auth::user()->id, 
            'message' => 'Successfully logged-out'
        ]);

        $this->user_trail([
            'user_id' => Auth::user()->id, 
            'message' => Auth::user()->first_name.' '.Auth::user()->last_name.' successfully logged-out to the system'
        ]);

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
