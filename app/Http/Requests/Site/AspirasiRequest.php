<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class AspirasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'kontak' => ['required', 'string', 'max:150'],
            'pesan' => ['required', 'string', 'min:20', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kontak.required' => 'Email atau NIM wajib diisi.',
            'kontak.max' => 'Email atau NIM maksimal 150 karakter.',
            'pesan.required' => 'Aspirasi wajib diisi.',
            'pesan.min' => 'Tulis aspirasi minimal 20 karakter.',
            'pesan.max' => 'Aspirasi maksimal 5000 karakter.',
        ];
    }
}
