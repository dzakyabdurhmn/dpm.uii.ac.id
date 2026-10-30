<?php

namespace App\Filament\Resources\App\Models\BioLinkItems\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BioLinkItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tautan')
                    ->schema([
                        Select::make('bio_link_group_id')
                            ->label('Grup')
                            ->relationship('group', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(2)
                            ->maxLength(500),
                        TextInput::make('url')
                            ->label('URL')
                            ->required()
                            ->url()
                            ->maxLength(2048),
                        Select::make('icon_type')
                            ->label('Tipe Ikon')
                            ->options([
                                'heroicons' => 'Heroicons',
                                'custom' => 'Custom SVG',
                            ])
                            ->default('heroicons')
                            ->required(),
                        TextInput::make('icon')
                            ->label('Ikon (Heroicons name atau SVG)')
                            ->placeholder('Contoh: academic-cap, document-text, atau paste SVG')
                            ->maxLength(5000),
                    ])->columns(2),

                Section::make('Pengaturan')
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        Toggle::make('open_in_new_tab')
                            ->label('Buka di tab baru')
                            ->default(true),
                    ])->columns(3),
            ]);
    }
}
