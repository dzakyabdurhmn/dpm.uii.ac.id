<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\View\View;

class BioLinkController extends Controller
{
    /**
     * Tautan eksternal resmi DPM UII.
     */
    private const SOP_KUNJUNGAN_URL = 'https://drive.google.com/file/d/1xJGAk8FctatV3Gc5QWZxQMAKVcssZpFj/view?usp=sharing';

    private const DANA_TAKTIS_FORM_URL = 'https://forms.gle/UqzHq6sr1FsNWUpe7';

    private const WEBSITE_URL = 'https://dpm.uii.ac.id/';

    public function index(): View
    {
        $settings = Setting::map();

        return view('site.bio-link', [
            'bioLink' => (object) [
                'site_name' => $settings['site_name'] ?? 'DPM UII',
                'tagline' => $settings['site_tagline'] ?? 'Dewan Permusyawaratan Mahasiswa UII',
                'handle' => '@dpmuii',
                'description' => $settings['meta_description'] ?? 'Portal resmi DPM UII.',
                'logo' => asset('images/logo-dpm.svg'),
                'theme_color' => '#001E43',
                'social_links' => $this->socialLinks($settings),
                'address' => $settings['contact_address'] ?? null,
                'email' => $settings['contact_email'] ?? null,
                'phone' => $settings['contact_phone'] ?? null,
                'whatsapp_url' => $this->whatsappUrl($settings),
                'sop_kunjungan_url' => self::SOP_KUNJUNGAN_URL,
                'dana_taktis_form_url' => self::DANA_TAKTIS_FORM_URL,
                'website_url' => self::WEBSITE_URL,
                'activeFeatures' => [
                    (object) [
                        'eyebrow' => 'Sorotan',
                        'title' => 'Informasi Terbaru',
                        'description' => 'Ikuti perkembangan terbaru DPM UII melalui portal resmi.',
                        'button_text' => 'Kunjungi Portal',
                        'button_url' => route('home'),
                    ],
                ],
                'activeGroups' => [
                    (object) [
                        'title' => 'Tautan Utama',
                        'activeItems' => [
                            (object) [
                                'title' => 'SOP Penerimaan Kunjungan Lembaga',
                                'description' => 'Panduan alur penerimaan kunjungan lembaga',
                                'url' => self::SOP_KUNJUNGAN_URL,
                                'open_in_new_tab' => true,
                                'icon_type' => 'custom',
                                'icon' => $this->icon('clipboard'),
                            ],
                            (object) [
                                'title' => 'Kebutuhan Administrasi',
                                'description' => 'Logo dan font resmi UII',
                                'url' => route('humas.download'),
                                'open_in_new_tab' => false,
                                'icon_type' => 'custom',
                                'icon' => $this->icon('download'),
                            ],
                            (object) [
                                'title' => 'Formulir Permohonan Dana Taktis',
                                'description' => 'Ajukan permohonan dana taktis DPM UII',
                                'url' => self::DANA_TAKTIS_FORM_URL,
                                'open_in_new_tab' => true,
                                'icon_type' => 'custom',
                                'icon' => $this->icon('money'),
                            ],
                            (object) [
                                'title' => 'Website Resmi DPM UII',
                                'description' => 'Portal resmi dpm.uii.ac.id',
                                'url' => self::WEBSITE_URL,
                                'open_in_new_tab' => true,
                                'icon_type' => 'custom',
                                'icon' => $this->icon('globe'),
                            ],
                            (object) [
                                'title' => 'Peraturan KM UII',
                                'description' => 'Peraturan Keluarga Mahasiswa UII',
                                'url' => route('legal-products.type', 'pkm'),
                                'open_in_new_tab' => false,
                                'icon_type' => 'custom',
                                'icon' => $this->icon('book'),
                            ],
                            (object) [
                                'title' => 'Narahubung DPM UII',
                                'description' => 'Hubungi sekretariat via WhatsApp',
                                'url' => $this->whatsappUrl($settings),
                                'open_in_new_tab' => true,
                                'icon_type' => 'custom',
                                'icon' => $this->icon('whatsapp'),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @param  array<string, string|null>  $settings
     * @return array<int, array{label: string, url: string, svg: string}>
     */
    private function socialLinks(array $settings): array
    {
        return [
            [
                'label' => 'Instagram',
                'url' => $settings['social_instagram'] ?? 'https://www.instagram.com/dpmuii/',
                'svg' => '<svg viewBox="0 0 448 512" aria-hidden="true"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>',
            ],
            [
                'label' => 'WhatsApp',
                'url' => $this->whatsappUrl($settings),
                'svg' => '<svg viewBox="0 0 448 512" aria-hidden="true"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>',
            ],
        ];
    }

    /**
     * Nomor narahubung resmi dalam format tautan wa.me.
     *
     * @param  array<string, string|null>  $settings
     */
    private function whatsappUrl(array $settings): string
    {
        $phone = $settings['contact_phone'] ?? null;

        if (filled($phone)) {
            $digits = preg_replace('/\D+/', '', $phone) ?? '';

            if (str_starts_with($digits, '0')) {
                $digits = '62'.substr($digits, 1);
            }

            if ($digits !== '') {
                return 'https://wa.me/'.$digits;
            }
        }

        return $settings['social_whatsapp'] ?? 'https://wa.me/6281511092004';
    }

    private function icon(string $name): string
    {
        return match ($name) {
            'clipboard' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 2h6a1 1 0 0 1 1 1v2H8V3a1 1 0 0 1 1-1z"/><path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-2"/><path d="m9 14 2 2 4-4"/></svg>',
            'download' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>',
            'money' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
            'globe' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
            'whatsapp' => '<svg class="fill" viewBox="0 0 448 512" fill="currentColor" aria-hidden="true"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>',
            'book' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
            'document' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
            'chat' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
            default => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"/><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"/></svg>',
        };
    }
}
