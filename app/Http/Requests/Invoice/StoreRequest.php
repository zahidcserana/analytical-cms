<?php

namespace App\Http\Requests\Invoice;

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
            'invoice_no' => ['required', 'string', 'max:20', 'unique:invoices'],
            'receive_no' => ['sometimes'],
            'total' => ['sometimes'],
            'discount' => ['sometimes'],
            'paid' => ['sometimes'],
            'status' => ['sometimes'],
            'type' => ['sometimes'],
            'invoice_date' => ['sometimes'],
            'created_by' => ['sometimes'],
            'received_by' => ['sometimes'],
        ];
    }
}
