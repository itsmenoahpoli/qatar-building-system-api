<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'string|required|min:2|max:32',
            'last_name' => 'string|required|min:2|max:32',
            'email' => 'email|required|min:3|max:64',
            'password' => 'string|required|min:8|max:16',
            'confirm_password' => 'string|required|min:8|max:16'
        ];
    }
}
