<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserOtp;
use App\Mail\Users\Otp as OtpMail;
use Carbon\Carbon;
use Mail;


class OtpController extends Controller
{
  /**
   * Request a new OTP.
   * @return \Illuminate\Http\Response
   */
  public function request_otp($email) {
    try {
      $user = User::whereEmail($email)->firstOrFail();
      $user_name = $user->first_name.' '.$user->last_name;

      $otp = UserOtp::create([
        'user_id' => $user->id,
        'otp_code' => strtoupper(Str::random(8)),
        'expires_at' => Carbon::now()->addDay(1)
      ]);

      $created_otp = UserOtp::with('user')->find($otp->id);

      Mail::to($email)->send(new OtpMail(['otp_code' => $otp->otp_code, 'user_name' => $user_name, 'expires_at' => $otp->expires_at]));

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
      $otp = UserOtp::where('otp_code', '=', $request->otp_code)->firstOrFail();

      if($otp->expires_at <= Carbon::now() || $otp->is_verified) {
        return response()->json('Code invalid, it may have been expired or used already', 409);
      } 

      $otp->is_verified = true;
      $otp->save();

      return response()->json('Valid', 200);
    } catch(Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }
}
