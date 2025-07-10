<?php

namespace Newnet\Zone\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
            'code' => 'required|unique:zone_countries,code,'.$this->route('country'),
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('zone::country.name'),
            'code' => __('zone::country.code'),
        ];
    }
}
