<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'url', // Assuming images are an array of URLs or file paths
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Sản phẩm là bắt buộc.',
            'size_id.required' => 'Kích cỡ là bắt buộc.',
            'color_id.required' => 'Màu sắc là bắt buộc.',
            'stock.required' => 'Số lượng là bắt buộc.',
            'images.*.url' => 'Ảnh phải là một URL hợp lệ.',
        ];
    }
}
