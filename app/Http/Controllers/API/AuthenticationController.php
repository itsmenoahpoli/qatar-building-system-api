<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Controllers\API\OtpController;
use App\Models\User;
use App\Models\UserRole;
use App\Traits\Logging;
use App\Traits\AuditTrail;
use Auth;
use DB;

class AuthenticationController extends Controller
{
    use Logging, AuditTrail; 

    private $otp_controller;

    public function __construct(OtpController $otp_controller) {
      $this->otp_controller = $otp_controller;
    }

    public function current_user(Request $request) {
        $user_data = [
            'user_data' => $request->user(),
            'user_type' => $this->get_user_role($request->user()->user_role_id)
        ];

        return $user_data;
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $accessToken = Auth::user()->createToken('accessToken')->accessToken;

            $this->save_authentication_log([
                'user_id' => Auth::user()->id, 
                'message' => 'Successfully logged-in'
            ]);

            $this->user_trail([
                'user_id' => Auth::user()->id, 
                'message' => Auth::user()->first_name.' '.Auth::user()->last_name.' successfully logged-in to the system'
            ]);

            $this->otp_controller->request_otp(Auth::user()->email, "login_verify");

            return response()->json([
                'accessToken' => $accessToken,
                'user' => Auth::user(),
                'user_type' => $this->get_user_role(Auth::user()->user_role_id)
            ], 200);
        } else {
          return response()->json('User not found', 404);
        }
    }

    public function logout(Request $request) {
        try {
            $user = Auth::user();
            $user->token()->revoke();

            if($request->logout_type === "all_session") {
                $this->save_authentication_log([
                    'user_id' => Auth::user()->id, 
                    'message' => 'Successfully logged-out in all sessions'
                ]);

                DB::table('oauth_access_tokens')
                ->where('user_id', $user->id)
                ->update([
                    'revoked' => true
                ]);
            }

            $this->save_authentication_log([
                'user_id' => Auth::user()->id, 
                'message' => 'Successfully logged-out'
            ]);

            $this->user_trail([
                'user_id' => Auth::user()->id, 
                'message' => Auth::user()->first_name.' '.Auth::user()->last_name.' successfully logged-out to the system'
            ]);

            return response()->json('Logged-out', 200);
        } catch(Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function register(RegisterRequest $request) {
        try { 
          if(User::whereEmail($request->email)->first()) {
            return response()->json('Email already exist', 409);
          }
          
          User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_enabled' => true,
            'is_verified' => true,
            'user_role_id' => 6 // Default user role id for client accounts
          ]);
          
          return response()->json('Account created', 201);
        } catch(Exeption $e) {
          return response()->json($e->getMessage(), 500);
        }
    }

    public function get_user_role(int $role_id = 0) {
        $role = UserRole::find($role_id)->first();

        if(!$role) {
            return 'invalid-user-type';
        }

        return $role;
    }
}
