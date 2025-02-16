<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can add authorization logic here if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'order_id' => 'required|exists:orders,id', // Ensure the order exists in the 'orders' table
            'payment_method' => ['required', Rule::in(['momo', 'vnpay', 'paypal', 'cod'])], // Validate payment method
        ];
    }

    /**
     * Get the custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'order_id.required' => 'The order ID is required.',
            'order_id.exists' => 'The order does not exist or is invalid.',
            'payment_method.required' => 'The payment method is required.',
            'payment_method.in' => 'The payment method must be one of the following: momo, vnpay, paypal, cod.',
        ];
    }
}
