<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreColorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can modify this if you want to check user permissions
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'color_name' => 'required|string|max:255|unique:colors,color_name',
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'color_name.required' => 'Tên màu là bắt buộc.',
            'color_name.string' => 'Tên màu phải là một chuỗi.',
            'color_name.max' => 'Tên màu không được vượt quá 255 ký tự.',
            'color_name.unique' => 'Tên màu này đã tồn tại.',
        ];
    }
}
