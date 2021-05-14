<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications\ApplicationRecord;
use App\Models\Applications\ApplicationRecordPayment;
use App\Models\User;
use App\Traits\Mail;

class UsersController extends Controller
{
    use Mail;

    private $relationships, $applicationsRelationship;

    public function __construct() {
      $this->relationships = ['application_records', 'user_role'];
      $this->invoicesRelationship = ['application_record', 'payment_record'];
      $this->applicationsRelationship = ['applicant_user', 'property_data', 'owner_data', 'applicant_data', 'project_data', 'others_data', 'review_data', 'attachement_data', 'payments', 'trail'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $search = $request->get('q');

      $users = User::with($this->relationships)->where('user_role_id' ,'!=', 6)->when(!empty($search), function($q) use ($search) {
        return $q->where('first_name', 'LIKE', '%'.$search.'%');
      })->latest()->get();

      return $users;
    }

    /**
     * Display a listing of the resource (Client Accounts).
     *
     * @return \Illuminate\Http\Response
     */
    public function index_client_accounts(Request $request)
    {
        $users = User::with($this->relationships)->where('user_role_id', 6)->latest()->get();

        return $users;
    }

    /**
     * Display a listing of the paginated resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginated()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
          $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_role_id' => $request->user_role_id,
            'is_new_user' => 1,
          ]);

          $user_name = ($user->first_name.' '.$user->last_name);

          $this->send_account_to_client($request->email, [
            'user_name' => $user_name,
            'password' => $request->password
          ]);

          return response()->json($user, 201);
        } catch(Exception $e) {
          return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::with($this->relationships)->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      try {
        User::findOrFail($id)->update($request->all());
        return response()->json('Updated', 200);
      } catch(Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }

    /**
     * Update the specified resource (email field) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_info(Request $request, $id)
    {
        try {
          User::findOrFail($id)->update($request->all());
          return response()->json('Updated', 200);
        } catch(Exception $e) {
          return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
          User::findOrFail($id)->delete();

          return response()->json('Deleted', 204);
        } catch(Exception $e) {
          return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display a listing of the resource (Get applications of user).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_applications($user_id, Request $request) {
        $search = $request->get('q');
        $limit = $request->limit ?? 10000;
        $status = $request->get('status');
        $payment_status = $request->get('payment_status');
        $engineer_category = $request->get('engineer_category');


        $applications = ApplicationRecord::with($this->applicationsRelationship)
        ->where('user_id', $user_id)
        ->whereHas('applicant_user', function ($q) use ($search) {
          return $q->when(!empty($search), function ($y) use ($search) {
            $y->where('uuid', 'LIKE', '%'.$search.'%')
              ->orWhere('first_name', 'LIKE', '%'.$search.'%')
              ->orWhere('middle_name', 'LIKE', '%'.$search.'%')
              ->orWhere('last_name', 'LIKE', '%'.$search.'%')
              ->orWhere('email', 'LIKE', '%'.$search.'%')
              ->orWhere('status', 'LIKE', '%'.$search.'%');
          });
        })
        ->when(!empty($status), function ($q) use ($status) {
          return $q->where('status', $status);
        })
        ->when(!empty($payment_status), function ($q) use ($payment_status) {
          return $q->where('payment_status', $payment_status);
        })
        ->latest()
        ->limit($limit)
        ->get();

        return $applications;
    }

    /**
     * Display a listing of the resource (Get payment invoices of user).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_invoices($user_id, Request $request) {
        $invoices = ApplicationRecordPayment::with($this->invoicesRelationship)
                    ->where('user_id', $user_id)
                    ->latest()->get();

        return $invoices;
  }

    public function __deconstruct() {
      $this->relationships = NULL;
    }
}
