<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        if($this->method() == 'POST'){
            return [
                'firstname' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'lastname' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'required|email|unique:users,email,'.$this->id,
                'username' => 'required|unique:users,username,'.$this->id,
                'phone' => 'required|digits:10|unique:users,phone,'.$this->id
            ];
        }
    }

    public function messages(){
        return [
            'firstname.required' => 'Please enter firstname',
            'firstname.regex' => 'Please enter correct firstname',
            'firstname.max' => 'Please enter name maximum 255 characters',
            'lastname.required' => 'Please enter lastname',
            'lastname.regex' => 'Please enter correct lastname',
            'lastname.max' => 'Please enter name maximum 255 characters',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'email.unique' => 'Please enter unique email',
            'username.required' => 'Please enter username',
            'username.unique' => 'Please enter unique username',
            'phone.required' => 'Please enter phone number',
            'phone.digits' => 'Please enter 10 digit number',
            'phone.unique' => 'Please enter unique phone'
        ];
    }
}
