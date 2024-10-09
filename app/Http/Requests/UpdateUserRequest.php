<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'full_name'=>'required|string',
            'username'=>'nullable|string',
            // $this->route('user') is used within a form request class to retrieve a specific route parameter. It allows you to access route parameters passed to the request, which can be useful for validation rules.
            //'unique:table,column,except_id'
            'email' => 'required|email|unique:users,email,' . $this->route('user'),
            'phone'=>'required|string',
            'address'=>'nullable|string',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role'=>'required|in:admin,vendor,customer',
            'status'=>'required|in:active,inactive'
        ];
    }
}
