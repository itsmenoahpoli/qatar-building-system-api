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
    public function index()
    {
        $invoices = ApplicationRecordPayment::with($this->relationships)
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

    public function show_by_uuid($uuid)
    {
        $$invoice = ApplicationRecordPayment::with($this->relationships)->where([
          'uuid' => $uuid
        ])->get()->first();

        return response()->json($invoice_data, 200);
    }

    public function __deconstruct() {
      $this->relationships = NULL;
  }
}
