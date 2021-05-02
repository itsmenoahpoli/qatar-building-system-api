<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications\ApplicationRecordPayment;

class InvoicesController extends Controller
{
    private $relationships;

    public function __construct() {
        $this->relationships = ['application_record', 'payment_record'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('q');
        $payment_for = $request->get('payment_for');

        $invoices = ApplicationRecordPayment::with($this->relationships)
                    ->whereHas('application_record', function ($q) use ($search) {
                      return $q->when(!empty($search), function ($y) use ($search) {
                        $y->where('uuid', 'LIKE', '%'.$search.'%')
                          ->orWhere('status', 'LIKE', '%'.$search.'%');
                      });
                    })
                    ->where('payment_for', 'LIKE', '%'.$payment_for.'%')
                    ->latest()->get();

        return $invoices;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $invoice = ApplicationRecordPayment::with($this->relationships)->where([
          'uuid' => $uuid
        ])->get()->first();


        if(!is_null($invoice)) {
          $invoice_data = [
            'invoice' => $invoice,
            'invoice_recipient' => $invoice->application_record->applicant_user,
            'application_record' => $invoice->application_record
          ];
          
          return response()->json($invoice_data, 200);
        }
        
        return response()->json('Not Found', 404);
    }

    /**
     * Display the specified resource by uuid.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_by_uuid($uuid)
    {
        $invoice = ApplicationRecordPayment::with($this->relationships)->where([
          'uuid' => $uuid
        ])->get()->first();

        return response()->json($invoice_data, 200);
    }

    /**
     * Send invoice to client
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send_invoice_to_client(Request $request) 
    {

    }

    public function __deconstruct() {
      $this->relationships = NULL;
  }
}
