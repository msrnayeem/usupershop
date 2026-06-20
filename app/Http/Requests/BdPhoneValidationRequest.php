<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BdPhoneValidationRequest extends FormRequest
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
     * Supports all Bangladesh phone number formats:
     * - Grameen Phone: +8801[7-9], 8801[7-9], 01[7-9]
     * - Banglalink: +88015, 88015, 015
     * - Vodafone: +8801[36], 8801[36], 01[36]
     * - Robi: +8801[4], 8801[4], 014
     * - Teletalk: +8801[1-2], 8801[1-2], 01[1-2]
     * - BTCL: +8802[0-9], 8802[0-9], 02[0-9]
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => [
                'required',
                'unique:users,mobile',
                'regex:/^(\+?88|0088)?01[0-9]\d{7}$/',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'mobile.required' => 'Mobile number is required.',
            'mobile.unique' => 'This mobile number is already registered.',
            'mobile.regex' => 'Please enter a valid Bangladesh mobile number (e.g., 01XXXXXXXXX).',
        ];
    }
}
