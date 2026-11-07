<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SiteController extends Controller
{
    /**
     * Identitas situs, hero, kontak, sosial, SEO (navigasi statis di frontend).
     */
    public function settings(): JsonResponse
    {
        $settings = Setting::map();

        return response()->json([
            'data' => [
                'site' => [
                    'name' => $settings['site_name'] ?? config('app.name'),
                    'tagline' => $settings['site_tagline'] ?? null,
                    'logo' => $this->assetUrl($settings['site_logo'] ?? null),
                    'about' => $settings['about_text'] ?? null,
                ],
                'hero' => [
                    'title' => $settings['hero_title'] ?? null,
                    'subtitle' => $settings['hero_subtitle'] ?? null,
                    'image' => $this->assetUrl($settings['hero_image'] ?? null),
                ],
                'contact' => [
                    'email' => $settings['contact_email'] ?? null,
                    'phone' => $settings['contact_phone'] ?? null,
                    'address' => $settings['contact_address'] ?? null,
                ],
                'social' => [
                    'instagram' => $settings['social_instagram'] ?? null,
                    'linkedin' => $settings['social_linkedin'] ?? null,
                    'twitter' => $settings['social_twitter'] ?? null,
                    'facebook' => $settings['social_facebook'] ?? null,
                    'youtube' => $settings['social_youtube'] ?? null,
                ],
                'seo' => [
                    'meta_description' => $settings['meta_description'] ?? null,
                ],
                'footer_text' => $settings['footer_text'] ?? null,
                'sections' => [
                    [
                        'key' => 'sambutan',
                        'title' => 'Sambutan',
                        'subtitle' => 'Sambutan Ketua DPM UII',
                        'url' => '/tentang/sambutan',
                    ],
                ],
                'navigation' => [],
            ],
        ]);
    }

    private function assetUrl(?string $path): ?string
    {
        return filled($path) ? asset($path) : null;
    }
}
