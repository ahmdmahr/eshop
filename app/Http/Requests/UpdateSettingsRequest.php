<?php

namespace App\Http\Requests;

use App\Models\Settings;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
        $currentSettings = Settings::first();

        return [
            'title' => 'required|string',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'logo' => [
                'sometimes',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                // $attribute: This is the name of the input field being validated. For example, if you're validating a field called logo, $attribute will contain the string "logo".

                // $value: This is the actual value submitted for that input field. If the user uploads a file or provides some input, $value will hold that data. If the field is not filled out, $value will be null.
                
                function ($attribute, $value, $fail) use ($currentSettings) {
                    if (is_null($value) && empty($currentSettings->logo)) {
                        $fail('The logo field is required when no existing logo is present.');
                    }
                },
            ],
            'favicon' => [
                'sometimes',
                'image',
                'mimes:ico,jpeg,png,jpg,gif',
                'max:2048',
                function ($attribute, $value, $fail) use ($currentSettings) {
                    if (is_null($value) && empty($currentSettings->favicon)) {
                        $fail('The favicon field is required when no existing favicon is present.');
                    }
                },
            ],
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'fax' => 'required|string|max:20',
            'footer' => 'required|string',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'pinterest' => 'nullable|url|max:255',
        ];
    }
}
