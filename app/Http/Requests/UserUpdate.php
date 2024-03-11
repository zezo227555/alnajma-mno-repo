<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdate extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'username' => 'required|alpha_dash|regex:/^\S*$/',
            'password' => 'min:8',
            'phone' => 'required|regex:^\+218[0-9]{9}^',
            'role' => 'required',
            'user_photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }



    public function messages(): array
    {
        return [
            'name.required' => 'the name is required',
            'username.required' => 'the username is required',
            'phone.required' => 'the phone is required',
            'role.required' => 'the role is required',
        ];
    }
}
