<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:10240',
                'mimes:jpg,jpeg,png,webp,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx,zip',
            ],
            'alt_text' => ['nullable', 'string', 'max:150'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file.required' => 'Pilih berkas yang ingin diunggah.',
            'file.max' => 'Ukuran berkas maksimal 10 MB.',
            'file.mimes' => 'Format yang didukung: JPG, PNG, WEBP, GIF, SVG, PDF, DOC, XLS, PPT, ZIP.',
        ];
    }
}
