<?php

namespace App\Http\Requests\Admin;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
            'category' => ['required', 'string', Rule::in(array_keys(Post::CATEGORIES))],
            'type' => ['nullable', 'string', Rule::in(array_keys(Post::SOCIALIZATION_TYPES))],
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150', 'alpha_dash'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'status' => ['required', Rule::in([Post::STATUS_DRAFT, Post::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'string', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:320'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'category' => filled($this->input('category')) ? $this->input('category') : 'berita',
            // Jenis sosialisasi hanya relevan untuk kategori Sosialisasi.
            'type' => $this->input('category') === 'sosialisasi' && filled($this->input('type'))
                ? $this->input('type')
                : null,
            'slug' => filled($this->input('slug')) ? $this->input('slug') : null,
            'published_at' => filled($this->input('published_at')) ? $this->input('published_at') : null,
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita wajib diisi.',
            'category.required' => 'Kategori konten wajib dipilih.',
            'slug.alpha_dash' => 'Slug hanya boleh berisi huruf, angka, dan tanda hubung.',
            'status.required' => 'Status berita wajib dipilih.',
            'published_at.date' => 'Tanggal terbit tidak valid.',
        ];
    }
}
