<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
          'old_password' => 'string|required|min:8|max:16',
          'new_password' => 'string|required|min:8|max:16|confirmed',
          'new_password_confirmation' => 'string|required|min:8|max:16'
        ];
    }
}
