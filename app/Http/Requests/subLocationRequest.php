<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class subLocationRequest extends FormRequest
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
        if (isset($this->id)) {
            return [
                'sub_location_name' => 'required|unique:sub_locations,sub_location_name,' . $this->id
            ];
        }
        return [
            'sub_location_name' => 'required|unique:sub_locations'
        ];
    }
}
