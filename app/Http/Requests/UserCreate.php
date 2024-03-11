<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreate extends FormRequest
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
            'username' => 'required|unique:users,username|alpha_dash|regex:/^\S*$/',
            'password' => 'required|min:8',
            'phone' => 'required|unique:users,phone|regex:/^09[0-5]-[0-9]{7}/',
            'role' => 'required',
            'user_photo' => 'image|mimes:jpeg,png,PNG,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم الشخصي مطلوب',
            'username.required' => 'اسم المستخدم مطلوب',
            'username.unique' => 'هذا الاسم موجود لمستخدم اخر',
            'username.regex' => 'يجب على الاسم ان لا يحتوي على فراغ',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'يجب على كلمة المرور ان تكون 8 احرف فأكثر',
            'phone.regex' => 'يجب على رقم الهاتف ان يكون بالصيغة التالية (09X-XXXXXXX)',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.unique' => 'هذا الهاتف موجود لمستخدم اخر',
            'role.required' => 'الصلاحية مطلوبة',
        ];
    }
}