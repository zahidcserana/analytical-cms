<?php

namespace App\Http\Requests\PurchaseItem;

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
            'id' => ['required', 'exists:purchase_items,id,deleted_at,NULL'],
            'purchase_id' => ['required', 'exists:purchases,id,deleted_at,NULL'],
            'description' => ['sometimes'],
            'size' => ['sometimes'],
            'quantity' => ['sometimes'],
            'price' => ['sometimes'],
            'amount' => ['sometimes'],
        ];
    }
}
