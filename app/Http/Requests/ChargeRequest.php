<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChargeRequest extends FormRequest
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
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'username' => 'required|string|max:30|regex:/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/',
            'confirm_username' => 'required|string|max:30|regex:/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/|same:username',
            'platform_id' => 'required',
            'amount' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please insert name',
            'name.regex' => 'Please enter valid name',
            'phone.required' => 'Please insert phone no.',
            'phone.digits' => 'Please enter valid phone no.',
            'email.required' => 'Please insert email address',
            'email.email' => 'Please enter valid email address',
            'username.required' => 'Please enter username',
            'username.max' => 'Username max limit id 30',
            'username.regex' => 'Please enter valid username',
            'confirm_username.required' => 'Please enter username',
            'confirm_username.max' => 'Username max limit id 30',
            'confirm_username.regex' => 'Please enter valid username',
            'confirm_username.same' => 'Please check username',
            'platform_id.required' => 'Please select platform',
            'amount.required' => 'Please select amount',
        ];
    }
}
