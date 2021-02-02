<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'active' => 'required|min:1|max:1',
            'first_name' => 'required|min:2|max:100',
            'last_name' => 'required|min:2|max:100',
            'country' => 'required|min:2|max:100',
            'region' => 'required|min:2|max:100',
            'city' => 'required|min:2|max:100',
            'document' => 'required|min:2|max:100|unique:clients,document,' . $this->route('client')->id,
        ];
    }
}
