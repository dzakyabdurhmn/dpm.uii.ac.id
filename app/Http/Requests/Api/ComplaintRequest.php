<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:100', 'required_unless:is_anonymous,true'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'category' => ['nullable', 'string', 'max:100'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            'is_anonymous' => ['nullable', 'boolean'],
            'attachment' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required_unless' => 'Nama wajib diisi kecuali pengaduan dikirim secara anonim.',
            'email.required' => 'Email wajib diisi agar kami bisa menghubungi Anda.',
            'message.min' => 'Uraian pengaduan minimal 20 karakter.',
            'attachment.mimes' => 'Lampiran harus berupa PDF, gambar, atau dokumen Office.',
            'attachment.max' => 'Ukuran lampiran maksimal 5 MB.',
        ];
    }
}
