<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:5|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:25',
            'phone_number' => 'required|digits:10',
        ];
    }

    /**
     * Get the validation error message that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function messages(): array {
        return[
            'name.required' => 'Please enter your name',
            'name.min' => 'Name must be atleast 5 chars long',
            'name.max' => 'Name must not be more than 50 chars',
            'email.required' => 'Please enter your email',
            'name.email' => 'Email must be a valid email address',
            'name.unique' => 'Email is already taken, please try with other email address',
            'password.required' => 'Please enter your password',
            'name.min' => 'Password must be atleast 5 chars long',
            'name.max' => 'Password must not be more than 25 chars',
            'phone_number.required' => 'Please enter your phone_number',
            'phone_number.digits' => 'Phone mumber must be 10 digits number',
        ];
    }
}
