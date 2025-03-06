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
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:50|unique:users,email,'.$this->user?->id,
            'country' => 'required|min:3|max:255|string',
            'education' => 'required|min:3|max:255|string',
            'experience' => 'required|min:3|max:255|string',
            'state' => 'required|min:3|max:255|string',
            'bio' => 'required|min:3|max:500|string',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }
}
