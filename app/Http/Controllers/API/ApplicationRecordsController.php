<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApplicationRecordsResource;
use App\Models\Applications\ApplicationRecord;

class ApplicationRecordsController extends Controller
{
    public $relationships;

    public function __construct() {
        $this->relationships = ['property_data', 'owner_data', 'applicant_data', 'project_data', 'others_data', 'attachement_data', 'review_data'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = ApplicationRecord::with($this->relationships)->get();

        return $applications;
    }

    /**
     * Display a listing of the paginated resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginated(Request $request)
    {
        $applications = ApplicationRecord::with($this->relationships)->get();

        return ApplicationRecordsResource::collection($applications)->paginate($request->limit ?? 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}
