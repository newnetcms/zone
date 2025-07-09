<?php

namespace Newnet\Zone\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest
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
            'name' => 'required',
            'province_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('zone::district.name'),
            'province_id' => __('zone::district.province_id'),
        ];
    }
}
