<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DocumentRequest extends FormRequest
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
            'document_category_id' => ['required', 'integer', 'exists:document_categories,id'],
            'period_id' => ['nullable', 'integer', 'exists:periods,id'],
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180', 'alpha_dash'],
            'description' => ['nullable', 'string', 'max:2000'],
            'file' => ['nullable', 'file', 'max:20480', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpg,jpeg,png'],
            'external_url' => ['nullable', 'url', 'max:2048'],
            'year' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'quarter' => ['nullable', 'integer', 'in:1,2,3,4'],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $hasFile = $this->hasFile('file');
            $hasLink = filled($this->input('external_url'));

            if (! $hasFile && ! $hasLink && ! $this->route('document')?->file_path) {
                $validator->errors()->add('file', 'Unggah berkas atau isi tautan eksternal (mis. Google Drive).');
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => filled($this->input('slug')) ? $this->input('slug') : null,
            'external_url' => filled($this->input('external_url')) ? $this->input('external_url') : null,
            'period_id' => filled($this->input('period_id')) ? $this->input('period_id') : null,
            'year' => filled($this->input('year')) ? $this->input('year') : null,
            'quarter' => filled($this->input('quarter')) ? $this->input('quarter') : null,
            'published_at' => filled($this->input('published_at')) ? $this->input('published_at') : null,
            'is_featured' => $this->boolean('is_featured'),
            'sort_order' => (int) $this->input('sort_order', 0),
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'document_category_id.required' => 'Kategori dokumen wajib dipilih.',
            'title.required' => 'Judul dokumen wajib diisi.',
            'file.max' => 'Ukuran berkas maksimal 20 MB.',
            'file.mimes' => 'Format berkas tidak didukung.',
            'external_url.url' => 'Tautan eksternal harus berupa URL yang valid.',
            'quarter.in' => 'Triwulan harus antara 1 sampai 4.',
        ];
    }
}
