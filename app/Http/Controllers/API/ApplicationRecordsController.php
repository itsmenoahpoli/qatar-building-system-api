<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\ApplicationRecordsResource;
use App\Http\Requests\Applications\ApplicationStoreRequest;
use App\Http\Requests\Applications\CreateApplicationReviewRequest;
use App\Http\Requests\Applications\CreatePaymentRequest;
use App\Models\Applications\ApplicationRecordPayment;
use App\Models\Applications\ApplicationRecord;
use App\Models\Applications\ApplicationPropertyData;
use App\Models\Applications\ApplicationOwnerData;
use App\Models\Applications\ApplicationApplicantData;
use App\Models\Applications\ApplicationProjectData;
use App\Models\Applications\ApplicationOthersData;
use App\Models\Applications\ApplicationReviewData;
use App\Models\Applications\ApplicationAttachementData;
use App\Models\User;
use App\Traits\AuditTrail;
use App\Traits\Mail;
use App\Traits\FileUploads;
use DB;

class ApplicationRecordsController extends Controller
{
    use AuditTrail, Mail, FileUploads;

    private $relationships;

    public function __construct() {
        $this->relationships = ['applicant_user', 'property_data', 'owner_data', 'applicant_data', 'project_data', 'others_data', 'review_data', 'attachement_data', 'payments', 'stripe_payment_reference', 'trail'];
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
        $payment_status = $request->get('payment_status');
        $engineer_category = $request->get('engineer_category');


        $applications = ApplicationRecord::with($this->relationships)
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
        ->get();

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
                'uuid' => 'application_'.Str::random(8),
                'user_id' => $request->application_applicant_data['user_id']
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

            // Initiate Payment Record (with is_paid = false)
            $application_payment_record = ApplicationRecordPayment::create([
              'uuid' => 'p_'.Str::random(10),
              'application_record_id' => $application_record->id,
              'payment_for' => 'services-dp-50%',
              'amount' => intval($request->application_others_data['services_fees'].'0') / 2
            ]);

            $user = User::findOrFail($request->application_applicant_data['user_id']);

            $this->send_payment_url_to_client($user->email, [
              'message' => 'We have submitted your building permit application with application no. '.$application_record->uuid.'. In order to proceed with the process, kindly settle the service fee DP',
              'user_name' => $user->first_name.' '.$user->last_name,
              'payment_link' => config('stripe.payment_urls.PRODUCTION').'/stripe-payments/payment/'.$application_payment_record->uuid
            ]);

            $this->application_trail([
              'application_record_id' => $application_record->id,
              'content' => 'Application uploaded to E-BPMS'
            ]);

            $this->application_trail([
              'application_record_id' => $application_record->id,
              'content' => 'Payment created for `services-dp-50%`'
            ]);

            DB::commit();
            // End transaction

            $application_data_overview = ApplicationRecord::with($this->relationships)->find($application_record->id);

            return response()->json([
              'services_dp_50%_payment_url' => config('stripe.payment_urls.PRODUCTION').'/stripe-payments/payment/'.$application_payment_record->uuid,
              'application_data' => $application_data_overview
            ], 201);
        } catch(Exception $e) {
            DB::rollback();
            return response()->json('Failed', 500);
        }
    }

    /**
     * Update the approval status specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_approval(Request $request)
    {
        $application = ApplicationRecord::with($this->relationships)->findOrFail($request->application_record_id);

        try {
          if($request->approval_status === "approved") {
            $application->status = 'approved';
            $application->other_review_comments = $request->other_review_comments;
            $application->bp_fees = $request->bp_fees;
            $application->save();

            $application_services_completion_fee = ApplicationRecordPayment::where([
              'application_record_id' => $request->application_record_id,
              'payment_for' => 'services-dp-50%'
            ])->first();

            $final_payment_fee = intval($request->bp_fees.'0') + intval($application_services_completion_fee->amount);

            
            $application_payment_record = ApplicationRecordPayment::create([
              'uuid' => 'p_'.Str::random(10),
              'application_record_id' => $application->id,
              'payment_for' => 'final-payment',
              'amount' => $final_payment_fee
            ]);

            $this->send_payment_url_to_client($application->applicant_user->email, [
              'message' => 'Your application with application no. '.$application->uuid.' has been approved. In order to print or download the permit, kindly settle the service fee full payment and building permit fees.',
              'user_name' => $application->applicant_user->first_name.' '.$application->applicant_user->last_name,
              'payment_link' => config('stripe.payment_urls.PRODUCTION').'/stripe-payments/payment/'.$application_payment_record->uuid
            ]);


            return response()->json([
              'message' => 'Your application with application no. '.$application->uuid.' has been approved. In order to print or download the permit, kindly settle the service fee full payment and building permit fees.',
              'user_name' => $application->applicant_user->first_name.' '.$application->applicant_user->last_name,
              'payment_link' => config('stripe.payment_urls.PRODUCTION').'/stripe-payments/payment/'.$application_payment_record->uuid
            ], 200);
          }

          if($request->approval_status === "rejected") {
            $application->status = 'rejected';
            $application->other_review_comments = $request->other_review_comments;
            $application->save();

            $this->send_payment_url_to_client($application->applicant_user->email, [
              'message' => 'Your application with application no. '.$application->uuid.' has been rejected. In order to proceed with the application, kindly comply according to the below comments.',
              'comments' => $application->other_review_comments,
              'user_name' => $application->applicant_user->first_name.' '.$application->applicant_user->last_name,
              'payment_link' => "--"
            ]);
            

            return response()->json([
              'message' => 'Your application with application no. '.$application->uuid.' has been rejected. In order to proceed with the application, kindly comply according to the below comments.',
              'user_name' => $application->applicant_user->first_name.' '.$application->applicant_user->last_name,
              'payment_link' => "--"
            ], 200);
          }

          if($request->approval_status === "pending") {
            $application->status = "pending";
            $application->save();

            return response()->json([
              'message' => 'Your application with application no. '.$application->uuid.' status has been updated to pending.',
              'user_name' => $application->applicant_user->first_name.' '.$application->applicant_user->last_name,
              'payment_link' => "--"
            ], 200);
          }
        } catch(Exception $e) {
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

    /**
     * Retrieve all soft deleted records (Single).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view_deleted(Request $request) 
    {
      $search = $request->search;
      $limit = $request->limit ?? 10;
    }

    /**
     * Restore the specified resource from soft deleted records (Single).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore_deleted($id) 
    {

    }

    /**
     * Restore the specified resource from soft deleted records (All).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore_all_deleted() 
    {

    }

    /**
     * Hard delete the specified resource from storage (Iretrievable).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hard_delete($id)
    {
        
    }    

    /**
     * Update application status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request)
    {
        
    }

    /**
     * Add application review.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_review(CreateApplicationReviewRequest $request)
    {
        try {
          $application_record = ApplicationRecord::with('review_data')->findOrFail($request->application_record_id);

          foreach($application_record->review_data as $review) {
            if($review->engineer_category === $request->engineer_category) {
              return response()->json('Reviewed already by an engineer with same engineer category', 409);
            }
          }

          DB::beginTransaction();
          
          $application_review_data = ApplicationReviewData::create($request->all());

          $user = User::findOrFail($request->user_id);

          $this->application_trail([
            'application_record_id' => $application_record->id,
            'content' => 'Review added by engineer: '.$user->first_name.' '.$user->last_name
          ]);

          DB::commit();

          return response()->json($application_review_data, 201);
        } catch(Exception $e) {
          return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update application review.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_review(Request $request)
    {
        
    }

    /**
     * Delete application review.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_review(Request $request)
    {
        
    }

    public function add_application_payment(CreatePaymentRequest $request) 
    {
      try {
        DB::beginTransaction();

        $application_payment_record = ApplicationRecordPayment::create([
          'uuid' => 'p_'.Str::random(10),
          'application_record_id' => $request->application_id,
          'payment_for' => $request->payment_for,
          'amount' => $request->amount.'0'
        ]);

        $this->application_trail([
          'application_record_id' => $request->application_id,
          'content' => 'Payment created for `'.$request->payment_for.'`'
        ]);

        DB::commit();

        $application_payments_updated_list = ApplicationRecordPayment::where('application_record_id', $request->application_id)->get();
        
        $payment_url = config('stripe.payment_urls.PRODUCTION').'/stripe-payments/payment/'.$application_payment_record->uuid;
        
        $application_payments_data = [
          'payment_url' => $payment_url,
          'newly_created_payment' => $application_payment_record,
          'application_payments_list' => $application_payments_updated_list
        ];


        return response()->json($application_payments_data, 201);
      } catch(Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }

    public function __deconstruct() {
        $this->relationships = NULL;
    }
}
