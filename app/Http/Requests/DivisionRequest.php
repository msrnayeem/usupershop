<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (isset($this->id)) {
            return [
                'zone_area' => 'required|string,' . $this->id
            ];
        }
        return [
            'zone_area' => 'required|string'
        ];
    }
}
