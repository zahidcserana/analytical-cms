<?php

namespace App\Http\Requests\Customer;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'id' => ['required', 'exists:customers,id,deleted_at,NULL'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20', Rule::unique('customers')->ignore($this->id)],
            'email' => ['string', 'email', 'max:255'],
            'phone' => ['sometimes'],
            'address' => ['sometimes'],
            'status' => ['sometimes'],
            'balance' => ['sometimes'],
        ];
    }
}
