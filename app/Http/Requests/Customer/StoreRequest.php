<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20', 'unique:customers'],
            'email' => ['string', 'email', 'max:255'],
            'phone' => ['sometimes'],
            'address' => ['sometimes'],
            'status' => ['sometimes'],
        ];
    }
}
