<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 

        $response = response()->json([
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $errors->messages(),
        ], Response::HTTP_BAD_REQUEST);

        throw new HttpResponseException($response);
    }
    
}