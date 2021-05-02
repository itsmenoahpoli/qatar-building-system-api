<?php

namespace App\Http\Requests\Applications;

use Illuminate\Foundation\Http\FormRequest;

class CreateApplicationReviewRequest extends FormRequest
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
            'application_record_id' => 'required',
            'engineer_category' => 'required',
            'engineer_category_name' => 'required',
            'status' => 'required',
            'comments' => 'min:3|max:100'
        ];
    }
}
