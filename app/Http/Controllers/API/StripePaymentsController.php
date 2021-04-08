<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StripePayments\CreatePaymentRequest;
use App\Models\Applications\ApplicationRecordPayment;
use App\Models\Payments\PaymentRecord;
use Log;
use DB;

class StripePaymentsController extends Controller
{
    private $stripe_client;
    private $stripe_secret_key;

    public function __construct() {
      $this->stripe_secret_key = config('stripe.keys.STRIPE_SECRET_KEY');
      $this->stripe_client = new \Stripe\StripeClient($this->stripe_secret_key);
    }

    public function get_all_payments(Request $request) 
    {
      try {
        $limit = $request->get('limit') ?? 0;
        $payment_charges_list = $this->stripe_client->charges->all([
          'limit' => $limit
        ]);

        return $payment_charges_list;
      } catch(Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }

    public function create_payment(Request $request, $application_payment_record_uuid) 
    {
      try {
        DB::beginTransaction();

        $application_payment_record = ApplicationRecordPayment::where('uuid', '=', $application_payment_record_uuid)->first();

        $token = $request->stripeToken;

        $payment_charge = $this->stripe_client->charges->create([
          'amount' => $application_payment_record->amount.'0',
          'currency' => 'PHP',
          'description' => 'Application Record Registration Payment',
          'source' => $token
        ]);

        $application_payment_record->is_paid = $payment_charge->paid;
        $application_payment_record->stripe_receipt_url = $payment_charge->receipt_url;
        $application_payment_record->save();

        $payment_record = PaymentRecord::create([
          'stripe_payment_id' => $payment_charge->id,
          'payment_object_json' => json_encode($payment_charge),
          'status' => $payment_charge->paid ? "paid" : "on-hold/failed",
          'stripe_receipt_url' => $payment_charge->receipt_url
        ]);

        Log::channel('stripe_log')->info($payment_charge);

        DB::commit();

        return view('payments.stripe.success-payment')->with([
          'application_payment_record' => $application_payment_record,
          'payment_record' => $payment_record
        ]);
      } catch(Exception $e) {
        DB::rollback();
        return view('payments.stripe.failed-payment');
      }
    }

    public function get_payment($payment_charge_id) 
    {
      $payment_record = $this->stripe_client->charges->retrieve(
        $payment_charge_id,
        []
      );

      Log::channel('stripe_log')->info([
        'title' => 'Retrieved payment charge',
        'payment_charge_id' => $payment_charge_id,
        'data' => $payment_record
      ]);

      return $payment_record;
    }
}
