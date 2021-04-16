<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications\ApplicationRecordPayment;

class InvoicesController extends Controller
{
    private $relationships;

    public function __construct() {
        $this->relationships = ['application_record'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = ApplicationRecordPayment::with($this->relationships)->where('is_paid', true)->get();

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
          'uuid' => $uuid,
          'is_paid' =>  true
        ])->get();

        return count($invoice) === 1 ? response()->json($invoice->first(), 200) : response()->json('Not Found', 404);
    }

    public function show_by_uuid($uuid)
    {
        $$invoice = ApplicationRecordPayment::with($this->relationships)->where([
          'uuid' => $uuid,
          'is_paid' =>  true
        ])->get();

        return count($invoice) === 1 ? response()->json($invoice->first(), 200) : response()->json('Not Found', 404);
    }

    public function __deconstruct() {
      $this->relationships = NULL;
  }
}
