<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_id'=>'required|distinct|integer|exists:users,id',
            'product_ids'=>'required|array',
            'product_ids.*'=>'required|distinct|integer|exists:products,id',
            'product_quantities'=>'required|array',
            'product_quantities.*'=>'required|integer',
            'coupon'=>'required|numeric',
            'payment_method'=>'required|string|in:COD,Paypal',
            'payment_status'=>'required|string|in:paid,unpaid',
            'condition'=>'required|string|in:pending,processing,delivered,cancelled',
            'delivery_charge'=>'required|numeric',
            'notes'=>'nullable|string',
            'payment_details'=>'nullable|string'
        ];
    }
}
