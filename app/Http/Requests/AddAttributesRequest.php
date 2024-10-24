<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAttributesRequest extends FormRequest
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
            'product_id'=>'string|exists:products,id',
            'size'=>'required|string|in:S,M,L,XL',
            'price'=>'required|numeric',
            'offer_price'=>'required|numeric',
            'stock'=>'required|integer'
        ];
    }
}
