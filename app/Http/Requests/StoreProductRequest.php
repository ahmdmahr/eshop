<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'title'=>'required|string',
            'summary'=>'required|string',
            'description'=>'nullable|string',
            'additional_info'=>'nullable|string',
            'return_and_cancellation'=>'nullable|string',
            'stock'=>'required|integer',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric',
            'images.*'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id'=>'required|exists:categories,id',
            'brand_id'=>'required|exists:brands,id',
            'vendor_id'=>'required|exists:users,id',
            'category_child_id'=>'nullable|exists:categories,id',
            'size'=>'required',
            'condition'=>'required|in:new,popular,winter',
            'status'=>'required|in:active,inactive'
        ];
    }
}
