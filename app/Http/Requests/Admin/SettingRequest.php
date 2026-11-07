<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public const KEYS = [
        'contact_email',
        'contact_phone',
    ];

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'contact_email' => ['nullable', 'email', 'max:150'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'contact_email.email' => 'Format email kontak tidak valid.',
        ];
    }
}
