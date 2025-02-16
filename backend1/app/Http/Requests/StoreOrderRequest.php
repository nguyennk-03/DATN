<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // For now, we can allow everyone to create orders. Adjust if needed.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|max:255',
            'total_price' => 'required|numeric|min:0',
            'payment_status' => 'required|string|max:255',
            'items' => 'required|array|min:1', // You can modify this based on how the items are structured
            // Add additional validation for each item in the order if needed
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'status.required' => 'The status field is required.',
            'total_price.required' => 'The total price is required.',
            'payment_status.required' => 'The payment status is required.',
            'items.required' => 'The order must contain at least one item.',
            // Customize messages for other validation rules as needed
        ];
    }
}
