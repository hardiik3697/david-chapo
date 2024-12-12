<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        if($this->method() == 'PATCH'){
            return [
                'firstname' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'lastname' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'username' => 'regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'required|email|unique:users,email,'.$this->id,
                'phone' => 'nullable|digits:10|unique:users,phone,'.$this->id,
                'role' => 'required',
            ];
        }else{
            return [
                'firstname' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'lastname' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'username' => 'regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|digits:10|unique:users,phone',
                'role' => 'required',
            ];
        }
    }

    public function messages(){
        return [
            'firstname.required' => 'Please enter firstname',
            'firstname.regex' => 'Please enter correct firstname',
            'firstname.max' => 'Please enter firstname maximum 255 characters',
            'lastname.required' => 'Please enter lastname',
            'lastname.regex' => 'Please enter correct lastname',
            'lastname.max' => 'Please enter lastname maximum 255 characters',
            'username.required' => 'Please enter username',
            'username.regex' => 'Please enter correct username',
            'username.max' => 'Please enter username maximum 255 characters',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'email.unique' => 'Please enter unique email',
            'phone.required' => 'Please enter phone number',
            'phone.digits' => 'Please enter 10 digit number',
            'phone.unique' => 'Please enter unique phone',
            'role.required' => 'Please Select role'
        ];
    }
}
