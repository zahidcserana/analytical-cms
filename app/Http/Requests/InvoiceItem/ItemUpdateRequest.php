<?php

namespace App\Http\Requests\InvoiceItem;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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
            'id' => ['required', 'exists:invoices,id,deleted_at,NULL'],
            'customer_id' => ['required', 'exists:customers,id,deleted_at,NULL'],
            'invoice_no' => ['sometimes'],
            'receive_no' => ['sometimes'],
            'total' => ['sometimes'],
            'discount' => ['sometimes'],
            'paid' => ['sometimes'],
            'status' => ['sometimes'],
        ];
    }
}
