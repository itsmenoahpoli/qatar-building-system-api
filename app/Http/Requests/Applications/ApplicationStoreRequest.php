<?php

namespace App\Http\Requests\Applications;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Property data
            'application_property_data.pin_no' => 'required',
            'application_property_data.municipality' => 'required',
            'application_property_data.location' => 'required',
            'application_property_data.street_no' => 'required',
            'application_property_data.street_name' => 'required',
            'application_property_data.real_estate_no' => 'required',
            'application_property_data.land_no' => 'required',
            'application_property_data.title_deed' => 'required',
            'application_property_data.area_space' => 'required',
            'application_property_data.total_build_up_area' => 'required',

            // Owner Data
            'application_owner_data.name' => 'required',
            'application_owner_data.license_no' => 'required',
            'application_owner_data.mobile_no' => 'required',
            'application_owner_data.comments' => 'required',

            // Applicant Data
            'application_applicant_data.user_id' => 'required',
            'application_applicant_data.type_of_applicant' => 'required',
            'application_applicant_data.name' => 'required',
            'application_applicant_data.license_no' => 'required',
            'application_applicant_data.mobile_no' => 'required',
            'application_applicant_data.comments' => 'required',

            // Project Data
            'application_project_data.type' => 'required',
            'application_project_data.name' => 'required',
            'application_project_data.no_of_floors' => 'required',
            'application_project_data.others' => 'required',

            // Others Data
            'application_others_data.quote_no' => 'required',
            'application_others_data.client_no' => 'required',
            'application_others_data.client_name' => 'required',
            'application_others_data.required_works' => 'required',
            'application_others_data.others' => 'required',
            'application_others_data.services_fees' => 'required',

            // Review Data
            'application_review_data.engineer_category' => 'required',
            'application_review_data.engineer_id' => 'required',
            'application_review_data.building_permit_fees' => 'required',
            'application_review_data.status' => 'required',
            'application_review_data.others' => 'required',

            // Attachement Data (Images)
        ];
    }
}
