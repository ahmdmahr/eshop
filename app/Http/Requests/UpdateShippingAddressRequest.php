<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingAddressRequest extends FormRequest
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
            'shipping_country' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_postcode' => 'required|string|max:10', 
            'shipping_address' => 'required|string|max:500',
        ];
    }
}
