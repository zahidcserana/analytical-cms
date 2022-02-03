<?php

namespace App\Http\Requests\PurchaseItem;

use App\Http\Requests\FormRequest;

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
            'purchase_id' => ['required', 'exists:purchases,id,deleted_at,NULL'],
            'description' => ['sometimes'],
            'size' => ['sometimes'],
            'quantity' => ['required'],
            'price' => ['required'],
            'amount' => ['sometimes'],
        ];
    }
}
