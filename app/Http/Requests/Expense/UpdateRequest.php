<?php

namespace App\Http\Requests\Expense;

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
            'id' => ['required', 'exists:expenses,id,deleted_at,NULL'],
            'type' => ['sometimes'],
            'bill_no' => ['sometimes'],
            'amount' => ['required'],
            'expense_date' => ['required', 'date:Y-m-d'],
        ];
    }
}
