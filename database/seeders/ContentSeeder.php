<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        SiteContent::query()->delete();

        SiteContent::create([
            'key' => 'sambutan',
            'title' => 'Sambutan',
            'body' => 'Ini adalah sambutan dari Ketua DPM UII.',
            'period_id' => null,
        ]);

        $this->command->info('Content seeder completed.');
    }
}
