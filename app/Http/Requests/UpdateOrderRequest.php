<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'user_id'=>'nullable|distinct|integer|exists:users,id',
            'product_ids'=>'nullable|array',
            'product_ids.*'=>'nullable|distinct|integer|exists:products,id',
            'product_quantities'=>'nullable|array',
            'product_quantities.*'=>'nullable|integer',
            // for add or remove products
            'add_or_remove'=>'nullable|array',
            'add_or_remove.*'=>'nullable|string',
            'coupon'=>'nullable|numeric',
            'payment_method'=>'nullable|string|in:COD,Paypal',
            'payment_status'=>'nullable|string|in:paid,unpaid',
            'condition'=>'nullable|string|in:pending,processing,delivered,cancelled',
            'delivery_charge'=>'nullable|numeric',
            'notes'=>'nullable|string',
            'payment_details'=>'nullable|string'
        ];
    }
}
