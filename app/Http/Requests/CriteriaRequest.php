<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CriteriaRequest extends FormRequest
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
            'name' =>['required', 'string', 'min:6', 'max:100', Rule::unique('criterias')->ignore($this->id)],
            'point_max' => ['required','numeric'],
            'point_weight' => ['required','numeric']
        ];
    }
}
