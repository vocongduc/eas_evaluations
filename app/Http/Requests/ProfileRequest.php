<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000',
            'name' => 'required|min:6|max:255',
            'email' => ['required', 'email', 'string', 'max:100', Rule::unique('users')->ignore($this->id)],
            'address' =>  'min:6|max:150',
            'birth_day' => 'date|before:today',
            'phone' => ['numeric', 'digits:10'],
            'password' => 'nullable|string|max:50',
            'password_confirm' => 'required_with:password|same:password'

        ];
    }
}
