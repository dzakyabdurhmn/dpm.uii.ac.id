<?php

namespace App\Filament\Resources\App\Models\BioLinks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BioLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nama Situs')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('tagline')
                            ->label('Tagline')
                            ->maxLength(255),
                        TextInput::make('handle')
                            ->label('Handle (Username)')
                            ->maxLength(50),
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('bio-link')
                            ->maxSize(2048),
                        TextInput::make('theme_color')
                            ->label('Warna Tema')
                            ->maxLength(7)
                            ->default('#001E43'),
                    ])->columns(2),

                Section::make('Deskripsi & Alamat')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3),
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(2),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Telepon/WhatsApp')
                            ->maxLength(20),
                    ])->columns(2),

                Section::make('Media Sosial')
                    ->schema([
                        KeyValue::make('social_links')
                            ->label('Tautan Media Sosial')
                            ->keyLabel('Platform')
                            ->valueLabel('URL')
                            ->addActionLabel('Tambah Platform')
                            ->default([
                                'instagram' => '',
                                'twitter' => '',
                                'linkedin' => '',
                                'youtube' => '',
                                'whatsapp' => '',
                            ]),
                    ]),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),
            ]);
    }
}
