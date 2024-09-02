<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAndUpdateReservationRequest extends FormRequest
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
            'service_id' => 'required|digits_between:1,1000',
            'timing_id' => 'required|digits_between:1,6',
            'user_id' => 'required|digits_between:1,1000',
            'date' => 'date_format:Y-m-d',
            'in_contract' => 'nullable|boolean',
        ];
    }
}
