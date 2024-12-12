<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool{
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array{
        return [
            'email' => 'required|email',
            'password' => 'required|min:6|max:12|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/'
        ];
    }

    public function messages(){
        return [
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'password.required' => 'Please enter password',
            'password.min' => 'Minimum password length is 6',
            'password.max' => 'Maximum password length is 12',
            'password.regex/[a-z]/' => 'Password must contain at least one lowercase letter',
            'password.regex/[A-Z]/' => 'Password must contain at least one uppercase letter',
            'password.regex/[0-9]/' => 'Password must contain at least one digit'
        ];
    }
}
