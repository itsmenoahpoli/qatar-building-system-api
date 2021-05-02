<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payments\PaymentRecord;

class PaymentsController extends Controller
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
  public function index(Request $request)
  {
      $search = $request->get('q');
      $status = $request->get('status');


      $payments = PaymentRecord::with($this->relationships)
      ->whereHas('application_record', function ($q) use ($search) {
        return $q->when(!empty($search), function ($y) use ($search) {
          $y->where('uuid', 'LIKE', '%'.$search.'%')
            ->orWhere('status', 'LIKE', '%'.$search.'%');
        });
      })
      ->latest()
      ->get();

      return $payments;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      return PaymentRecord::with($this->relationships)->findOrFail($id);
  }

  public function __deconstruct() {
    $this->relationships = NULL;
  }
}
