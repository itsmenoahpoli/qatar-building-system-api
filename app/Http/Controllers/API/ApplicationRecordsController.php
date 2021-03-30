<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\ApplicationRecordsResource;
use App\Http\Requests\Applications\ApplicationStoreRequest;
use App\Models\Applications\ApplicationRecord;
use App\Models\Applications\ApplicationPropertyData;
use App\Models\Applications\ApplicationOwnerData;
use App\Models\Applications\ApplicationApplicantData;
use App\Models\Applications\ApplicationProjectData;
use App\Models\Applications\ApplicationOthersData;
use App\Models\Applications\ApplicationAttachementData;
use DB;

class ApplicationRecordsController extends Controller
{
    private $relationships;

    public function __construct() {
        $this->relationships = ['property_data', 'owner_data', 'applicant_data', 'project_data', 'others_data', 'attachement_data', 'review_data'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit') ?? 10;

        return $request->all();

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationStoreRequest $request)
    {
        $user_id = 1;

        return $request->application_applicant_data;

        try {
            $application_record = ApplicationRecord::create([
                'uuid' => 'application_'.Str::random(4)
            ]);

            // Start transaction
            DB::beginTransaction();
            
            // Queries

            DB::commit();
            // End transaction

            $application_data_overview = [];

            return response()->json($application_data_overview, 201);
        } catch(Exception $e) {
            DB::rollback();
            return response()->json('Failed', 500);
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

    public function __deconstruct() {
        $this->relationships = "";
    }
}
