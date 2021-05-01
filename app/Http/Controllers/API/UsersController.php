<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications\ApplicationRecord;
use App\Models\User;

class UsersController extends Controller
{
    private $relationships, $applicationsRelationship;

    public function __construct() {
      $this->relationships = ['application_records'];
      $this->applicationsRelationship = ['applicant_user', 'property_data', 'owner_data', 'applicant_data', 'project_data', 'others_data', 'review_data', 'attachement_data', 'payments', 'trail'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 1;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource (Get applications of user).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_applictions($user_id) {
      $application_records = ApplicationRecord::with($this->applicationsRelationship)->where('user_id', $user_id)->get();
      return $application_records;
    }

    public function __deconstruct() {
      $this->relationships = NULL;
    }
}
