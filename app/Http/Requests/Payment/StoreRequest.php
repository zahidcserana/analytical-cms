<?php

namespace App\Http\Requests\Payment;

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
