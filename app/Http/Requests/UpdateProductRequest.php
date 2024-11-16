<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title'=>'nullable|string',
            'summary'=>'nullable|string',
            'description'=>'nullable|string',
            'additional_info'=>'nullable|string',
            'return_and_cancellation'=>'nullable|string',
            'stock'=>'nullable|integer',
            'price'=>'nullable|numeric',
            'discount'=>'nullable|numeric',
            'images.*'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id'=>'nullable|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'vendor_id'=>'nullable|exists:users,id',
            'category_child_id'=>'nullable|exists:categories,id',
            'size'=>'nullable',
            'condition'=>'nullable|in:new,popular,winter',
            'status'=>'nullable|in:active,inactive'
        ];
    }
}
