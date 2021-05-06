<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'reset_otp' => 'string|required|min:8',
            'user_id' => 'required',
            'password' => 'string|required|min:8|max:32',
        ];
    }
}
