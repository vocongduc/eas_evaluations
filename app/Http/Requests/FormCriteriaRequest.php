<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormCriteriaRequest extends FormRequest
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
            'name' => ['required', 'min:8' , 'max:255', Rule::unique('forms')->ignore($this->form)],
            'main_point_id'=> Rule::requiredIf($this->isMethod('post')),
            'category_id'=> Rule::requiredIf($this->isMethod('post')),
            'criteria_id'=> 'required',
        ];
    }
}
