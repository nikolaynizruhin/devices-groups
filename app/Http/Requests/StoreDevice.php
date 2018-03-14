<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDevice extends FormRequest
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
            'slug' => [
                'unique:devices',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            ],
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ipv4',
            'mac_address' => [
                'required',
                'regex:/^([0-9A-Fa-f]{2}:){5}([0-9A-Fa-f]{2})$/',
            ],
        ];
    }
}
