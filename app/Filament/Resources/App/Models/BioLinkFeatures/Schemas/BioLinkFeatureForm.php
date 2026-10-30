<?php

namespace App\Filament\Resources\App\Models\BioLinkFeatures\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BioLinkFeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sorotan')
                    ->schema([
                        Select::make('bio_link_id')
                            ->label('Bio Link')
                            ->relationship('bioLink', 'site_name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('eyebrow')
                            ->label('Eyebrow (Label kecil)')
                            ->maxLength(100),
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(500),
                        TextInput::make('button_text')
                            ->label('Teks Tombol')
                            ->default('Lihat Selengkapnya')
                            ->maxLength(100),
                        TextInput::make('button_url')
                            ->label('URL Tombol')
                            ->required()
                            ->url()
                            ->maxLength(2048),
                        TextInput::make('icon')
                            ->label('Ikon (Heroicons name)')
                            ->placeholder('Contoh: arrow-trending-up, academic-cap')
                            ->maxLength(100),
                    ])->columns(2),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),
            ]);
    }
}
