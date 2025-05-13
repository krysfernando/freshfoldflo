<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomer extends FormRequest
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
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'name' => ['required', 'max:255'],
                'nickname' => ['nullable', 'max:255'],
                'phone_number' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:customers,email'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'required', 'max:255'],
                'nickname' => ['sometimes', 'nullable', 'max:255'],
                'phone_number' => ['sometimes', 'required', 'max:255'],
                'email' => ['sometimes', 'required', 'email', 'max:255', 'unique:customers,email'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        if($this->phoneNumber) {
            $this->merge([
                'phone_number' => $this->phoneNumber,
            ]);
        }
    }
}
