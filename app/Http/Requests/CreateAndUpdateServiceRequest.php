<?php

namespace App\Http\Requests;

use App\Enums\ServiceStatus;
use App\Enums\ServiceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateAndUpdateServiceRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:services,name',
            'price' => 'required|numeric|max_digits:8',
            'type' => ['required', new Enum(ServiceType::class)],
            'status' => new Enum(ServiceStatus::class),
            'description' => 'required|array',
            'timing_ids' => 'required|array',
        ];
    }
}
