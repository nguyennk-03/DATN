<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Modify based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|unique:discounts,code', // Unique discount code
            'discount_type' => 'required|in:percentage,flat', // Valid types
            'value' => 'required|numeric|min:0', // Valid value
            'start_date' => 'required|date|after_or_equal:today', // Discount start date must be today or later
            'end_date' => 'required|date|after:start_date', // End date must be after start date
            'max_uses' => 'nullable|integer|min:0', // Optional max uses
        ];
    }
}
