<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications\ApplicationRecord;
use App\Models\Applications\ApplicationRecordPayment;
use App\Traits\Payment;

class PagesController extends Controller
{
    use Payment;

    private $applicationRecordRelationships;

    public function __construct() {
      $this->applicationRecordRelationships = ['property_data', 'owner_data', 'applicant_data', 'project_data', 'others_data', 'review_data', 'attachement_data', 'payment'];
    }

    /**
     * API documentation pages
     */
    public function api_index(Request $request) 
    {
        $authorized_access_token = $request->get('aat');
    }

    /**
     * Stripe create payment
     */
    public function stripe_create_payment($application_payment_uuid) 
    {
      $application_payment_record = ApplicationRecordPayment::where('uuid', '=', $application_payment_uuid)->first();

      if($application_payment_record) {
        $application_record = ApplicationRecord::with($this->applicationRecordRelationships)->findOrFail($application_payment_record->application_record_id);


        return view('payments.stripe.create-payment')->with([
          'payment_for' => $this->get_payment_for_str($application_payment_record->payment_for),
          'payment_data_found' => true,
          'payment_data_amount' => $application_payment_record->amount,
          'payment_data_paid' => $application_payment_record->is_paid,
          'payment_data_receipt_url' => $application_payment_record->stripe_receipt_url,
          'application_payment_uuid' => $application_payment_uuid,
          'application_record_data' => $application_record
        ]);
      }

      // return $application_payment_record ? 'found' : 'not found';
      return view('payments.stripe.create-payment')->with([
        'payment_data_found' => false
      ]);
    }

    /**
     * Stripe failed payment
     */
    public function stripe_success_payment() {
      return view('payments.stripe.success-payment');
    }
}
