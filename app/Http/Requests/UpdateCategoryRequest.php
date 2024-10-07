<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'title'=>'string|required',
            'summary'=>'string|nullable',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_parent'=>'boolean',
            'parent_id'=>'nullable|exists:categories,id',
            'status'=>'nullable|in:active,inactive'
        ];
    }
}
