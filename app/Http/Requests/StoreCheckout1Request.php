<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckout1Request extends FormRequest
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
            'email'=>'required|email',
            'phone'=>'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10', 
            'address' => 'required|string|max:500',
            'shipping_country' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_postcode' => 'nullable|string|max:10', 
            'shipping_address' => 'nullable|string|max:500',
            'notes'=>'nullable|string',
            'sub_total'=>'nullable|numeric',
            'total'=>'nullable|numeric',
        ];
    }
}
