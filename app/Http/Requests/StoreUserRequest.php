<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:4',
            'phone'=>'required|string',
            'address'=>'nullable|string',
            'photo'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role'=>'required|in:admin,vendor,customer',
            'status'=>'required|in:active,inactive'
        ];
    }
}
