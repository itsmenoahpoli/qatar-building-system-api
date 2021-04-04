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
use App\Models\Applications\ApplicationReviewData;
use App\Models\Applications\ApplicationAttachementData;
use DB;

class ApplicationRecordsController extends Controller
{
    private $relationships;

    public function __construct() {
        $this->relationships = ['property_data', 'owner_data', 'applicant_data', 'project_data', 'others_data', 'review_data', 'attachement_data'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $applications = ApplicationRecord::with($this->relationships)->latest()->get();

        return $applications;
    }

    /**
     * Display a listing of the paginated resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginated(Request $request)
    {
        $limit = $request->get('limit') ?? 10;
        $applications = ApplicationRecord::with($this->relationships)->latest()->get();

        return ApplicationRecordsResource::collection($applications)->paginate($limit ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationStoreRequest $request)
    {
        try {
            // Start transaction
            DB::beginTransaction();

            $application_record = ApplicationRecord::create([
                'uuid' => 'application_'.Str::random(8)
            ]);
            
            // Store Applicant Data
            $application_property_data = ApplicationPropertyData::create([
                "application_record_id" => $application_record->id,
                "pin_no" => $request->application_property_data['pin_no'],
                "municipality" => $request->application_property_data['municipality'],
                "location" => $request->application_property_data['location'],
                "street_no" => $request->application_property_data['street_no'],
                "street_name" => $request->application_property_data['street_name'],
                "real_estate_no" => $request->application_property_data['real_estate_no'],
                "land_no" => $request->application_property_data['land_no'],
                "title_deed" => $request->application_property_data['title_deed'],
                "area_space" => $request->application_property_data['area_space'],
                "total_build_up_area" => $request->application_property_data['total_build_up_area']
            ]);

            // Store Owner Data
            $application_owner_data = ApplicationOwnerData::create([
                "application_record_id" => $application_record->id,
                "name" => $request->application_owner_data['name'],
                "license_no" => $request->application_owner_data['license_no'],
                "mobile_no" => $request->application_owner_data['mobile_no'],
                "comments" => $request->application_owner_data['comments']
            ]);

            // Store Applicant Data
            $application_applicant_data = ApplicationApplicantData::create([
                "application_record_id" => $application_record->id,
                "user_id" => $request->application_applicant_data['user_id'],
                "type_of_applicant" => $request->application_applicant_data['type_of_applicant'],
                "name" => $request->application_applicant_data['name'],
                "license_no" => $request->application_applicant_data['license_no'],
                "mobile_no" => $request->application_applicant_data['mobile_no'],
            ]);

            // Store Project Data
            $application_project_data = ApplicationProjectData::create([
                "application_record_id" => $application_record->id,
                "type" => $request->application_project_data['type'],
                "name" => $request->application_project_data['name'],
                "no_of_floors" => $request->application_project_data['no_of_floors'],
                "others" => $request->application_project_data['others'],
            ]);

            // Store Others Data
            $application_others_data = ApplicationOthersData::create([
                "application_record_id" => $application_record->id,
                "quote_no" => $request->application_others_data['quote_no'],
                "client_no" => $request->application_others_data['client_no'],
                "client_name" => $request->application_others_data['client_name'],
                "required_works" => $request->application_others_data['required_works'],
                "others" => $request->application_others_data['others'],
                "services_fees" => $request->application_others_data['services_fees'],
            ]);

            // Store Review Data
            $application_review_data = ApplicationReviewData::create([
                "application_record_id" => $application_record->id,
                "engineer_category" => $request->application_review_data['engineer_category'], 
                "engineer_id" => $request->application_review_data['engineer_id'], 
                "building_permit_fees" => $request->application_review_data['building_permit_fees'], 
                "status" => $request->application_review_data['status'], 
                "others" => $request->application_review_data['others'], 
            ]);


            // Store Attachement Data (Images)
            // $application_property_data = ApplicationAttachementData::create($request->application_property_data);

            DB::commit();
            // End transaction

            $application_data_overview = ApplicationRecord::with($this->relationships)->find($application_record->id);

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
        return ApplicationRecord::with($this->relationships)->findOrFail($id);
    }

    public function show_by_uuid($uuid) {
        $application_record = ApplicationRecord::with($this->relationships)->where('uuid', '=', $uuid)->get();

        return count($application_record) === 1 ? response()->json($application_record->first(), 200) : response()->json('Not Found', 404);
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
        $appliction_record = ApplicationRecord::findOrFail($id);
        
        try {
            $appliction_record->delete();
            
            return response()->json('Deleted', 204);
        } catch(Exception $e) {
            return response()->json('Failed', 500);
        }
    }

    public function __deconstruct() {
        $this->relationships = NULL;
    }
}
