<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutUsRequest extends FormRequest
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
            'heading' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'years_of_experience' => 'required|integer|min:0',
            'happy_customers' => 'required|integer|min:0',
            'parteners' => 'required|integer|min:0',
            'growth' => 'required|numeric|min:0',
        ];
    }
}
