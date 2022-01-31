<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\PurchaseItem\StoreRequest as PurchaseItemStoreRequest;

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
        $rules = [
            'supplier_id' => ['required', 'exists:suppliers,id,deleted_at,NULL'],
            'purchase_no' => ['required', 'string', 'max:20', 'unique:purchases'],
            'total' => ['sometimes'],
            'discount' => ['sometimes'],
            'paid' => ['sometimes'],
            'status' => ['sometimes'],
            'purchase_date' => ['sometimes'],
            'item' => ['required'],
            'item.description' => ['sometimes', 'array'],
            'item.size' => ['sometimes', 'array'],
            'item.quantity' => ['required', 'array'],
            'item.price' => ['required', 'array'],
            'item.amount' => ['sometimes', 'array'],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'item.quantity.required' => 'The Item quantity is required',
            'item.price.required' => 'The Item price is required',
        ];
    }
}
