<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required|min:4|max:55',
            'email' => ['required','email', Rule::unique('users')->ignore($this->id)],
            'avatar' => 'mimes:png,jpg,jpeg|max:2048',
            'address' => 'required',
            'birthDate' => 'required|date|before:today',
            'role' => 'required',
            'phoneNumber' => ['required','numeric', 'digits:10'],
        ];
    }
}
