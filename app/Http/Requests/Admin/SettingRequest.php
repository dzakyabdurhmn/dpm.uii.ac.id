<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Settings keys that may be stored through this form.
     *
     * @var list<string>
     */
    public const KEYS = [
        'site_name',
        'site_tagline',
        'site_logo',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'about_text',
        'contact_email',
        'contact_phone',
        'contact_address',
        'footer_text',
        'social_instagram',
        'social_linkedin',
        'social_twitter',
        'social_facebook',
        'social_youtube',
        'meta_description',
    ];

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
            'site_name' => ['required', 'string', 'max:100'],
            'site_tagline' => ['nullable', 'string', 'max:160'],
            'site_logo' => ['nullable', 'string', 'max:2048'],
            'hero_title' => ['nullable', 'string', 'max:160'],
            'hero_subtitle' => ['nullable', 'string', 'max:400'],
            'hero_image' => ['nullable', 'string', 'max:2048'],
            'about_text' => ['nullable', 'string', 'max:2000'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string', 'max:255'],
            'footer_text' => ['nullable', 'string', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_linkedin' => ['nullable', 'url', 'max:255'],
            'social_twitter' => ['nullable', 'url', 'max:255'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:320'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'site_name.required' => 'Nama situs wajib diisi.',
            'contact_email.email' => 'Format email kontak tidak valid.',
            'social_instagram.url' => 'URL Instagram harus diawali http:// atau https://.',
            'social_linkedin.url' => 'URL LinkedIn harus diawali http:// atau https://.',
            'social_twitter.url' => 'URL X harus diawali http:// atau https://.',
            'social_facebook.url' => 'URL Facebook harus diawali http:// atau https://.',
            'social_youtube.url' => 'URL YouTube harus diawali http:// atau https://.',
        ];
    }
}
