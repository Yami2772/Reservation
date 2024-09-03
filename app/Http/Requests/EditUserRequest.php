<?php

namespace App\Http\Requests;

use App\Enums\UserSex;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EditUserRequest extends FormRequest
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
            'full_name' => 'max:30',
            'phone_number' => 'digits:11|numeric|unique:users,phone_number',
            'password' => 'min:8|password',
            'national_code' => 'numeric|digits:10|unique:users,national_code',
            'sex' => [new Enum(UserSex::class)],
        ];
    }
}
