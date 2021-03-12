<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestRequest extends FormRequest
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
            'name' => 'required|min:5|max:100',
            'expire' => 'required',
            'active' => 'required|min:1|max:1',
            'comments' => 'min:5|max:520',
            'response_address' => 'required|min:5|max:100',
            'response_name' => 'required|min:5|max:100',
            'response_email' => 'required|min:5|max:100',
            'response_document' => 'required|min:5|max:100',
            'response_type' => 'required|min:5|max:100',
            'status_id' => 'required',
            'user_id' => 'required',
            'from_area_id' => 'required',
            'from_department_id' => 'required',
            'to_area_id' => 'required',
            'to_department_id' => 'required',
            'type_id' => 'required',
            'company_id' => 'required'

        ];
    }
}
