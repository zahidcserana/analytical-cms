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
            'id' => ['required', 'exists:invoice_items,id,deleted_at,NULL'],
            'invoice_id' => ['required', 'exists:invoices,id,deleted_at,NULL'],
            'buyer' => ['sometimes'],
            'style' => ['sometimes'],
            'color' => ['sometimes'],
            'length' => ['sometimes'],
            'width' => ['sometimes'],
            'area' => ['sometimes'],
            'quantity' => ['sometimes'],
            'price' => ['sometimes'],
            'amount' => ['sometimes'],
        ];
    }
}
