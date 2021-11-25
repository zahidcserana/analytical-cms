<?php

namespace App\Http\Requests\Payment;

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
            'id' => ['required', 'exists:payments,id,deleted_at,NULL'],
            'customer_id' => ['required', 'exists:customers,id,deleted_at,NULL'],
            'method' => ['required', 'string'],
            'payload' => ['sometimes'],
            'amount' => ['required'],
            'status' => ['sometimes'],
            'dues' => ['sometimes'],
            'created_by' => ['sometimes'],
            'received_by' => ['sometimes'],
            'receipt_no' => ['sometimes'],
            'bank_details' => ['sometimes'],
        ];
    }
}
