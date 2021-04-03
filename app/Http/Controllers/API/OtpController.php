<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserOtp;
use Carbon\Carbon;


class OtpController extends Controller
{
  /**
   * Request a new OTP.
   * @return \Illuminate\Http\Response
   */
  public function request_otp(Request $request) {

    try {
      $user = User::whereEmail($request->email)->firstOrFail();

      $otp = UserOtp::create([
        'user_id' => $user->id,
        'otp_code' => strtoupper(Str::random(8))
      ]);

      $created_otp = UserOtp::with('user')->find($otp->id);

      return response()->json($created_otp, 201);
    } catch(Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
   * Verify an OTP.
   * @return \Illuminate\Http\Response
   */
  public function verify_otp(Request $request) {
    try {
      $otp = UserOtp::where('otp_code', '=', $request->otp_code)->where('is_verified', '=', false)->firstOrFail();

      if(Carbon::parse($otp->created_at)->addDay(1) <= Carbon::now()) {
        return response()->json('Invalid', 409);
      } 

      $otp->is_verified = true;
      $otp->save();

      return response()->json('Valid', 200);


    } catch(Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }
}
