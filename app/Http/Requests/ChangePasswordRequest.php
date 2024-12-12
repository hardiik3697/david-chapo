<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        if($this->method() == 'POST'){
            return [
                'currentPassword' => 'required|min:6|max:12|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
                'newPassword' => 'required|min:6|max:12|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
                'confirmPassword' => 'required|min:6|max:12|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            ];
        }
    }

    public function messages(){
        return [
            'currentPassword.required' => 'Please enter password',
            'currentPassword.min' => 'Minimum password length is 6',
            'currentPassword.max' => 'Maximum password length is 12',
            'currentPassword.regex/[a-z]/' => 'Password must contain at least one lowercase letter',
            'currentPassword.regex/[A-Z]/' => 'Password must contain at least one uppercase letter',
            'currentPassword.regex/[0-9]/' => 'Password must contain at least one digit',
            'newPassword.required' => 'Please enter password',
            'newPassword.min' => 'Minimum password length is 6',
            'newPassword.max' => 'Maximum password length is 12',
            'newPassword.regex/[a-z]/' => 'Password must contain at least one lowercase letter',
            'newPassword.regex/[A-Z]/' => 'Password must contain at least one uppercase letter',
            'newPassword.regex/[0-9]/' => 'Password must contain at least one digit',
            'confirmPassword.required' => 'Please enter password',
            'confirmPassword.min' => 'Minimum password length is 6',
            'confirmPassword.max' => 'Maximum password length is 12',
            'confirmPassword.regex/[a-z]/' => 'Password must contain at least one lowercase letter',
            'confirmPassword.regex/[A-Z]/' => 'Password must contain at least one uppercase letter',
            'confirmPassword.regex/[0-9]/' => 'Password must contain at least one digit',
        ];
    }
}
