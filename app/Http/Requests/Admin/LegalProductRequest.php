<?php

namespace App\Http\Requests\Admin;

use App\Models\LegalProduct;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class LegalProductRequest extends FormRequest
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
        $numbered = LegalProduct::isNumberedType((string) $this->input('type'));
        $isGbhkm = $this->input('type') === 'gbhkm';

        return [
            'type' => ['required', Rule::in(array_keys(LegalProduct::TYPES))],
            'number' => [Rule::requiredIf($numbered), 'nullable', 'integer', 'min:1', 'max:999'],
            'year' => [Rule::requiredIf($numbered), 'nullable', 'integer', 'min:2000', 'max:2100'],
            'edition' => ['nullable', 'string', 'max:50'],
            'period_id' => [Rule::requiredIf($isGbhkm), 'nullable', 'integer', 'exists:periods,id'],
            'amends_id' => ['nullable', 'integer', 'exists:legal_products,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['nullable', 'string', Rule::in(['aktif', 'tidak_aktif'])],
            'file' => ['nullable', 'file', 'max:20480', 'mimes:pdf,doc,docx'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'enacted_on' => ['nullable', 'date'],
            'forum' => ['nullable', 'string', 'max:150'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $hasFile = $this->hasFile('file');
            /** @var LegalProduct|null $existing */
            $existing = $this->route('legal_product');

            if (! $hasFile && ! $existing?->file_path) {
                $validator->errors()->add('file', 'Produk hukum wajib diunggah sebagai berkas PDF/DOC. Tautan luar tidak diperbolehkan.');
            }

            if ($this->input('amends_id') && $existing?->getKey() === (int) $this->input('amends_id')) {
                $validator->errors()->add('amends_id', 'Dokumen tidak bisa mengubah dirinya sendiri.');
            }

            if ($this->input('amends_id')) {
                $parent = LegalProduct::query()->find($this->input('amends_id'));

                if ($parent && $parent->type !== $this->input('type')) {
                    $validator->errors()->add('amends_id', 'Dokumen yang diubah harus berjenis sama.');
                }
            }

            if ($this->input('type') === 'gbhkm' && filled($this->input('period_id'))) {
                $taken = LegalProduct::query()
                    ->ofType('gbhkm')
                    ->where('period_id', $this->input('period_id'))
                    ->when($existing, fn ($query) => $query->whereKeyNot($existing->getKey()))
                    ->exists();

                if ($taken) {
                    $validator->errors()->add('period_id', 'Sudah ada GBHKM untuk periode ini. Satu periode kepengurusan hanya boleh memiliki satu GBHKM.');
                }
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $type = (string) $this->input('type');
        $numbered = LegalProduct::isNumberedType($type);

        $this->merge([
            'number' => $numbered && filled($this->input('number')) ? $this->input('number') : null,
            'year' => $numbered && filled($this->input('year')) ? $this->input('year') : null,
            'slug' => filled($this->input('slug')) ? $this->input('slug') : null,
            'period_id' => filled($this->input('period_id')) ? $this->input('period_id') : null,
            'amends_id' => filled($this->input('amends_id')) ? $this->input('amends_id') : null,
            'published_at' => filled($this->input('published_at')) ? $this->input('published_at') : null,
            'enacted_on' => filled($this->input('enacted_on')) ? $this->input('enacted_on') : null,
            'forum' => filled($this->input('forum')) ? $this->input('forum') : null,
            'is_published' => $this->boolean('is_published'),
            'sort_order' => (int) $this->input('sort_order', 0),
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Jenis produk hukum wajib dipilih.',
            'number.required' => 'Nomor peraturan wajib diisi untuk PKM/PDPM.',
            'year.required' => 'Tahun peraturan wajib diisi untuk PKM/PDPM.',
            'title.required' => 'Judul / pokok peraturan wajib diisi.',
            'period_id.required' => 'Periode kepengurusan wajib dipilih untuk GBHKM.',
            'file.mimes' => 'Berkas produk hukum harus PDF, DOC, atau DOCX.',
        ];
    }
}
