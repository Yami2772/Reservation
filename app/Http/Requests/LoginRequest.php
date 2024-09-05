<?php

namespace App\Http\Requests;

use App\Enums\LoginType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class LoginRequest extends FormRequest
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
            'type' => ['required', new Enum(LoginType::class)],
            'phone_number' => 'required|numeric|digits:11',
            'password' => 'required_if:type,with_password',
            'code' => 'required_if:type,with_password',
        ];
    }
}
